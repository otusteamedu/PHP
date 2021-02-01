SELECT SUM(t.price) AS maxPrice
FROM ticket AS t
JOIN showtime AS s on s.id = t.showtime_id
GROUP BY s.movie_id
ORDER BY maxPrice DESC
LIMIT 1;
