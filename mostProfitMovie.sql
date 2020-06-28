
USE cinema;

SELECT 
	SUM(order_items.price_total) AS sum,
	timetable.movie_id AS movie_id,
	movies.name AS movie_name
FROM order_items 
LEFT JOIN timetable ON timetable.id = order_items.timetable_id 
LEFT JOIN movies ON movies.id = timetable.movie_id 
GROUP BY movie_id
ORDER BY sum DESC LIMIT 1