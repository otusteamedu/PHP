-- количество проданных билетов на сеанс
SELECT COUNT(*)
FROM order_details
WHERE film_session_id = 1;

-- Все заказы определенного пользователя
SELECT *
FROM orders
WHERE client_id in (1, 5, 87, 987);

-- количество заказов "за сегодня"
SELECT count(*)
FROM orders
WHERE datetime >= date('today')
  AND datetime < date('today') + INTERVAL '1 day';

-- Расписание фильмов на сегодня
SELECT movies.name, to_char(fs.time_from, 'DD.MM.YYYY HH:MI:SS') as movie_start
FROM movies
         LEFT JOIN film_sessions fs ON movies.movie_id = fs.movie_id
WHERE fs.time_from >= date('today')
  AND fs.time_to < date('today') + INTERVAL '1 day'
ORDER BY movie_start
;

-- выручка по всем заказам за последний месяц
SELECT sum(od.price)
FROM orders AS o
         LEFT JOIN order_details od ON o.order_id = od.order_id
WHERE o.datetime >= date('today') - INTERVAL '1 month';

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


