CREATE OR REPLACE FUNCTION random_text_md5(INTEGER)
RETURNS TEXT
LANGUAGE SQL
AS $$
    select upper(
        substring( (SELECT string_agg(md5(random()::TEXT), '') FROM generate_series(1, CEIL($1 / 32.)::integer) ), 1, $1 )
    );
$$;

INSERT INTO film(name) SELECT random_text_md5(14) from generate_series(1, 10000) as gs;
-- > Affected rows: 10000
-- > Time: 0,416s

EXPLAIN ANALYZE SELECT * FROM film;
--  Seq Scan on film  (cost=0.00..72.96 rows=896 width=520) (actual time=0.018..1.804 rows=10004 loops=1)
--  Planning Time: 0.034 ms
--  Execution Time: 2.468 ms
-- (3 rows)

EXPLAIN ANALYZE SELECT entity_id FROM film;
-- Seq Scan on film  (cost=0.00..164.04 rows=10004 width=4) (actual time=0.009..1.975 rows=10004 loops=1)
--  Planning Time: 0.104 ms
--  Execution Time: 2.651 ms
-- (3 rows)

EXPLAIN ANALYZE SELECT name FROM film;
--  Seq Scan on film  (cost=0.00..164.04 rows=10004 width=15) (actual time=0.011..2.092 rows=10004 loops=1)
--  Planning Time: 0.117 ms
--  Execution Time: 2.783 ms
-- (3 rows)

INSERT INTO film(name)
SELECT random_text_md5(10) from generate_series(1, 10000000) as gs;
-- -- > Affected rows: 10000000
-- -- > Time: 240,776s

EXPLAIN ANALYSE SELECT * FROM film WHERE entity_id = 10000000;
-- Index Scan using film_pkey on film  (cost=0.43..8.45 rows=1 width=15) (actual time=0.009..0.009 rows=1 loops=1)
--    Index Cond: (entity_id = 10000000)
--  Planning Time: 0.845 ms
--  Execution Time: 0.021 ms
-- (4 rows)

EXPLAIN ANALYSE SELECT * FROM film WHERE name = '6FDC532BF9';
--  Gather  (cost=1000.00..107251.62 rows=1 width=15) (actual time=1560.515..1564.947 rows=1 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Parallel Seq Scan on film  (cost=0.00..106251.52 rows=1 width=15) (actual time=1520.049..1520.409 rows=0 loops=3)
--          Filter: ((name)::text = '6FDC532BF9'::text)
--          Rows Removed by Filter: 3336668
--  Planning Time: 0.101 ms
--  JIT:
--    Functions: 6
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 2.492 ms, Inlining 0.000 ms, Optimization 1.723 ms, Emission 9.881 ms, Total 14.096 ms
--  Execution Time: 1565.462 ms
-- (12 rows)

DELETE FROM film WHERE entity_id > 4;
ALTER SEQUENCE film_entity_id_seq RESTART WITH 5;

-- after create index

CREATE INDEX ifilmentityid on "film" using btree ("entity_id");
CREATE INDEX ifilmname on "film" using btree ("name");

INSERT INTO film(name)
SELECT random_text_md5(10) from generate_series(1, 10000) as gs;
-- > Affected rows: 10000
-- > Time: 0,333s

EXPLAIN ANALYZE SELECT * FROM film;
--  Seq Scan on film  (cost=0.00..155.04 rows=10004 width=15) (actual time=0.010..1.470 rows=10004 loops=1)
--  Planning Time: 0.194 ms
--  Execution Time: 2.124 ms
-- (3 rows)

EXPLAIN ANALYZE SELECT entity_id FROM film;
-- Seq Scan on film  (cost=0.00..155.04 rows=10004 width=4) (actual time=0.013..2.125 rows=10004 loops=1)
--  Planning Time: 0.050 ms
--  Execution Time: 2.780 ms
-- (3 rows)

EXPLAIN ANALYZE SELECT name FROM film;
--  Seq Scan on film  (cost=0.00..155.04 rows=10004 width=11) (actual time=0.014..2.006 rows=10004 loops=1)
--  Planning Time: 0.062 ms
--  Execution Time: 2.701 ms
-- (3 rows)

INSERT INTO film(name)
SELECT random_text_md5(10) from generate_series(1, 10000000) as gs;
-- > Affected rows: 10000000
-- > Time: 748,104s

EXPLAIN ANALYSE SELECT * FROM film WHERE entity_id = 10000000;
--  Bitmap Heap Scan on film  (cost=4.38..8.40 rows=1 width=15) (actual time=0.018..0.018 rows=1 loops=1)
--    Recheck Cond: (entity_id = 10000000)
--    Heap Blocks: exact=1
--    ->  Bitmap Index Scan on ifilmentityid  (cost=0.00..4.38 rows=1 width=0) (actual time=0.012..0.012 rows=1 loops=1)
--          Index Cond: (entity_id = 10000000)
--  Planning Time: 9.438 ms
--  Execution Time: 0.046 ms
-- (7 rows)

EXPLAIN ANALYSE SELECT * FROM film WHERE name = '8BAE242C09';
--  Index Scan using ifilmname on film  (cost=0.43..8.45 rows=1 width=15) (actual time=0.015..0.015 rows=1 loops=1)
--    Index Cond: ((name)::text = '8BAE242C09'::text)
--  Planning Time: 0.157 ms
--  Execution Time: 0.032 ms
-- (4 rows)

CREATE OR REPLACE FUNCTION random_eav_entity_value(INTEGER) RETURNS void AS
$$
	DECLARE
		 iterator int := 0;
	BEGIN
        WHILE iterator < 8
        LOOP
        iterator := iterator + 1;
        IF iterator < 3 THEN
            INSERT INTO eav_entity_value(entity_type_id, entity_id, attribute_id, value_text, value_bool, value_date)
            SELECT
                1,
                $1,
                iterator,
                'test text',
                NULL,
                CURRENT_DATE;
        ELSIF iterator > 2 AND iterator < 5 THEN
            INSERT INTO eav_entity_value(entity_type_id, entity_id, attribute_id, value_text, value_bool, value_date)
            SELECT
                1,
                $1,
                iterator,
                NULL,
                (round(random())::int)::boolean,
                CURRENT_DATE;
        ELSE
            INSERT INTO eav_entity_value(entity_type_id, entity_id, attribute_id, value_text, value_bool, value_date)
            SELECT
                1,
                $1,
                iterator,
                NULL,
                NULL,
                NOW() + (random() * (interval '1 year'));
        END IF;
        END LOOP;
	END;
$$ LANGUAGE plpgsql;

EXPLAIN ANALYSE SELECT random_eav_entity_value(gs.id) from generate_series(5, 10000) as gs(id);
--  Function Scan on generate_series gs  (cost=0.00..2598.96 rows=9996 width=4) (actual time=22.642..1638.359 rows=9996 loops=1)
--  Planning Time: 0.024 ms
--  Execution Time: 1639.899 ms
-- (3 rows)

EXPLAIN ANALYSE SELECT
        f.name AS film_name,
        eav_a.attribute_value_type AS attribute_type,
        eav_a.attribute_name AS attribute_name,
        eav_v.value_text AS attribute_value_text,
        eav_v.value_bool AS attribute_value_bool,
        eav_v.value_date AS attribute_value_date,
        eav_v.value_int AS attribute_value_int,
        eav_v.value_float AS attribute_value_float
    FROM
        eav_attribute eav_a
    LEFT JOIN eav_entity_value eav_v
    ON
        (eav_a.attribute_id = eav_v.attribute_id)
    LEFT JOIN film f
    ON
        (f.entity_id = eav_v.entity_id)
    WHERE
        eav_v.entity_type_id = 1
    ORDER BY
        film_name, attribute_type;
-- Sort  (cost=3549.13..3549.79 rows=266 width=256) (actual time=490.387..529.491 rows=80000 loops=1)
--   Sort Key: f.name, eav_a.attribute_value_type
--   Sort Method: external merge  Disk: 4080kB
--   ->  Nested Loop Left Join  (cost=18.31..3538.41 rows=266 width=256) (actual time=1.923..299.317 rows=80000 loops=1)
--         ->  Hash Join  (cost=17.88..1294.05 rows=266 width=249) (actual time=0.601..70.670 rows=80000 loops=1)
--               Hash Cond: (eav_v.attribute_id = eav_a.attribute_id)
--               ->  Seq Scan on eav_entity_value eav_v  (cost=0.00..1275.46 rows=266 width=57) (actual time=0.010..24.238 rows=80000 loops=1)
--                     Filter: (entity_type_id = 1)
--               ->  Hash  (cost=13.50..13.50 rows=350 width=200) (actual time=0.580..0.581 rows=8 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on eav_attribute eav_a  (cost=0.00..13.50 rows=350 width=200) (actual time=0.574..0.576 rows=8 loops=1)
--         ->  Index Scan using ifilmentityid on film f  (cost=0.43..8.44 rows=1 width=15) (actual time=0.002..0.002 rows=1 loops=80000)
--               Index Cond: (entity_id = eav_v.entity_id)
-- Planning Time: 34.849 ms
-- Execution Time: 535.212 ms

EXPLAIN ANALYSE SELECT random_eav_entity_value(gs.id) from generate_series(5, 10000000) as gs(id);
-- Function Scan on generate_series gs  (cost=0.00..2599998.96 rows=9999996 width=4) (actual time=2259.295..2117147.868 rows=9999996 loops=1)
-- Planning Time: 0.020 ms
-- JIT:
--   Functions: 4
--   Options: Inlining true, Optimization true, Expressions true, Deforming true
--   Timing: Generation 49.594 ms, Inlining 25.874 ms, Optimization 92.394 ms, Emission 74.087 ms, Total 241.950 ms
-- Execution Time: 2118467.763 ms

EXPLAIN ANALYSE SELECT
        f.name AS film_name,
        eav_a.attribute_value_type AS attribute_type,
        eav_a.attribute_name AS attribute_name,
        eav_v.value_text AS attribute_value_text,
        eav_v.value_bool AS attribute_value_bool,
        eav_v.value_date AS attribute_value_date,
        eav_v.value_int AS attribute_value_int,
        eav_v.value_float AS attribute_value_float
    FROM
        eav_attribute eav_a
    LEFT JOIN eav_entity_value eav_v
    ON
        (eav_a.attribute_id = eav_v.attribute_id)
    LEFT JOIN film f
    ON
        (f.entity_id = eav_v.entity_id)
    WHERE
        eav_v.entity_type_id = 1
		AND f.entity_id = 1
    ORDER BY
        film_name, attribute_type;
-- Gather Merge  (cost=1112216.38..1112230.38 rows=120 width=234) (actual time=46117.725..46121.214 rows=8 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Sort  (cost=1111216.35..1111216.50 rows=60 width=234) (actual time=46082.849..46082.849 rows=3 loops=3)
--         Sort Key: f.name, eav_a.attribute_value_type
--         Sort Method: quicksort  Memory: 26kB
--         Worker 0:  Sort Method: quicksort  Memory: 25kB
--         Worker 1:  Sort Method: quicksort  Memory: 25kB
--         ->  Nested Loop  (cost=18.31..1111214.58 rows=60 width=234) (actual time=30837.807..46082.809 rows=3 loops=3)
--               ->  Hash Join  (cost=17.88..1110706.83 rows=60 width=227) (actual time=30835.827..46080.820 rows=3 loops=3)
--                     Hash Cond: (eav_v.attribute_id = eav_a.attribute_id)
--                     ->  Parallel Seq Scan on eav_entity_value eav_v  (cost=0.00..1110688.80 rows=60 width=35) (actual time=30825.388..46070.379 rows=3 loops=3)
--                           Filter: ((entity_id = 1) AND (entity_type_id = 1))
--                           Rows Removed by Filter: 26666664
--                     ->  Hash  (cost=13.50..13.50 rows=350 width=200) (actual time=31.297..31.297 rows=8 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Seq Scan on eav_attribute eav_a  (cost=0.00..13.50 rows=350 width=200) (actual time=31.286..31.289 rows=8 loops=1)
--               ->  Index Scan using ifilmentityid on film f  (cost=0.43..8.45 rows=1 width=15) (actual time=0.744..0.744 rows=1 loops=8)
--                     Index Cond: (entity_id = 1)
-- Planning Time: 2.461 ms
-- JIT:
--   Functions: 51
--   Options: Inlining true, Optimization true, Expressions true, Deforming true
--   Timing: Generation 9.733 ms, Inlining 191.171 ms, Optimization 518.878 ms, Emission 329.898 ms, Total 1049.680 ms
-- Execution Time: 46123.949 ms

DELETE FROM eav_entity_value WHERE value_id > 32;
ALTER SEQUENCE eav_entity_value_value_id_seq RESTART WITH 33;

-- after create index

CREATE INDEX ientityvaluevalueid on "eav_entity_value" using btree ("value_id");
CREATE INDEX ientityvalueentityid on "eav_entity_value" using btree ("entity_id");
CREATE INDEX ientityvalueattributeid on "eav_entity_value" using btree ("attribute_id");
CREATE INDEX iattributeattributeid on "eav_attribute" using btree ("attribute_id");

EXPLAIN ANALYSE SELECT random_eav_entity_value(gs.id) from generate_series(5, 10000) as gs(id);
-- Function Scan on generate_series gs  (cost=0.00..2598.96 rows=9996 width=4) (actual time=3.477..3342.377 rows=9996 loops=1)
-- Planning Time: 0.022 ms
-- Execution Time: 3380.004 ms

EXPLAIN ANALYSE SELECT
        f.name AS film_name,
        eav_a.attribute_value_type AS attribute_type,
        eav_a.attribute_name AS attribute_name,
        eav_v.value_text AS attribute_value_text,
        eav_v.value_bool AS attribute_value_bool,
        eav_v.value_date AS attribute_value_date,
        eav_v.value_int AS attribute_value_int,
        eav_v.value_float AS attribute_value_float
    FROM
        eav_attribute eav_a
    LEFT JOIN eav_entity_value eav_v
    ON
        (eav_a.attribute_id = eav_v.attribute_id)
    LEFT JOIN film f
    ON
        (f.entity_id = eav_v.entity_id)
    WHERE
        eav_v.entity_type_id = 1
    ORDER BY
        film_name, attribute_type;
-- Sort  (cost=20080.52..20280.52 rows=80000 width=234) (actual time=280.535..319.589 rows=80000 loops=1)
--   Sort Key: f.name, eav_a.attribute_value_type
--   Sort Method: external merge  Disk: 4080kB
--   ->  Hash Join  (cost=1.91..4538.94 rows=80000 width=234) (actual time=0.032..99.225 rows=80000 loops=1)
--         Hash Cond: (eav_v.attribute_id = eav_a.attribute_id)
--         ->  Merge Left Join  (cost=0.73..4216.51 rows=80000 width=42) (actual time=0.017..62.285 rows=80000 loops=1)
--               Merge Cond: (eav_v.entity_id = f.entity_id)
--               ->  Index Scan using ientityvalueentityid on eav_entity_value eav_v  (cost=0.29..2898.29 rows=80000 width=35) (actual time=0.008..27.076 rows=80000 loops=1)
--                     Filter: (entity_type_id = 1)
--               ->  Index Scan using film_pkey on film f  (cost=0.43..313742.36 rows=9999870 width=15) (actual time=0.007..2.427 rows=10000 loops=1)
--         ->  Hash  (cost=1.08..1.08 rows=8 width=200) (actual time=0.010..0.010 rows=8 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on eav_attribute eav_a  (cost=0.00..1.08 rows=8 width=200) (actual time=0.005..0.006 rows=8 loops=1)
-- Planning Time: 0.299 ms
-- Execution Time: 325.345 ms

EXPLAIN ANALYSE SELECT random_eav_entity_value(gs.id) from generate_series(5, 10000000) as gs(id);
-- Function Scan on generate_series gs  (cost=0.00..2599998.96 rows=9999996 width=4) (actual time=2077.314..4328675.110 rows=9999996 loops=1)
-- Planning Time: 0.021 ms
-- JIT:
--   Functions: 4
--   Options: Inlining true, Optimization true, Expressions true, Deforming true
--   Timing: Generation 0.649 ms, Inlining 2.473 ms, Optimization 9.816 ms, Emission 5.337 ms, Total 18.276 ms
-- Execution Time: 4330265.709 ms

EXPLAIN ANALYSE SELECT
        f.name AS film_name,
        eav_a.attribute_value_type AS attribute_type,
        eav_a.attribute_name AS attribute_name,
        eav_v.value_text AS attribute_value_text,
        eav_v.value_bool AS attribute_value_bool,
        eav_v.value_date AS attribute_value_date,
        eav_v.value_int AS attribute_value_int,
        eav_v.value_float AS attribute_value_float
    FROM
        eav_attribute eav_a
    LEFT JOIN eav_entity_value eav_v
    ON
        (eav_a.attribute_id = eav_v.attribute_id)
    LEFT JOIN film f
    ON
        (f.entity_id = eav_v.entity_id)
    WHERE
        eav_v.entity_type_id = 1
    ORDER BY
        film_name, attribute_type;
-- Sort  (cost=94420.89..94420.94 rows=20 width=256) (actual time=107151.200..107151.201 rows=8 loops=1)
--   Sort Key: f.name, eav_a.attribute_value_type
--   Sort Method: quicksort  Memory: 26kB
--   ->  Nested Loop  (cost=9882.58..94420.46 rows=20 width=256) (actual time=30657.135..107151.169 rows=8 loops=1)
--         ->  Index Scan using ifilmentityid on film f  (cost=0.43..8.45 rows=1 width=15) (actual time=2374.477..2374.479 rows=1 loops=1)
--               Index Cond: (entity_id = 1)
--         ->  Nested Loop  (cost=9882.15..94411.80 rows=20 width=249) (actual time=28282.655..104776.682 rows=8 loops=1)
--               ->  Seq Scan on eav_attribute eav_a  (cost=0.00..1.08 rows=8 width=200) (actual time=25.123..25.131 rows=8 loops=1)
--               ->  Bitmap Heap Scan on eav_entity_value eav_v  (cost=9882.15..11801.32 rows=2 width=57) (actual time=13093.815..13093.862 rows=1 loops=8)
--                     Recheck Cond: ((attribute_id = eav_a.attribute_id) AND (entity_id = 1))
--                     Rows Removed by Index Recheck: 115
--                     Filter: (entity_type_id = 1)
--                     Heap Blocks: lossy=8
--                     ->  BitmapAnd  (cost=9882.15..9882.15 rows=489 width=0) (actual time=13092.938..13092.938 rows=0 loops=8)
--                           ->  Bitmap Index Scan on ientityvalueattributeid  (cost=0.00..4784.39 rows=97710 width=0) (actual time=13089.149..13089.149 rows=10000000 loops=8)
--                                 Index Cond: (attribute_id = eav_a.attribute_id)
--                           ->  Bitmap Index Scan on ientityvalueentityid  (cost=0.00..5097.39 rows=97710 width=0) (actual time=0.599..0.599 rows=8 loops=8)
--                                 Index Cond: (entity_id = 1)
-- Planning Time: 0.254 ms
-- Execution Time: 107151.243 ms

EXPLAIN ANALYSE SELECT
        f.name AS film_name,
        eav_a.attribute_value_type AS attribute_type,
        eav_a.attribute_name AS attribute_name,
        eav_v.value_text AS attribute_value_text,
        eav_v.value_bool AS attribute_value_bool,
        eav_v.value_date AS attribute_value_date,
        eav_v.value_int AS attribute_value_int,
        eav_v.value_float AS attribute_value_float
    FROM
        eav_attribute eav_a
    LEFT JOIN eav_entity_value eav_v
    ON
        (eav_a.attribute_id = eav_v.attribute_id)
    LEFT JOIN film f
    ON
        (f.entity_id = eav_v.entity_id)
    WHERE
        eav_v.entity_type_id = 1
		AND
			f.entity_id = 10000000;
    ORDER BY
        film_name, attribute_type;
-- Nested Loop  (cost=2.18..23.97 rows=140 width=234) (actual time=0.035..0.044 rows=8 loops=1)
--   ->  Index Scan using ifilmentityid on film f  (cost=0.43..8.45 rows=1 width=15) (actual time=0.011..0.011 rows=1 loops=1)
--         Index Cond: (entity_id = 10000000)
--   ->  Hash Join  (cost=1.75..14.12 rows=140 width=227) (actual time=0.022..0.029 rows=8 loops=1)
--         Hash Cond: (eav_v.attribute_id = eav_a.attribute_id)
--         ->  Index Scan using ientityvalueentityid on eav_entity_value eav_v  (cost=0.57..12.37 rows=140 width=35) (actual time=0.008..0.011 rows=8 loops=1)
--               Index Cond: (entity_id = 10000000)
--               Filter: (entity_type_id = 1)
--         ->  Hash  (cost=1.08..1.08 rows=8 width=200) (actual time=0.010..0.010 rows=8 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on eav_attribute eav_a  (cost=0.00..1.08 rows=8 width=200) (actual time=0.004..0.006 rows=8 loops=1)
-- Planning Time: 0.222 ms
-- Execution Time: 0.072 ms

CREATE OR REPLACE FUNCTION random_session() RETURNS void AS
$$
    DECLARE
        months INT := 0;
        weeks INT := 0;
        days INT := 0;
        sessions INT := 0;
        newFilmId INT := 4;
        filmId INT:= 4;
        timeText TEXT[] := ARRAY['10:00:00', '10:20:00', '10:30:00', '10:35:00', '13:00:00', '13:20:00', '13:30:00', '13:35:00', '18:00:00', '18:20:00', '18:30:00', '18:35:00' ,'20:00:00', '20:20:00', '20:30:00', '20:35:00'];
        timeTextStr TEXT := '';
        dayIterator date := '2020-09-08';
        dayIteratorText TEXT := '';
    BEGIN
        FOR years IN 1..10 LOOP
            BEGIN
                FOR months IN 1..12 LOOP
                    BEGIN
                        FOR weeks IN 1..4 LOOP
                        BEGIN
                            FOR days IN 1..7 LOOP
                            dayIterator := dayIterator + interval '1' day;
                            dayIteratorText := TO_CHAR(dayIterator, 'YYYY-MM-DD');
                            sessions := 0;
                            BEGIN
                                FOREACH timeTextStr IN ARRAY timeText LOOP
                                sessions := sessions + 1;
                                filmId := filmId + 1;
                                IF sessions % 4 = 0 THEN
                                    INSERT INTO session(film_id, session_start_time, session_status_id)
                                    SELECT
                                            filmId,
                                            TO_TIMESTAMP(dayIteratorText || ' ' || timeTextStr, 'YYYY-MM-DD HH24:MI:SS'),
                                            1;
                                    filmId := newFilmId;
                                ELSE
                                    INSERT INTO session(film_id, session_start_time, session_status_id)
                                    SELECT
                                            filmId,
                                            TO_TIMESTAMP(dayIteratorText || ' ' || timeTextStr, 'YYYY-MM-DD HH24:MI:SS'),
                                            2;
                                END IF;
                                END LOOP;
                            END;
                            END LOOP;
                        END;
                        END LOOP;
                    END;
                    newFilmId := newFilmId + 4;
                END LOOP;
            END;
        END LOOP;
    END;
$$ LANGUAGE plpgsql;

SELECT random_session();

EXPLAIN ANALYSE SELECT * FROM session WHERE session_start_time >= '2021-04-06' AND session_start_time <= '2021-04-08' AND film_id = 33;
-- Seq Scan on session  (cost=0.00..1284.08 rows=1 width=20) (actual time=0.609..11.429 rows=8 loops=1)
--   Filter: ((session_start_time >= '2021-04-06 00:00:00'::timestamp without time zone) AND (session_start_time <= '2021-04-08 00:00:00'::timestamp without time zone) AND (film_id = 33))
--   Rows Removed by Filter: 53768
-- Planning Time: 0.116 ms
-- Execution Time: 11.440 ms

DELETE FROM session WHERE session_id > 16;
ALTER SEQUENCE session_session_id_seq RESTART WITH 17;

-- after create index

CREATE INDEX isessionfilmid on "session" using btree ("film_id");
CREATE INDEX isessionsessionstarttime on "session" using btree ("session_start_time");

EXPLAIN ANALYSE SELECT * FROM session WHERE session_start_time >= '2021-04-06' AND session_start_time <= '2021-04-08' AND film_id = 33;
-- Index Scan using isessionsessionstarttime on session  (cost=0.29..9.03 rows=1 width=20) (actual time=0.014..0.023 rows=8 loops=1)
--   Index Cond: ((session_start_time >= '2021-04-06 00:00:00'::timestamp without time zone) AND (session_start_time <= '2021-04-08 00:00:00'::timestamp without time zone))
--   Filter: (film_id = 33)
--   Rows Removed by Filter: 24
-- Planning Time: 0.227 ms
-- Execution Time: 0.035 ms

CREATE OR REPLACE FUNCTION random_session_seat() RETURNS void AS
$$
    DECLARE
        session_ids INT := 17;
        seats INT := 0;
        seats_group INT := 0;
        BEGIN
            WHILE session_ids < 53776
            LOOP
            BEGIN
                IF session_ids % 4 <> 0 THEN
                    FOR seats IN 1..180 LOOP
                        IF seats = 61 OR seats = 121 THEN
                            session_ids := session_ids + 1;
                            IF session_ids % 4 = 0 THEN
                                    session_ids := session_ids + 1;
                            END IF;
                        END IF;
                        INSERT INTO session_seat(session_id, seat_id, seat_status_id)
                            SELECT
                                session_ids,
                                seats,
                                1;
                    END LOOP;
                END IF;
                session_ids := session_ids + 1;
            END;
            END LOOP;
        END;
$$ LANGUAGE plpgsql;

SELECT random_session_seat();
-- > OK
-- > Time: 172,287s

EXPLAIN ANALYSE SELECT * FROM session_seat WHERE session_id = 53776;
-- Gather  (cost=1000.00..26690.75 rows=60 width=16) (actual time=257.385..263.012 rows=0 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on session_seat  (cost=0.00..25684.75 rows=25 width=16) (actual time=221.561..221.561 rows=0 loops=3)
--         Filter: (session_id = 53776)
--         Rows Removed by Filter: 806640
-- Planning Time: 0.155 ms
-- Execution Time: 263.027 ms

EXPLAIN ANALYSE SELECT * FROM session_seat WHERE seat_status_id = '1' AND seat_id IN (1, 2, 3, 4);
-- Gather  (cost=1000.00..37103.65 rows=53774 width=16) (actual time=0.231..396.804 rows=53772 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on session_seat  (cost=0.00..30726.25 rows=22406 width=16) (actual time=0.052..362.863 rows=17924 loops=3)
--         Filter: ((seat_status_id = 1) AND (seat_id = ANY ('{1,2,3,4}'::integer[])))
--         Rows Removed by Filter: 788716
-- Planning Time: 0.110 ms
-- Execution Time: 400.488 ms

EXPLAIN ANALYSE SELECT ss.session_seat_id, s.hall_id, s.seat_id, s.seat_row, s.seat_number FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) WHERE ss.session_id = 53776 AND ss.seat_status_id = 1 AND s.seat_row = 5 AND s.seat_number IN (5, 7, 8, 9);
-- Gather  (cost=1007.50..29213.47 rows=4 width=20) (actual time=258.285..262.872 rows=4 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Hash Join  (cost=7.50..28213.07 rows=2 width=20) (actual time=173.514..244.236 rows=1 loops=3)
--         Hash Cond: (ss.seat_id = s.seat_id)
--         ->  Parallel Seq Scan on session_seat ss  (cost=0.00..28205.50 rows=25 width=8) (actual time=99.131..242.359 rows=20 loops=3)
--               Filter: ((session_id = 5390) AND (seat_status_id = 1))
--               Rows Removed by Filter: 806620
--         ->  Hash  (cost=7.25..7.25 rows=20 width=16) (actual time=0.089..0.089 rows=20 loops=2)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on seat s  (cost=0.00..7.25 rows=20 width=16) (actual time=0.028..0.079 rows=20 loops=2)
--                     Filter: ((seat_row = 5) AND (seat_number = ANY ('{5,7,8,9}'::integer[])))
--                     Rows Removed by Filter: 280
-- Planning Time: 1.152 ms
-- Execution Time: 262.901 ms

DELETE FROM session_seat WHERE session_seat_id > 720;
ALTER SEQUENCE session_seat_session_seat_id_seq RESTART WITH 721;

-- after create index

CREATE INDEX isessionseatsessionid on "session_seat" using btree ("session_id");
CREATE INDEX isessionseatseatid on "session_seat" using btree ("seat_id");

EXPLAIN ANALYSE SELECT * FROM session_seat WHERE session_id = 53776;
-- Index Scan using isessionseatsessionid on session_seat  (cost=0.43..9.48 rows=60 width=16) (actual time=0.028..0.028 rows=0 loops=1)
--   Index Cond: (session_id = 53776)
-- Planning Time: 0.057 ms
-- Execution Time: 0.039 ms

EXPLAIN ANALYSE SELECT * FROM session_seat WHERE seat_status_id = '1' AND seat_id IN (1, 2, 3, 4);
-- Bitmap Heap Scan on session_seat  (cost=1006.48..15028.56 rows=53774 width=16) (actual time=8.065..37.165 rows=53772 loops=1)
--   Recheck Cond: (seat_id = ANY ('{1,2,3,4}'::integer[]))
--   Filter: (seat_status_id = 1)
--   Rows Removed by Filter: 4
--   Heap Blocks: exact=13080
--   ->  Bitmap Index Scan on isessionseatseatid  (cost=0.00..993.04 rows=53776 width=0) (actual time=4.925..4.925 rows=53776 loops=1)
--         Index Cond: (seat_id = ANY ('{1,2,3,4}'::integer[]))
-- Planning Time: 0.212 ms
-- Execution Time: 40.631 ms

EXPLAIN ANALYSE SELECT ss.session_seat_id, s.hall_id, s.seat_id, s.seat_row, s.seat_number FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) WHERE ss.session_id = 53776 AND ss.seat_status_id = 1 AND s.seat_row = 5 AND s.seat_number IN (5, 7, 8, 9);
-- Hash Join  (cost=7.93..17.29 rows=4 width=20) (actual time=0.113..0.122 rows=4 loops=1)
--   Hash Cond: (ss.seat_id = s.seat_id)
--   ->  Index Scan using isessionseatsessionid on session_seat ss  (cost=0.43..9.63 rows=60 width=8) (actual time=0.016..0.036 rows=60 loops=1)
--         Index Cond: (session_id = 5390)
--         Filter: (seat_status_id = 1)
--   ->  Hash  (cost=7.25..7.25 rows=20 width=16) (actual time=0.071..0.071 rows=20 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Seq Scan on seat s  (cost=0.00..7.25 rows=20 width=16) (actual time=0.016..0.065 rows=20 loops=1)
--               Filter: ((seat_row = 5) AND (seat_number = ANY ('{5,7,8,9}'::integer[])))
--               Rows Removed by Filter: 280
-- Planning Time: 0.291 ms
-- Execution Time: 0.141 ms

CREATE OR REPLACE FUNCTION random_session_seat_price() RETURNS void AS
$$
    DECLARE
        session_ids INT := 17;
        sets INT := 0;
        pricesLow NUMERIC(5,2)[] := ARRAY[300.00, 420.00, 600.00];
        pricesMedium NUMERIC(5,2)[] := ARRAY[400.00, 520.00, 700.00];
        pricesHigh NUMERIC(5,2)[] := ARRAY[500.00, 620.00, 800.00];
        pricesTextLow NUMERIC(5,2);
        pricesTextMedium NUMERIC(5,2);
        pricesTextHigh NUMERIC(5,2);
        i INT := 0;
        s INT := 0;
        BEGIN
            WHILE session_ids < 53776
            LOOP
            IF session_ids % 4 <> 0 THEN
                BEGIN
                    s := s + 1;
                    IF s = 14 THEN
                        s := 1;
                    END IF;
                    IF s < 7 THEN
                        FOR i IN 1..3 LOOP
                            INSERT INTO session_seat_price(session_id, seat_type_id, price)
                            SELECT
                                session_ids,
                                i,
                                pricesLow[i];
                        END LOOP;
                    ELSIF s < 11 THEN
                        FOR i IN 1..3 LOOP
                            INSERT INTO session_seat_price(session_id, seat_type_id, price)
                            SELECT
                                session_ids,
                                i,
                                pricesMedium[i];
                        END LOOP;
                    ELSE
                        FOR i IN 1..3 LOOP
                            INSERT INTO session_seat_price(session_id, seat_type_id, price)
                            SELECT
                                session_ids,
                                i,
                                pricesHigh[i];
                        END LOOP;
                    END IF;
                END;
            END IF;
            session_ids := session_ids + 1;
            END LOOP;
        END;
$$ LANGUAGE plpgsql;

SELECT random_session_seat_price();

EXPLAIN ANALYSE SELECT ss.session_id, ss.session_seat_id, s.hall_id, ssp.seat_type_id, ssp.price, s.seat_id, s.seat_row, s.seat_number FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) LEFT JOIN session_seat_price ssp ON (ss.session_id = ssp.session_id) WHERE ss.session_id = 5390 AND ss.seat_status_id = 1 AND ssp.seat_type_id = 1 AND s.seat_row = 3 AND s.seat_number IN (5, 7, 8, 9);
-- Nested Loop  (cost=7.93..2342.69 rows=12 width=40) (actual time=2.378..21.817 rows=4 loops=1)
--   ->  Hash Join  (cost=7.93..17.29 rows=4 width=24) (actual time=0.114..0.137 rows=4 loops=1)
--         Hash Cond: (ss.seat_id = s.seat_id)
--         ->  Index Scan using isessionseatsessionid on session_seat ss  (cost=0.43..9.63 rows=60 width=12) (actual time=0.009..0.032 rows=60 loops=1)
--               Index Cond: (session_id = 5390)
--               Filter: (seat_status_id = 1)
--         ->  Hash  (cost=7.25..7.25 rows=20 width=16) (actual time=0.072..0.072 rows=20 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on seat s  (cost=0.00..7.25 rows=20 width=16) (actual time=0.014..0.065 rows=20 loops=1)
--                     Filter: ((seat_row = 3) AND (seat_number = ANY ('{5,7,8,9}'::integer[])))
--                     Rows Removed by Filter: 280
--   ->  Materialize  (cost=0.00..2325.26 rows=3 width=20) (actual time=0.566..5.419 rows=1 loops=4)
--         ->  Seq Scan on session_seat_price ssp  (cost=0.00..2325.25 rows=3 width=20) (actual time=2.258..21.670 rows=1 loops=1)
--               Filter: ((session_id = 5390) AND (seat_type_id = 1))
--               Rows Removed by Filter: 120998
-- Planning Time: 0.275 ms
-- Execution Time: 21.847 ms

EXPLAIN ANALYSE SELECT SUM(ssp.price) AS sum_price FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) LEFT JOIN session_seat_price ssp ON (ss.session_id = ssp.session_id) WHERE ss.session_id = 5390 AND ss.seat_status_id = 1 AND ssp.seat_type_id = 1 AND s.seat_row = 3 AND s.seat_number IN (5, 7, 8, 9);
-- Aggregate  (cost=2342.73..2342.74 rows=1 width=32) (actual time=20.267..20.268 rows=1 loops=1)
--   ->  Nested Loop  (cost=7.93..2342.69 rows=12 width=12) (actual time=0.844..20.259 rows=4 loops=1)
--         ->  Hash Join  (cost=7.93..17.29 rows=4 width=4) (actual time=0.044..0.067 rows=4 loops=1)
--               Hash Cond: (ss.seat_id = s.seat_id)
--               ->  Index Scan using isessionseatsessionid on session_seat ss  (cost=0.43..9.63 rows=60 width=8) (actual time=0.008..0.025 rows=60 loops=1)
--                     Index Cond: (session_id = 5390)
--                     Filter: (seat_status_id = 1)
--               ->  Hash  (cost=7.25..7.25 rows=20 width=4) (actual time=0.027..0.028 rows=20 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on seat s  (cost=0.00..7.25 rows=20 width=4) (actual time=0.007..0.024 rows=20 loops=1)
--                           Filter: ((seat_row = 3) AND (seat_number = ANY ('{5,7,8,9}'::integer[])))
--                           Rows Removed by Filter: 280
--         ->  Materialize  (cost=0.00..2325.26 rows=3 width=16) (actual time=0.200..5.047 rows=1 loops=4)
--               ->  Seq Scan on session_seat_price ssp  (cost=0.00..2325.25 rows=3 width=16) (actual time=0.796..20.184 rows=1 loops=1)
--                     Filter: ((session_id = 5390) AND (seat_type_id = 1))
--                     Rows Removed by Filter: 120998
-- Planning Time: 1.469 ms
-- Execution Time: 20.298 ms

DELETE FROM session_seat_price WHERE session_id > 15;

-- after create index

CREATE INDEX isessionseatpricesessionid on "session_seat_price" using btree ("session_id");

EXPLAIN ANALYSE SELECT ss.session_id, ss.session_seat_id, s.hall_id, ssp.seat_type_id, ssp.price, s.seat_id, s.seat_row, s.seat_number FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) LEFT JOIN session_seat_price ssp ON (ss.session_id = ssp.session_id) WHERE ss.session_id = 5390 AND ss.seat_status_id = 1 AND ssp.seat_type_id = 1 AND s.seat_row = 3 AND s.seat_number IN (5, 7, 8, 9);
-- Nested Loop  (cost=8.35..25.81 rows=4 width=33) (actual time=0.116..0.136 rows=4 loops=1)
--   ->  Index Scan using isessionseatpricesessionid on session_seat_price ssp  (cost=0.42..8.48 rows=1 width=13) (actual time=0.018..0.019 rows=1 loops=1)
--         Index Cond: (session_id = 5390)
--         Filter: (seat_type_id = 1)
--         Rows Removed by Filter: 2
--   ->  Hash Join  (cost=7.93..17.29 rows=4 width=24) (actual time=0.097..0.114 rows=4 loops=1)
--         Hash Cond: (ss.seat_id = s.seat_id)
--         ->  Index Scan using isessionseatsessionid on session_seat ss  (cost=0.43..9.63 rows=60 width=12) (actual time=0.008..0.027 rows=60 loops=1)
--               Index Cond: (session_id = 5390)
--               Filter: (seat_status_id = 1)
--         ->  Hash  (cost=7.25..7.25 rows=20 width=16) (actual time=0.073..0.073 rows=20 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on seat s  (cost=0.00..7.25 rows=20 width=16) (actual time=0.013..0.066 rows=20 loops=1)
--                     Filter: ((seat_row = 3) AND (seat_number = ANY ('{5,7,8,9}'::integer[])))
--                     Rows Removed by Filter: 280
-- Planning Time: 0.591 ms
-- Execution Time: 0.161 ms

EXPLAIN ANALYSE SELECT SUM(ssp.price) AS sum_price FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) LEFT JOIN session_seat_price ssp ON (ss.session_id = ssp.session_id) WHERE ss.session_id = 5390 AND ss.seat_status_id = 1 AND ssp.seat_type_id = 1 AND s.seat_row = 3 AND s.seat_number IN (5, 7, 8, 9);
-- Aggregate  (cost=25.82..25.83 rows=1 width=32) (actual time=0.149..0.150 rows=1 loops=1)
--   ->  Nested Loop  (cost=8.35..25.81 rows=4 width=5) (actual time=0.124..0.143 rows=4 loops=1)
--         ->  Index Scan using isessionseatpricesessionid on session_seat_price ssp  (cost=0.42..8.48 rows=1 width=9) (actual time=0.009..0.010 rows=1 loops=1)
--               Index Cond: (session_id = 5390)
--               Filter: (seat_type_id = 1)
--               Rows Removed by Filter: 2
--         ->  Hash Join  (cost=7.93..17.29 rows=4 width=4) (actual time=0.114..0.132 rows=4 loops=1)
--               Hash Cond: (ss.seat_id = s.seat_id)
--               ->  Index Scan using isessionseatsessionid on session_seat ss  (cost=0.43..9.63 rows=60 width=8) (actual time=0.007..0.027 rows=60 loops=1)
--                     Index Cond: (session_id = 5390)
--                     Filter: (seat_status_id = 1)
--               ->  Hash  (cost=7.25..7.25 rows=20 width=4) (actual time=0.091..0.091 rows=20 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on seat s  (cost=0.00..7.25 rows=20 width=4) (actual time=0.014..0.084 rows=20 loops=1)
--                           Filter: ((seat_row = 3) AND (seat_number = ANY ('{5,7,8,9}'::integer[])))
--                           Rows Removed by Filter: 280
-- Planning Time: 0.258 ms
-- Execution Time: 0.178 ms

SELECT
    table_name,
    pg_size_pretty(table_size) AS table_size,
    pg_size_pretty(indexes_size) AS indexes_size,
    pg_size_pretty(total_size) AS total_size
FROM (
    SELECT
        table_name,
        pg_table_size(table_name) AS table_size,
        pg_indexes_size(table_name) AS indexes_size,
        pg_total_relation_size(table_name) AS total_size
    FROM (
        SELECT ('"' || table_schema || '"."' || table_name || '"') AS table_name
        FROM information_schema.tables
        WHERE
            table_schema = 'public'
    ) AS all_tables
    ORDER BY total_size DESC LIMIT 15
) AS pretty_sizes;
-- table_name table_size indexes_size total_size
-- "public"."eav_entity_value"	4772 MB	6745 MB	11 GB
-- "public"."film"	422 MB	816 MB	1239 MB
-- "public"."session_seat"	102 MB	156 MB	258 MB
-- "public"."session_seat_price"	5264 kB	2680 kB	7944 kB
-- "public"."session"	2768 kB	3576 kB	6344 kB
-- "public"."seat"	40 kB	16 kB	56 kB
-- "public"."eav_attribute"	8192 bytes	32 kB	40 kB
-- "public"."client"	16 kB	16 kB	32 kB
-- "public"."hall_status"	8192 bytes	16 kB	24 kB
-- "public"."eav_entity_type"	8192 bytes	16 kB	24 kB
-- "public"."session_status"	8192 bytes	16 kB	24 kB
-- "public"."seat_status"	8192 bytes	16 kB	24 kB
-- "public"."hall"	8192 bytes	16 kB	24 kB
-- "public"."seat_type"	8192 bytes	16 kB	24 kB
-- "public"."history"	8192 bytes	16 kB	24 kB

SELECT
   s.relname AS table_name,
   s.indexrelname AS index_name,
   pg_relation_size(s.indexrelid) AS index_size
FROM
    pg_catalog.pg_stat_user_indexes s
JOIN
    pg_catalog.pg_index i
ON
    s.indexrelid = i.indexrelid
WHERE
    s.idx_scan = 0
    AND 0 <> ALL (i.indkey)
    AND NOT i.indisunique
    AND NOT EXISTS (SELECT 1 FROM pg_catalog.pg_constraint c WHERE c.conindid = s.indexrelid)
ORDER BY
    s.idx_scan
DESC
    LIMIT 5;
-- table_name index_name index_size
-- film	ifilmname	406175744
-- eav_attribute	iattributeattributeid	16384
-- eav_entity_value	ientityvaluevalueid	1796931584
-- session	isessionfilmid	1220608

SELECT
   s.relname AS table_name,
   s.indexrelname AS index_name,
   pg_relation_size(s.indexrelid) AS index_size
FROM
    pg_catalog.pg_stat_user_indexes s
JOIN
    pg_catalog.pg_index i
ON
    s.indexrelid = i.indexrelid
WHERE
    0 <> ALL (i.indkey)
    AND NOT i.indisunique
    AND NOT EXISTS (SELECT 1 FROM pg_catalog.pg_constraint c WHERE c.conindid = s.indexrelid)
ORDER BY
    pg_relation_size(s.indexrelid)
DESC
    LIMIT 5;
-- table_name index_name index_size
-- eav_entity_value	ientityvaluevalueid	1796931584
-- eav_entity_value	ientityvalueentityid	1787166720
-- eav_entity_value	ientityvalueattributeid	1691541504
-- film	ifilmname	406175744
-- film	ifilmentityid	225075200