SELECT name, SUM(tickets.price)
FROM sessions
         INNER JOIN tickets ON tickets.sessions_id = sessions.id
WHERE tickets.sold = true
GROUP BY name
ORDER BY SUM(tickets.price) DESC
LIMIT 1;