-- рейтинг по стоимости
SELECT m.title AS movie, SUM(t.price) AS profit FROM tickets t
    LEFT JOIN sessions s ON s.id = t.session_id
    LEFT JOIN movies m ON m.id = s.movie_id
GROUP BY m.title
ORDER BY profit DESC
LIMIT 1;
