create or replace function random_string(length int) returns text as
$$
declare
    chars  text[] := '{0,1,2,3,4,5,6,7,8,9," ",A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text   := '';
    i      int    := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length
        loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
    return result;
end;
$$ language plpgsql;

create or replace function random_int(max int) returns int as
$$
begin
    if max < 1 then
        raise exception 'Given max cannot be less than 1';
    end if;

    return (1 + random() * (max - 1))::int;
end;
$$ language plpgsql;

create or replace function random_date_time() returns timestamp as
$$
begin
    return (now() + (random() * (interval '20 days')) - (random() * (interval '30 days')));
end;
$$ language plpgsql;

create or replace function number_of_rows(query text)
    returns bigint language plpgsql as $$
declare
    c bigint;
begin
    execute format('select count(*) from (%s) s', query) into c;
    return c;
end $$;


CREATE OR REPLACE PROCEDURE fill(count INT) AS
$$
BEGIN

    DELETE FROM films;
    ALTER SEQUENCE films_id_seq RESTART;

    INSERT INTO films (title, description, duration_minutes) VALUES ('Spiderman', 'Wow, its he', 120);
    INSERT INTO films (title, description, duration_minutes) VALUES ('Spiderman 2', random_string(220), 140);
    INSERT INTO films (title, description, duration_minutes) VALUES ('Batman', random_string(50), 220);
    INSERT INTO films (title, description, duration_minutes) VALUES ('Deadpool', random_string(90), 135);
    INSERT INTO films (title, description, duration_minutes) VALUES ('Lalalend', random_string(130), 135);

    DELETE FROM cinema_halls;
    ALTER SEQUENCE cinema_halls_id_seq RESTART;

    INSERT INTO cinema_halls (title, description, quanity_of_places) VALUES ('1', random_string(10), 130);
    INSERT INTO cinema_halls (title, description, quanity_of_places) VALUES ('2', random_string(10), 130);
    INSERT INTO cinema_halls (title, description, quanity_of_places) VALUES ('3', random_string(10), 150);
    INSERT INTO cinema_halls (title, description, quanity_of_places) VALUES ('4', random_string(10), 70);
    INSERT INTO cinema_halls (title, description, quanity_of_places) VALUES ('5', random_string(10), 210);

    DELETE FROM row;
    ALTER SEQUENCE row_id_seq RESTART;

    DROP SEQUENCE IF EXISTS seq_for_row;
    CREATE SEQUENCE seq_for_row INCREMENT 1
        START 1;

    INSERT INTO row (number, hall_id)
    SELECT  nextval('seq_for_row'::regclass) as number, random_int(5) as hall
    FROM generate_series(1,1000);

    DELETE FROM places;
    ALTER SEQUENCE places_id_seq RESTART;

    DROP SEQUENCE IF EXISTS seq_for_places;
    CREATE SEQUENCE seq_for_places INCREMENT 1
        START 1;

    INSERT INTO places (number, row_id)
    SELECT nextval('seq_for_places'::regclass) as number, random_int(1000) as row_id
    FROM generate_series(1,10000);

    DELETE FROM film_sessions;
    ALTER SEQUENCE film_sessions_id_seq RESTART;

    INSERT INTO film_sessions (film_id, hall_id, session_start, session_end, session_duration)
    SELECT random_int(5), random_int(5), random_date_time(), random_date_time(), random_int(240)
    FROM generate_series(1, div(count,4)::integer);

    DELETE FROM clients;
    ALTER SEQUENCE clients_id_seq RESTART;

    INSERT INTO clients (first_name, middle_name, email, phone)
    SELECT random_string(6), random_string(6), random_string(13), random_string(11)
    FROM generate_series(1, div(count, 4)::integer);

    DELETE FROM orders;
    ALTER SEQUENCE orders_id_seq RESTART;

    INSERT INTO orders(client_id, amount)
    SELECT random_int(div(count, 4)::integer), random_int(5000)
    FROM generate_series(1, div(count, 4)::integer);

    DELETE FROM tickets;
    ALTER SEQUENCE tickets_id_seq RESTART;

    INSERT INTO tickets (order_id, cost, session_id, place_id)
    SELECT random_int(div(count, 4)::integer), random_int(1000), random_int(div(count,4)::integer) as session_id, random_int(10000) as place_id
    FROM generate_series(1, count)
    GROUP BY session_id, place_id;

    DELETE FROM attribute_types;
    ALTER SEQUENCE attribute_types_id_seq RESTART;

    INSERT INTO attribute_types (name) VALUES ('reviews');
    INSERT INTO attribute_types (name) VALUES ('award');
    INSERT INTO attribute_types (name) VALUES ('important_dates');
    INSERT INTO attribute_types (name) VALUES ('service_dates');

    DELETE FROM attributes;
    ALTER SEQUENCE attributes_id_seq RESTART;

    INSERT INTO attributes (name, type, film_id) VALUES ('Оскар', 2, 1);
    INSERT INTO attributes (name, type, film_id) VALUES ('Ника', 2, 2);
    INSERT INTO attributes (name, type, film_id) VALUES ('Ветвь', 2, 2);
    INSERT INTO attributes (name, type, film_id) VALUES ('Золотой глобус', 2, 3);
    INSERT INTO attributes (name, type, film_id) VALUES ('Оскар', 2, 4);
    INSERT INTO attributes (name, type, film_id) VALUES ('Ветвь', 2, 5);
    INSERT INTO attributes (name, type, film_id) VALUES ('Оскар', 2, 5);
    INSERT INTO attributes (name, type, film_id) VALUES ('Отзыв от кинокритика 1', 1, 3);
    INSERT INTO attributes (name, type, film_id) VALUES ('Отзыв от кинокритика 2', 1, 3);
    INSERT INTO attributes (name, type, film_id) VALUES ('Отзыв от кинокритика 1', 1, 1);
    INSERT INTO attributes (name, type, film_id) VALUES ('Отзыв от кинокритика 1', 1, 5);
    INSERT INTO attributes (name, type, film_id) VALUES ('Премьера', 3, 1);
    INSERT INTO attributes (name, type, film_id) VALUES ('Премьера в мире', 3, 2);
    INSERT INTO attributes (name, type, film_id) VALUES ('Премьера в РФ', 3, 3);
    INSERT INTO attributes (name, type, film_id) VALUES ('Премьера в мире', 3, 3);
    INSERT INTO attributes (name, type, film_id) VALUES ('Премьера', 3, 4);
    INSERT INTO attributes (name, type, film_id) VALUES ('Премьера', 3, 5);
    INSERT INTO attributes (name, type, film_id) VALUES ('Дата начала продаж', 3, 1);
    INSERT INTO attributes (name, type, film_id) VALUES ('Дата начала продаж', 3, 2);
    INSERT INTO attributes (name, type, film_id) VALUES ('Дата начала марктинговой кампании', 3, 2);

    DELETE FROM attribute_values;
    ALTER SEQUENCE attribute_values_id_seq RESTART;

    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (1, null, null, null, true, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (2, null, null, null, true, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (3, null, null, null, true, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (4, null, null, null, true, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (5, null, null, null, true, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (6, null, null, null, true, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (7, null, null, null, true, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (8, null, random_string(255), null, null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (9, null, random_string(255), null, null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (10, null, random_string(255), null, null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (11, null, random_string(255), null, null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (12, null, null, random_date_time(), null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (13, null, null, random_date_time(), null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (14, null, null, random_date_time(), null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (15, null, null, random_date_time(), null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (16, null, null, random_date_time(), null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (17, null, null, random_date_time(), null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (18, null, null, random_date_time(), null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (19, null, null, random_date_time(), null, null);
    INSERT INTO attribute_values (attribute_id, int_value, string_value, date_value, boolean_value, float_value) VALUES (20, null, null, random_date_time(), null, null);


END;
$$ LANGUAGE plpgsql;


CALL fill(10000000);