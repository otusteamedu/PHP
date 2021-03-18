CREATE OR replace view "vFilm" as
SELECT f.title          AS "Фильм",
       a.name           AS "Аттрибут",
       v.val_date::text AS "Значение"
FROM "tFilmAttrValues" v
         LEFT JOIN "tFilms" f ON v.film_id = f.id
         LEFT JOIN "tAttributes" a ON v.attr_id = a.id
WHERE val_date IS NOT null

UNION ALL

SELECT f.title          AS "Фильм",
       a.name           AS "Аттрибут",
       v.val_int ::text AS "Значение"
FROM "tFilmAttrValues" v
         LEFT JOIN "tFilms" f ON v.film_id = f.id
         LEFT JOIN "tAttributes" a ON v.attr_id = a.id
WHERE val_int IS NOT NULL

UNION ALL

SELECT f.title            AS "Фильм",
       a.name             AS "Аттрибут",
       v.val_float ::text AS "Значение"
FROM "tFilmAttrValues" v
         LEFT JOIN "tFilms" f ON v.film_id = f.id
         LEFT JOIN "tAttributes" a ON v.attr_id = a.id
WHERE val_float IS NOT null

UNION ALL

SELECT f.title AS "Фильм",
       a.name  AS "Аттрибут",
       CASE
           WHEN val_bool THEN 'Да'
           ELSE 'Нет'
           END AS "Значение"
FROM "tFilmAttrValues" v
         LEFT JOIN "tFilms" f ON v.film_id = f.id
         LEFT JOIN "tAttributes" a ON v.attr_id = a.id
WHERE val_bool IS NOT NULL

UNION ALL

SELECT f.title           AS "Фильм",
       a.name            AS "Аттрибут",
       v.val_text ::text AS "Значение"
FROM "tFilmAttrValues" v
         LEFT JOIN "tFilms" f ON v.film_id = f.id
         LEFT JOIN "tAttributes" a ON v.attr_id = a.id
WHERE val_text IS NOT NULL;
