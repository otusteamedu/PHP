SELECT name, SUM(tickets.price)
FROM films
         INNER JOIN tickets ON tickets.sessions_id = sessions.id
         INNER JOIN sessions ON sessions.film_id=films.id
WHERE tickets.sold = true
GROUP BY name
ORDER BY SUM(tickets.price) DESC
LIMIT 1;