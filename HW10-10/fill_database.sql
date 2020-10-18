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

    INSERT INTO row (number, hall_id)
    SELECT random_int(20) as number, random_int(5) as hall
    FROM generate_series(1,1000)
    GROUP BY number, hall;

    DELETE FROM places;
    ALTER SEQUENCE places_id_seq RESTART;

    INSERT INTO places (number, row_id)
    SELECT random_int(20) as number, random_int(20) as row_id
    FROM generate_series(1,10000)
    GROUP BY number, row_id;

    DELETE FROM film_sessions;
    ALTER SEQUENCE film_sessions_id_seq RESTART;

    INSERT INTO film_sessions (film_id, hall_id, session_start, session_end, session_duration)
    SELECT random_int(5), random_int(5), random_date_time(), random_date_time(), random_int(240)
    FROM generate_series(1, div(count,5)::integer);

END;
$$ LANGUAGE plpgsql;


CALL fill(10000);