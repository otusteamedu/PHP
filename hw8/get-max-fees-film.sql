SELECT
	film.title, 
	SUM(ticket."cost") as fees
FROM
	film
	INNER JOIN
		"session"
	ON 
		film.film_id = "session".film_id
	INNER JOIN
	ticket
	ON 
		"session".session_id = ticket.session_id
GROUP BY
	film.title
ORDER BY
	fees DESC
LIMIT 1