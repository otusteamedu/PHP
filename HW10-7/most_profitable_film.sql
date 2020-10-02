-- -- --
-- Общий сбор фильма считается по билетам.                  --
-- Статус 1 означает что билет продан (оплачен полностью)   --
-- -- --

SELECT *,
       (
           SELECT SUM(cost)
           FROM tickets t
                    LEFT JOIN film_sessions fs ON fs.id = t.session_id
           WHERE status = 1
             AND fs.film_id = f.id
           GROUP BY (fs.film_id)
       ) as cost
FROM films f;