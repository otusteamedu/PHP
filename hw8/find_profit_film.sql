SELECT name FROM films,
(
	SELECT id, SUM(price) AS sum_price FROM films
	RIGHT JOIN timetable ON id = id_films
	RIGHT JOIN prices_calc ON id_hall_scheme_versions = id_hall_scheme_versions_timetable
 	 AND datetime_range = datetime_range_timetable
	RIGHT JOIN sales ON id_hall_scheme_versions_timetable = id_hall_scheme_versions_timetable_prices_calc
 	 AND datetime_range_timetable = datetime_range_timetable_prices_calc
	GROUP BY id
	ORDER BY sum_price
	LIMIT 1
) AS tempsql
WHERE films.id = tempsql.id
