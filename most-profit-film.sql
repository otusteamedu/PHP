SELECT name
FROM sessions
         INNER JOIN tickets ON tickets.sessions_id = sessions.id
GROUP BY tickets.sessions_id desc
WHERE sold= true
LIMIT 1;