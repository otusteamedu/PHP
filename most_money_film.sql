SELECT fs.name as film_name, sum(tt.price) as price
FROM tickets ts
INNER JOIN timetables tt ON ts.timetable_id = tt.timetable_id
INNER JOIN films fs ON tt.film_id = fs.film_id
GROUP BY film_name
ORDER BY price DESC
LIMIT 1