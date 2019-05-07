CREATE OR REPLACE VIEW film_market AS
SELECT fav.id_film_attribute_value AS id_value,
       f.id_film                   AS id_film,
       f.name                      AS film_name,
       fat.name                    AS type_name,
       fa.name                     AS attribute_name,
       CASE fat.type
           WHEN 'integer'::text THEN fav.int_value::text
           WHEN 'text'::text THEN fav.text_value::text
           WHEN 'timestamp'::text THEN fav.date_value::text
           WHEN 'boolean'::text THEN fav.bool_value::text
           END                     AS value
FROM film f
         INNER JOIN film_attribute_value fav ON f.id_film = fav.id_film
         INNER JOIN film_attribute fa ON fav.id_film_attribute = fa.id_film_attribute
         INNER JOIN film_attribute_type fat ON fa.id_film_attribute_type = fat.id_film_attribute_type;

CREATE OR REPLACE VIEW film_tasks AS
SELECT film.name, today.tasks AS today_tasks, "20d".tasks AS "20d_tasks"
FROM film
         INNER JOIN (SELECT id_film, string_agg(attribute_name, ',') AS tasks
                     FROM film_market
                     WHERE type_name = 'Раб.Дата'
                       AND value::date = current_date
                     GROUP BY id_film) today ON today.id_film = film.id_film
         INNER JOIN (SELECT id_film, string_agg(attribute_name, ',') AS tasks
                     FROM film_market
                     WHERE type_name = 'Раб.Дата'
                       AND value::date = current_date + interval '20d'
                     GROUP BY id_film) AS "20d" ON "20d".id_film = film.id_film
