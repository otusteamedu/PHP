-- Запрос выборки мест на сеанс с признаком куплен билет на него или нет и корректирующим коэффициентом стоимости билета
SELECT
  t.name AS hall_name,
  t2.row_number AS row_number,
  t3.place_number AS place_number,
  CASE WHEN t5.id IS NOT NULL THEN true ELSE false END AS sold,
  round(t1.price_coefficient*t.price_coefficient*t4.price_coefficient, 2) AS price_coefficient
FROM "hall" t
  INNER JOIN "session" t1 ON t1.hall_id=t.id
  INNER JOIN "row" t2 ON t.id=t2.hall_id
  INNER JOIN row_has_place t3 ON t2.id=t3.row_id
  INNER JOIN place t4 ON t4.id=t3.place_id
  LEFT JOIN tickets_sold t5 ON t5.session_id=t1.id AND t3.id=t5.row_has_place_id
WHERE t2.is_active=true AND t1.id=1
ORDER BY row_number, place_number;

-- Запрос выборки самого прибыльного фильма. V1 - фильм с максимальной выручкой может быть только один
SELECT
  t1.id AS film_id, t1.name AS film_name, t.sum AS sum
FROM (
 SELECT
   t2.id AS id,
   sum(t.price) as sum
 FROM tickets_sold t
   INNER JOIN session t1 ON t1.id=t.session_id
   INNER JOIN film t2 ON t2.id=t1.film_id
 GROUP BY t2.id ORDER BY sum DESC LIMIT 1
) t INNER JOIN film t1 ON t1.id=t.id

-- Запрос выборки самого прибыльного фильма. V2 - фильмов с максимальной выручкой может быть несколько
SELECT
  tfilm.id AS film_id, tfilm.name AS film_name, tprice.sum AS sum
FROM (
 SELECT
   tfilm_sec.id AS id,
   sum(tt_sold.price) as sum
 FROM tickets_sold tt_sold
   INNER JOIN session tsession ON tsession.id=tt_sold.session_id
   INNER JOIN film tfilm_sec ON tfilm_sec.id=tsession.film_id
 GROUP BY tfilm_sec.id HAVING sum(tt_sold.price) = (
  SELECT max(sum) AS max_sum FROM (
   SELECT
     sum(t.price) as sum
   FROM tickets_sold t
     INNER JOIN session t1 ON t1.id=t.session_id
     INNER JOIN film t2 ON t2.id=t1.film_id
   GROUP BY t2.id
  ) tprice_nested
 )
) tprice INNER JOIN film tfilm ON tfilm.id=tprice.id;