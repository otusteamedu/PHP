SELECT MaxName, MaxSum
FROM 
(
    SELECT films.name as MaxName, SUM(orders.count) * films.price as MaxSum
    FROM orders 
	JOIN sessions ON orders.id_session = sessions.id
	JOIN films ON sessions.id_film = films.id
	GROUP BY films.id
    order by MaxSum desc
  	limit 1
) AS m