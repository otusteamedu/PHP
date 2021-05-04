SELECT MIN(m.name) AS movie, SUM(s.cost) AS profit
FROM movies m INNER JOIN sessions s ON s.movie_id = m.id  INNER JOIN tickets t ON t.session_id = s.id
GROUP BY s.movie_id
ORDER BY SUM(s.cost) DESC
LIMIT 1;