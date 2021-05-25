-- 3 простых запроса

SELECT MAX(price)
FROM tickets
WHERE seance_id = 2;

SELECT t.*
FROM tickets t
  JOIN discounts d ON d.id = t.discount_id
WHERE
  d.value = 10
  AND t.seance_id = 1;

SELECT *
FROM places
WHERE room_id = 1 AND row = 1;

-- 3 сложных запроса

SELECT SUM(t.price)
FROM tickets t
  JOIN seances s ON s.id = t.seance_id
  JOIN movies m ON s.movie_id = m.id
WHERE m.id = 1;

SELECT MAX(cnt)
FROM (SELECT count(*) AS cnt
      FROM tickets
      GROUP BY seance_id) AS tickets_count_table;

WITH sum_prices AS
(SELECT
   m.name,
   SUM(t.price) AS cur_sum_prices
 FROM tickets t
   JOIN seances s ON s.id = t.seance_id
   JOIN movies m ON s.movie_id = m.id
 GROUP BY m.id)
SELECT MAX(cur_sum_prices)
FROM sum_prices;

-- View сборки служебных данных в форме
CREATE OR REPLACE VIEW public.service_data
  AS
    SELECT
      movies.name,
      string_agg(
          CASE
          WHEN mav.value_date = CURRENT_DATE
            THEN ma.name
          END,
          ', ')
        AS today_tasks,
      string_agg(
          CASE
          WHEN mav.value_date > CURRENT_DATE AND mav.value_date <= (CURRENT_DATE + INTERVAL '20 day')
            THEN ma.name
          END,
          ', ')
        AS future_tasks
    FROM movies
      JOIN movie_attribute_values mav ON mav.movie_id = movies.id
      JOIN movie_attributes ma ON ma.id = mav.attr_id
    WHERE mav.value_date <= (CURRENT_DATE + INTERVAL '20 day') AND mav.value_date >= CURRENT_DATE
    GROUP BY movies.id
    ORDER BY movies.id;

-- View сборки данных для маркетинга в форме
CREATE OR REPLACE VIEW public.marketing_data
  AS
    SELECT
      movies.name AS movie_name,
      ma.name     AS attribute_name,
      mat.name    AS attribute_type,
      COALESCE(
          mav.value_integer :: TEXT,
          mav.value_float :: TEXT,
          mav.value_date :: TEXT,
          mav.value_bool :: TEXT,
          mav.value_text :: TEXT
      )           AS attribute_value
    FROM movies
      INNER JOIN movie_attribute_values mav ON movies.id = mav.movie_id
      INNER JOIN movie_attributes ma ON ma.id = mav.attr_id
      INNER JOIN movies_attribute_types mat ON mat.id = ma.type_id
    ORDER BY movies.id, ma.id;

SELECT
  m.id         AS movie_id,
  m.name,
  SUM(s.price) AS total_cost
FROM movies AS m
  INNER JOIN seances AS s ON s.movie_id = m.id
  INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY m.id, m.name
ORDER BY total_cost DESC