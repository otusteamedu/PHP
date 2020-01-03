\connect cinema 

TRUNCATE TABLE 
    movie, 
    movie_rating,
    seat,
    seat_category,
    hall,
    session,
    session_category_price,
    ledger_entry
RESTART IDENTITY;

INSERT INTO movie_rating (title) VALUES ('0+'), ('6+'), ('12+'), ('16+'), ('18+');
INSERT INTO seat_category (title) VALUES('Первые ряды'), ('Средние ряды'), ('Последние ряды');

INSERT INTO hall (title, is_vip)
  SELECT 
    random_string((1 + random()*29)::integer),
    random() < 0.01
  FROM generate_series(1,10000);

INSERT INTO seat (row, number, hall_id, category_id) 
SELECT 
   row,
   num,
   h.id as hall_id,
   row as category_id
FROM generate_series(1,3) as row
CROSS JOIN generate_series(1, 6) as num
CROSS JOIN hall as h;

INSERT INTO movie (title, year, description, rating_id)
  SELECT 
    random_string((1 + random()*29)::integer),
    random_between(1980, 2019),
    random_string((1 + random()*100)::integer),
    random_between(
      (SELECT MIN(id) FROM movie_rating),
      (SELECT MAX(id) FROM movie_rating)
   )
  FROM generate_series(1,10000);

INSERT INTO session (date, movie_id, hall_id)
SELECT
   current_date + make_interval(
     days => random_between(-3, 3), 
     hours => random_between(0,23), 
     mins => random_between(0,59), 
     secs => random_between(0,59)
   ),
   random_between(
       (SELECT MIN(id) FROM movie),
       (SELECT MAX(id) FROM movie)
   ),
   random_between(
       (SELECT MIN(id) FROM hall),
       (SELECT MAX(id) FROM hall)
   )
   FROM generate_series(1,10000);

INSERT INTO session_category_price (session_id, category_id, price)
    SELECT
        id,
        1,
        500
    FROM session;

INSERT INTO session_category_price (session_id, category_id, price)
    SELECT
        id,
        2,
        600
    FROM session;

INSERT INTO session_category_price (session_id, category_id, price)
    SELECT
        id,
        3,
        700
    FROM session; 