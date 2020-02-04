--
-- Вспомогательные функции для генерации корректно связанных данных
--
CREATE OR REPLACE FUNCTION get_random_string(length INTEGER) RETURNS TEXT AS
$$
DECLARE
    chars  TEXT[]  := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result TEXT    := '';
    i      INTEGER := 0;
BEGIN
    IF length < 0 THEN
        RAISE EXCEPTION 'Given length cannot be less than 0';
    END IF;
    FOR i IN 1..length
        LOOP
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        END LOOP;
    RETURN result;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_random_hall_id() RETURNS INT AS
$$
DECLARE
    _id INT := 0;
BEGIN
    SELECT hall_id INTO _id FROM halls ORDER BY random() LIMIT 1;
    RETURN _id;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_random_hall_place_id() RETURNS INT AS
$$
DECLARE
    _id INT := 0;
BEGIN
    SELECT hall_place_id INTO _id FROM hall_places ORDER BY random() LIMIT 1;
    RETURN _id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_random_movie_id() RETURNS INT AS
$$
DECLARE
    _id INT := 0;
BEGIN
    SELECT movie_id INTO _id FROM movies ORDER BY random() LIMIT 1;
    RETURN _id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_random_film_session_id() RETURNS INT AS
$$
DECLARE
    _id INT := 0;
BEGIN
    SELECT film_session_id INTO _id FROM film_sessions ORDER BY random() LIMIT 1;
    RETURN _id;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_random_film_session_id() RETURNS INT AS
$$
DECLARE
    _id INT := 0;
BEGIN
    SELECT film_session_id INTO _id FROM film_sessions ORDER BY random() LIMIT 1;
    RETURN _id;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_random_client_id() RETURNS INT AS
$$
DECLARE
    _id INT := 0;
BEGIN
    SELECT client_id INTO _id FROM clients ORDER BY random() LIMIT 1;
    RETURN _id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_random_order_id() RETURNS INT AS
$$
DECLARE
    _id INT := 0;
BEGIN
    SELECT order_id INTO _id FROM orders ORDER BY random() LIMIT 1;
    RETURN _id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_random_date_time() RETURNS TIMESTAMP AS
$$
BEGIN
    RETURN (now() - (random() * (INTERVAL '100 days')));
END;
$$ LANGUAGE plpgsql;


--
-- Наполнение демо данными
--

INSERT INTO halls(name)
SELECT get_random_string(10)
FROM generate_series(1, 10);

INSERT INTO hall_places(hall_id, hall_place_num)
SELECT get_random_hall_id(), random() * 100
FROM generate_series(1, 100);

INSERT INTO movies(name)
SELECT get_random_string(200)
FROM generate_series(1, 1000);

INSERT INTO film_sessions(hall_id, time_from, time_to, movie_id)
SELECT get_random_hall_id(), get_random_date_time(), get_random_date_time(), get_random_movie_id()
FROM generate_series(1, 10000);

INSERT INTO place_prices(hall_place_id, film_session_id, price)
SELECT get_random_hall_place_id(), get_random_film_session_id(), random() * 1000::FLOAT
FROM generate_series(1, 10000)
ON CONFLICT DO NOTHING;

INSERT INTO clients(first_name, last_name)
SELECT get_random_string(5), get_random_string(7)
FROM generate_series(1, 1000);

INSERT INTO orders(client_id, film_session_id, datetime)
SELECT get_random_client_id(), get_random_film_session_id(), get_random_date_time()
FROM generate_series(1, 1000);

INSERT INTO order_details(order_id, film_session_id, hall_place_id, price)
SELECT get_random_order_id(), get_random_film_session_id(), get_random_hall_place_id(), random() * 1000::FLOAT
FROM generate_series(1, 1000);
