EXPLAIN ANALYSE SELECT id, title FROM movie WHERE year = 2018;

EXPLAIN ANALYSE SELECT id, title FROM movie WHERE rating_id = 5;

EXPLAIN ANALYSE SELECT id, title FROM hall WHERE is_vip = true;

EXPLAIN ANALYSE SELECT 
 m.id,
 m.title
FROM 
  movie as m
JOIN 
  session as s ON m.id = s.movie_id
WHERE 
  date(s.date) = current_date
GROUP BY m.id;

EXPLAIN ANALYSE SELECT 
 m.title,
 to_char(s.date, 'HH24:MI:SS')
FROM 
  session as s
JOIN 
  movie as m ON m.id = s.movie_id
WHERE 
  date(s.date) = current_date AND m.id = 20;

EXPLAIN ANALYSE SELECT
    s.row,
    s.number,
    (SELECT price FROM session_category_price WHERE session_id = ss.id AND category_id = s.category_id) as price
FROM 
    session as ss
JOIN seat as s ON s.hall_id = ss.hall_id
WHERE
    ss.id = 15;