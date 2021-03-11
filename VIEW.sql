CREATE OR REPLACE VIEW public.upcoming_tasks
AS SELECT movies.name,
       string_agg(
               CASE
	               WHEN v.date_value = CURRENT_DATE
	               		THEN attr.name
	               ELSE NULL::text
               END,
               ', ')
               AS today,
       string_agg(
               CASE
                   WHEN v.date_value > CURRENT_DATE AND v.date_value <= (CURRENT_DATE + INTERVAL '20 day')
                       THEN attr.name
                   ELSE NULL::text
                   END,
               ', ')
               AS twenty
FROM movies
         JOIN movie_attrs_values v ON v.movie_id = movies.id
         LEFT JOIN movie_attrs attr ON attr.id = v.attr_id
WHERE v.date_value  <= (CURRENT_DATE + INTERVAL '20 day') and v.date_value >= CURRENT_DATE
GROUP BY movies.id
ORDER BY movies.id;

CREATE OR REPLACE VIEW public.movie_attributes
AS SELECT
	movies.name AS movie,
	attr.name AS attr,
	atype.name AS attribute_type,
 	COALESCE(
		value.date_value::TEXT,
		value.int_value::TEXT,
		value.numeric_value::TEXT,
		value.text_value,
		value.time_value::TEXT
	) AS value
FROM movies
	LEFT JOIN movie_attrs_values value ON movies.id = value.movie_id
	LEFT JOIN movie_attrs attr ON attr.id = value.attr_id
	LEFT JOIN movie_attrs_types atype ON atype.id = attr.type_id
ORDER BY movies.id, attr.id
