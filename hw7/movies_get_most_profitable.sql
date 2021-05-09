SELECT MIN(movies.name) AS movie, SUM(tickets.cost) AS profit
FROM tickets
INNER JOIN sessions ON tickets.session_id = sessions.id
INNER JOIN movies ON sessions.movie_id = movies.id
GROUP BY sessions.movie_id
ORDER BY SUM(tickets.cost) DESC
LIMIT 1;
