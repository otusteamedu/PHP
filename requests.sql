-- 1
EXPLAIN (analyse )
SELECT c.email FROM customer c
ORDER BY c.email;

CREATE UNIQUE INDEX IF NOT EXISTS i_customer_email ON customer(email);

--2
EXPLAIN (analyse )
SELECT * FROM movie
WHERE title LIKE 'd%';

CREATE INDEX IF NOT EXISTS i_movie_title ON movie(title text_pattern_ops);

--3
EXPLAIN (analyse )
SELECT *
FROM schedule s
WHERE s.date_start > now() AND s.date_end < now() + interval '2 hour' ;

CREATE INDEX IF NOT EXISTS i_schedule_dates ON schedule ((date_start::timestamp), (date_end::timestamp));


--4
EXPLAIN ANALYSE
SELECT DISTINCT c.*
FROM booking b
         JOIN customer c ON b.id_customer = c.id
WHERE b.created_at < now()
  AND b.created_at > now() - '1 week'::interval;

CREATE INDEX IF NOT EXISTS i_booking_dates ON booking((created_at::timestamp), (updated_at::timestamp));
SET work_mem TO '64MB';

--5
EXPLAIN ANALYSE
SELECT s.id,s.id_movie, s.date_start, p.row_number, p.place_number, spp.price, b.id
FROM schedule s
         LEFT JOIN places p on s.id_hall = p.id_hall
         LEFT JOIN booking b ON b.id_schedule = s.id
         join schedule_place_price spp on s.id = spp.id_schedule AND p.id_place_category = spp.id_place_category
WHERE (s.date_start > now() AND s.date_start < now() + '3 hour'::interval)
  AND s.id_movie = 2
  AND b.id IS NULL;


CREATE INDEX IF NOT EXISTS i_place_hall ON places(id_hall);

--6
EXPLAIN ANALYSE
SELECT m.id, m.title, ma.name, mav.value_int
FROM movie_attr ma
         LEFT JOIN movie_attr_value mav ON mav.id_attr = ma.id
         LEFT JOIN movie m ON mav.id_movie = m.id
WHERE ma.name LIKE 'Рейтинг IMDB'
  AND mav.value_int BETWEEN 5 and 10;

CREATE INDEX IF NOT EXISTS i_mav_int_value ON movie_attr_value((value_int::int));



-- REVERT IMPROVEMENTS
DROP INDEX IF  EXISTS i_customer_email;
DROP INDEX IF  EXISTS i_movie_title;
DROP INDEX IF  EXISTS i_schedule_dates;
DROP INDEX IF  EXISTS i_booking_dates;
DROP INDEX IF  EXISTS i_place_hall;
DROP INDEX IF  EXISTS i_mav_int_value;
SET work_mem TO '4MB';