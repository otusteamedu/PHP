create or replace function get_index_size(_name varchar)
    returns varchar
    language sql
as $$
    select
        pg_size_pretty(relpages::bigint * 8 * 1024) as size
    from pg_catalog.pg_class
    where relkind = 'i'
      and relname = _name
    order by relpages desc;
$$;



create or replace function get_table_size(_name varchar)
    returns text
    language sql
as $$
    select 'total_size: ' || pg_size_pretty(pg_total_relation_size(_name))
        || ', table_size: ' || pg_size_pretty(pg_table_size(_name))
        || ', index_size: ' || pg_size_pretty(pg_indexes_size(_name));
$$;



create or replace procedure seed_shows(_amount int, _max_movie_id int, _halls_amount int)
    language plpgsql
as $$
declare
    _start_at timestamp without time zone;
begin
    for i in 1.._amount
        loop
            _start_at = now() + random() * interval '10 years' - interval '9 years';
            insert into shows (movie_id, hall_id, start_at, end_at, status)
            values (
                       floor(random() * _max_movie_id + 1)::int,
                       floor(random() * _halls_amount + 1)::int,
                       _start_at,
                       _start_at + interval '10 minutes',
                       'actual'
                   )
            on conflict on constraint shows_unique_timerange do nothing;
            if 0 = i % 1000 then commit; end if;
        end loop;
end
$$;



create or replace procedure seed_movies_eav(_from int, _to int)
    language plpgsql
as $$
begin
    set session_replication_role = 'replica';
    for i in _from.._to
        loop
            insert into movie_values (movie_id, attr_id, date, bool, text, numeric)
            values (i, 1, null, null, 'abrakadabra', null),
                   (i, 7, now() + random() * interval '10 years' - interval '9 years', null, null, null),
                   (i, 8, null, null, null, 1000000);
            if 0 = i % 1000 then commit; end if;
        end loop;
    set session_replication_role = 'origin';
end
$$;



create or replace procedure seed_seats(_hall_id int, _rows_amount int, _seats_in_row_amount int)
    language plpgsql
as $$
begin
    for _r in 1.._rows_amount
        loop
            for _s in 1.._seats_in_row_amount
                loop
                    insert into seats (hall_id, row_name, set_name)
                    values (_hall_id, _r, _s)
                    on conflict do nothing;
                end loop;
            commit;
        end loop;
end
$$;



create or replace procedure seed_show_seats(_cost int, variadic _show_ids int[])
    language plpgsql
as $$
declare
    _id int;
begin
    foreach _id in array _show_ids
        loop
            insert into show_seats (cost, show_id, seat_id)
            select _cost, _id, id from seats where hall_id = 1
            on conflict on constraint show_seats_unique do update set cost = _cost;
            commit;
        end loop;
end
$$;



create or replace procedure seed_show_seats(_cost int, _show_ids int4range)
    language plpgsql
as $$
declare
    _id int;
begin
    for _id in lower(_show_ids)..upper(_show_ids)
        loop
            insert into show_seats (cost, show_id, seat_id)
            select _cost, _id, id from seats where hall_id = 1
            on conflict on constraint show_seats_unique do update set cost = _cost;
        end loop;
end
$$;



create or replace procedure seed_tickets(_show_id int, _amount int, _cost int default 100, _client_id int default 1)
    language plpgsql
as $$
declare
    _date timestamp with time zone;
    _uuid varchar;
    _order_id int;
    _row_count int;
begin
    _date = now() + random() * interval '10 years' - interval '9 years';
    _uuid = uuid_generate_v4();

    update show_seats
    set lock_id = _uuid
    where id in (
        select id
        from show_seats
        where show_id = _show_id
          and lock_id is null
          and ticket_id is null
          and cost = _cost
        limit _amount
        for update skip locked
    );

    get diagnostics _row_count = ROW_COUNT;

    if _row_count != _amount
    then
        rollback;
        raise exception 'Not enough seats, available only %', _row_count;
    end if;

    insert into orders (client_id, deadline_at)
    values (_client_id, null)
    returning id into _order_id;

    insert into tickets (cost, order_id, show_id, seat_id, paid_at)
    select cost, _order_id, show_id, seat_id, _date
    from show_seats
    where lock_id = _uuid;

    update show_seats as s
    set lock_id   = null,
        ticket_id = t.id
    from tickets t
    where s.lock_id = _uuid
      and s.show_id = t.show_id
      and s.seat_id = t.seat_id;
end
$$;
