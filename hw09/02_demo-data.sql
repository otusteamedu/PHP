--
-- Очистка
--
TRUNCATE TABLE movie_attr_values RESTART IDENTITY CASCADE;
TRUNCATE TABLE movie_attr RESTART IDENTITY CASCADE;
TRUNCATE TABLE movie_attr_type RESTART IDENTITY CASCADE;
TRUNCATE TABLE order_details RESTART IDENTITY CASCADE;
TRUNCATE TABLE orders RESTART IDENTITY CASCADE;
TRUNCATE TABLE clients RESTART IDENTITY CASCADE;
TRUNCATE TABLE place_prices RESTART IDENTITY CASCADE;
TRUNCATE TABLE film_sessions RESTART IDENTITY CASCADE;
TRUNCATE TABLE movies RESTART IDENTITY CASCADE;
TRUNCATE TABLE hall_places RESTART IDENTITY CASCADE;
TRUNCATE TABLE halls RESTART IDENTITY CASCADE;


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

-- количество залов для заполнения демо
CREATE OR REPLACE FUNCTION hallsNum() RETURNS INT AS
$$
BEGIN
    RETURN 10;
END;
$$ LANGUAGE plpgsql;

-- количество мест в залах для заполнения демо
CREATE OR REPLACE FUNCTION hallsPlacesNum() RETURNS INT AS
$$
BEGIN
    RETURN 3000;
END;
$$ LANGUAGE plpgsql;

-- количество фильмов для заполнения демо
CREATE OR REPLACE FUNCTION moviesNum() RETURNS INT AS
$$
BEGIN
    RETURN 1000000;
END;
$$ LANGUAGE plpgsql;

-- количество сеансов для заполнения демо
CREATE OR REPLACE FUNCTION filmSessionsNum() RETURNS INT AS
$$
BEGIN
    RETURN 1000000;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION placePricesNum() RETURNS INT AS
$$
BEGIN
    RETURN 1000000;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION clientsNum() RETURNS INT AS
$$
BEGIN
    RETURN 1000000;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ordersNum() RETURNS INT AS
$$
BEGIN
    RETURN 1000000;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION orderDetailsNum() RETURNS INT AS
$$
BEGIN
    RETURN 1000000;
END;
$$ LANGUAGE plpgsql;


--
-- Наполнение демо данными
--

INSERT INTO halls(name)
SELECT get_random_string(10)
FROM generate_series(1, hallsNum())
ON CONFLICT DO NOTHING;

INSERT INTO hall_places(hall_id, hall_place_num)
SELECT floor(random() * (hallsNum())) + 1,
       random() * 100
FROM generate_series(1, hallsPlacesNum())
ON CONFLICT DO NOTHING;


INSERT INTO movies(name)
SELECT get_random_string(200)
FROM generate_series(1, moviesNum())
ON CONFLICT DO NOTHING;

INSERT INTO film_sessions(hall_id, time_from, time_to, movie_id)
SELECT floor(random() * (hallsNum())) + 1,
       get_random_date_time(),
       get_random_date_time(),
       floor(random() * (moviesNum())) + 1
FROM generate_series(1, filmSessionsNum())
ON CONFLICT DO NOTHING;

INSERT INTO place_prices(hall_place_id, film_session_id, price)
SELECT floor(random() * (hallsPlacesNum())) + 1,
       floor(random() * (filmSessionsNum())) + 1,
       random() * 1000::FLOAT
FROM generate_series(1, placePricesNum())
ON CONFLICT DO NOTHING;


INSERT INTO clients(first_name, last_name)
SELECT get_random_string(5),
       get_random_string(7)
FROM generate_series(1, clientsNum())
ON CONFLICT DO NOTHING;


INSERT INTO orders(client_id, datetime)
SELECT floor(random() * (clientsNum())) + 1,
       get_random_date_time()
FROM generate_series(1, ordersNum())
ON CONFLICT DO NOTHING;

INSERT INTO order_details(order_id, film_session_id, hall_place_id, price)
SELECT floor(random() * (ordersNum())) + 1,
       floor(random() * (filmSessionsNum())) + 1,
       floor(random() * (hallsPlacesNum())) + 1,
       random() * 1000::FLOAT
FROM generate_series(1, orderDetailsNum())
ON CONFLICT DO NOTHING;
