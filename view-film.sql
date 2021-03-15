CREATE OR replace view movies."vFilm" as
SELECT f.title          AS "Фильм",
       a.name           AS "Аттрибут",
       v.val_date::text AS "Значение"
FROM movies."values" v
         LEFT JOIN movies."films" f ON v.film_id = f.id
         LEFT JOIN movies."attributes" a ON v.attr_id = a.id
WHERE val_date IS NOT null

UNION ALL

SELECT f.title          AS "Фильм",
       a.name           AS "Аттрибут",
       v.val_int ::text AS "Значение"
FROM movies."values" v
         LEFT JOIN movies."films" f ON v.film_id = f.id
         LEFT JOIN movies."attributes" a ON v.attr_id = a.id
WHERE val_int IS NOT NULL

UNION ALL

SELECT f.title            AS "Фильм",
       a.name             AS "Аттрибут",
       v.val_float ::text AS "Значение"
FROM movies."values" v
         LEFT JOIN movies."films" f ON v.film_id = f.id
         LEFT JOIN movies."attributes" a ON v.attr_id = a.id
WHERE val_float IS NOT null

UNION ALL

SELECT f.title AS "Фильм",
       a.name  AS "Аттрибут",
       CASE
           WHEN val_bool THEN 'Да'
           ELSE 'Нет'
           END AS "Значение"
FROM movies."values" v
         LEFT JOIN movies."films" f ON v.film_id = f.id
         LEFT JOIN movies."attributes" a ON v.attr_id = a.id
WHERE val_bool IS NOT NULL

UNION ALL

SELECT f.title           AS "Фильм",
       a.name            AS "Аттрибут",
       v.val_text ::text AS "Значение"
FROM movies."values" v
         LEFT JOIN movies."films" f ON v.film_id = f.id
         LEFT JOIN movies."attributes" a ON v.attr_id = a.id
WHERE val_text IS NOT NULL;
