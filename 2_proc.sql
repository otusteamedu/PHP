create or replace function movie_attr_type_get_id(_name varchar) returns int as
$$
declare
    _id int;
begin
    select id
    into _id
    from movie_attr_type
    where name = _name;

    if _id is null
    then
        raise exception 'type % not found', _name;
    end if;

    return _id;
end;
$$ language plpgsql;

create or replace procedure movie_attr_add(_name varchar, _type_name varchar)
    language plpgsql as
$$
declare
    _type_id int = movie_attr_type_get_id(_type_name);
begin
    insert into movie_attr (name, type_id)
    values (_name, _type_id);
end;
$$;


create or replace procedure movie_set_attr(_movie_id int, _attr_name varchar, _attr_val anyelement)
    language plpgsql as
$$
declare
    _attr_id   int;
    _attr_type varchar;
begin
    select
        ma.id,
        mat.name
    into _attr_id, _attr_type
    from movie_attr ma
         inner join movie_attr_type mat on ma.type_id = mat.id
    where ma.name = _attr_name;

    if _attr_id is null
    then
        raise exception 'attr % not found', _attr_name;
    end if;

    execute format(
            'insert into movie_attr_value (movie_id, attr_id, %I)
             values ($1, $2, $3)
             on conflict on constraint movie_attr_unique
             do update set %I = $4',
            _attr_type, _attr_type
        )
        using _movie_id, _attr_id, _attr_val, _attr_val;
end;
$$;
