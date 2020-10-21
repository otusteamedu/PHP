EXPLAIN ANALYZE SELECT * FROM orders
WHERE amount > 1000::money;

EXPLAIN ANALYZE SELECT * FROM film_sessions
WHERE session_duration > 100;

EXPLAIN ANALYZE SELECT * FROM films
WHERE title LIKE '%Spiderman%';

EXPLAIN ANALYZE SELECT f.title, COUNT(fs.id) FROM films f
JOIN film_sessions fs ON fs.film_id = f.id
GROUP BY (f.id);

EXPLAIN ANALYZE SELECT  ch.title,
         (
            SELECT AVG(count) FROM
            (
                SELECT COUNT(*) as count FROM film_sessions fs
                JOIN tickets t ON t.session_id = fs.id
                WHERE fs.hall_id = ch.id
                GROUP BY fs.id
            ) AS count_tickets_for_each_session
         ) AS avg_count_of_tickets
FROM cinema_halls ch;

EXPLAIN ANALYZE SELECT  CONCAT(c.first_name, ' ', c.middle_name),
        SUM(o.amount)
FROM clients c
LEFT JOIN orders o ON o.client_id = c.id
GROUP BY c.id;
