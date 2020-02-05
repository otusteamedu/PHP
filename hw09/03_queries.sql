-- количество проданных билетов на сеанс
SELECT COUNT(*)
FROM order_details
WHERE film_session_id = 1;

-- поиск фильма по названию
SELECT name
FROM movies
WHERE name LIKE '%qwerty%';

-- Фильмы "сегодня"
SELECT movies.name
FROM movies
         LEFT JOIN film_sessions fs ON movies.movie_id = fs.movie_id
WHERE fs.time_from >= now()
  AND fs.time_to <= now();

-- выручка по всем заказам за последний месяц
SELECT sum(od.price)
FROM orders AS o
         LEFT JOIN order_details od ON o.order_id = od.order_id
WHERE o.datetime >= now() - INTERVAL '1 month';

-- top 5 прибыльных фильмов за все время
SELECT m.name AS movie_name, sum(od.price) AS total
FROM orders
         LEFT JOIN order_details od ON orders.order_id = od.order_id
         LEFT JOIN film_sessions fs ON od.film_session_id = fs.film_session_id
         LEFT JOIN movies m ON fs.movie_id = m.movie_id
GROUP BY movie_name
HAVING sum(od.price) > 0
ORDER BY total DESC
LIMIT 5;

-- фильмы которые посмотрел конкретный пользователь
SELECT name
FROM movies
WHERE movie_id IN (
    SELECT fs.movie_id
    FROM orders
             LEFT JOIN order_details od ON orders.order_id = od.order_id
             LEFT JOIN film_sessions fs ON od.film_session_id = fs.film_session_id
    WHERE client_id = 100
)


