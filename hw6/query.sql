SELECT id, movie."name", SUM(ticket.cost) as total_cost_sum
FROM movie
LEFT JOIN "session" ON "session".movie_id = movie.id
LEFT JOIN ticket ON ticket.session_id = "session".id
GROUP BY movie.id
ORDER BY total_cost_sum DESC
LIMIT 1;