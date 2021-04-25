--SELECT fill_seances_fake_data(1000000);



EXPLAIN ANALYZE
SELECT count(*), movie_id
FROM seances s
WHERE s.start_at::time >= '22:00:00'::time
  AND s.end_at::time <= '6:00:00'::time
GROUP BY movie_id
ORDER BY count DESC;



EXPLAIN ANALYZE
SELECT count(*), hall_id
FROM seances s
GROUP BY hall_id
ORDER BY count DESC;



EXPLAIN ANALYZE
SELECT count(*), hall_id, movie_id
FROM seances s
GROUP BY hall_id, movie_id
ORDER BY count DESC;



EXPLAIN ANALYZE
SELECT s."number", s."row", halls."name", sum(sp.price) AS total, count(s.id) AS ticket_count
FROM seats s
         LEFT JOIN halls ON halls.id = s.hall_id
         LEFT JOIN tickets t ON t.seat_id = s.id
         LEFT JOIN seats_price sp ON sp.seance_id = t.seance_id AND s.type_id = sp.seat_type_id
GROUP BY s."number", s."row", s.hall_id, halls."name"
ORDER BY s.hall_id, total DESC



EXPLAIN ANALYSE
WITH seats_sum AS (
    SELECT s."number", s."row", s.hall_id, sum(sp.price) AS total, count(s.id) AS ticket_count
    FROM seats s
             LEFT JOIN tickets t ON t.seat_id = s.id
             LEFT JOIN seats_price sp ON sp.seance_id = t.seance_id AND s.type_id = sp.seat_type_id
    GROUP BY s."number", s."row", s.hall_id
    ORDER BY total DESC
),
     seats_sum_rn AS (
         SELECT *, ROW_NUMBER() OVER (PARTITION BY hall_id ORDER BY total DESC) AS rn
         FROM seats_sum
     )
SELECT halls."name", s."number", s."row", s.total, s.ticket_count, s.total / s.ticket_count AS cost_per_seance
FROM seats_sum_rn s
         LEFT JOIN halls ON halls.id = s.hall_id
WHERE rn = 1;



EXPLAIN ANALYZE
WITH sbm AS (
    SELECT s.movie_id, sum(seats_price.price) AS tp
    FROM seances s
             LEFT JOIN movies m ON m.id = s.movie_id
             LEFT JOIN tickets ON tickets.seance_id = s.id
             LEFT JOIN seats ON seats.id = tickets.seat_id
             LEFT JOIN seats_price ON seats_price.seat_type_id = seats.type_id AND seats_price.seance_id = s.id
    GROUP BY s.movie_id
    ORDER BY tp DESC
)
SELECT movies."name", count(seances.id), sbm.tp / count(seances.id) AS per_seance, sbm.tp
FROM sbm
         LEFT JOIN seances ON seances.movie_id = sbm.movie_id
         LEFT JOIN movies ON movies.id = sbm.movie_id
GROUP BY movies."name", sbm.tp
ORDER BY per_seance DESC;



EXPLAIN ANALYZE
WITH _sum AS (SELECT DISTINCT t.customer_id, s3.movie_id, sum(sp.price) AS total
              FROM tickets t
                       LEFT JOIN seats s2 ON s2.id = t.seat_id
                       LEFT JOIN seances s3 ON s3.id = t.seance_id
                       LEFT JOIN seats_price sp ON sp.seance_id = t.seance_id AND sp.seat_type_id = s2.type_id
              GROUP BY t.customer_id, s3.movie_id
              ORDER BY customer_id, total desc),
     _order AS (
         SELECT customer_id, movie_id, total, ROW_NUMBER() OVER (PARTITION BY customer_id ORDER BY total DESC ) AS rn
         FROM _sum
         GROUP BY customer_id, movie_id, total)
SELECT movies."name", customers."name", total
FROM _order
         LEFT JOIN customers ON customers.id = _order.customer_id
         LEFT JOIN movies ON movies.id = _order.movie_id
WHERE rn = 1;





EXPLAIN ANALYZE
WITH night AS (
    SELECT sum(sp.price) AS total_night
    FROM seances s
             LEFT JOIN public.tickets t ON t.seance_id = s.id
             LEFT JOIN public.seats s2 ON s2.id = t.seat_id
             LEFT JOIN public.seats_price sp ON sp.seance_id = s.id AND sp.seat_type_id = s2.type_id
    WHERE s.start_at::time >= '22:00:00'::time
      AND s.end_at::time <= '6:00:00'::time
),
     "day" AS (
         SELECT sum(sp.price) AS total_day
         FROM seances s
                  LEFT JOIN public.tickets t ON t.seance_id = s.id
                  LEFT JOIN public.seats s2 ON s2.id = t.seat_id
                  LEFT JOIN public.seats_price sp ON sp.seance_id = s.id AND sp.seat_type_id = s2.type_id
         WHERE s.start_at::time >= '6:00:00'::time
           AND s.end_at::time <= '22:00:00'::time
     )
SELECT *
FROM night,
     "day";






