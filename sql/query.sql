-- Написать SQL для нахождения самого прибыльного фильма
SELECT m.id, m.name, sum(t.price) sum
FROM tickets t
    JOIN sessions s ON t.session_id = s.id
    JOIN movies m ON s.movie_id = m.id
GROUP BY m.id, m.name
ORDER BY sum DESC
LIMIT 1
