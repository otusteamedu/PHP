CREATE VIEW max_price AS SELECT MaxName, MaxSum
FROM 
(
    SELECT films.name as MaxName, SUM(tickets.cost) as MaxSum
    FROM tickets 
	JOIN sessions ON tickets.id_session = sessions.id
	JOIN films ON sessions.id_film = films.id
	GROUP BY films.id
    order by MaxSum desc
  	limit 1
) AS m