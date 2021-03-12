CREATE OR replace view movies."vFilm" AS
	SELECT 
		f.title AS "Фильм", 
		a.name AS "Аттрибут",
		v.val_date::text AS "Значение"
		FROM movies."values" v 
		LEFT JOIN movies."films" f ON v.film_id = f.id
		LEFT JOIN movies."attributes" a ON v.attr_id = a.id
		WHERE val_date IS NOT NULL
	UNION ALL
	SELECT
		f.title AS "Фильм", 
		a.name AS "Аттрибут",
		v.val_num ::text AS "Значение"
		FROM movies."values" v
		LEFT JOIN movies."films" f ON v.film_id = f.id
		LEFT JOIN movies."attributes" a ON v.attr_id = a.id
		WHERE val_num IS NOT NULL
	UNION ALL
	SELECT
		f.title AS "Фильм",
		a.name AS "Аттрибут",
		v.val_text ::text AS "Значение" 
		FROM movies."values" v 
		LEFT JOIN movies."films" f ON v.film_id = f.id
		LEFT JOIN movies."attributes" a ON v.attr_id = a.id
		WHERE val_text IS NOT NULL;