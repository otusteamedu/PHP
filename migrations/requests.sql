SELECT "val_text" FROM  "film_attributes_values";
SELECT "val_text" FROM  "film_attributes_values" WHERE "val_date" > current_date + interval '20 days';
SELECT "val_float" FROM  "film_attributes_values" WHERE "val_float" > 150;

SELECT
    films.name,
    fav.val_text
FROM films
         LEFT JOIN  film_attributes_values fav ON fav.film_id = films.id
         LEFT JOIN film_attributes fa ON fav.attribute_id = fa.id
WHERE fa.id  BETWEEN 1 AND 5 AND fav.val_text IS NOT NULL;;


SELECT count(film_attributes.id)
FROM film_attributes
LEFT JOIN  film_attributes_values fav ON fav.attribute_id = film_attributes.id
WHERE fav.val_date > current_date;


SELECT
    films.id AS film_id,
    films.name AS film_name,
    today_tasks.task AS today,
    future_tasks.task AS "in 20 days"
FROM films
    LEFT JOIN (
    SELECT film_id, fa.name AS task FROM film_attributes_values fav
    LEFT JOIN film_attributes fa ON fav.attribute_id = fa.id
    WHERE fa.type_id='3' AND fav.val_date=current_date
) today_tasks ON films.id = today_tasks.film_id
    LEFT JOIN (
    SELECT film_id, fa.name AS task FROM film_attributes_values fav
    LEFT JOIN film_attributes fa ON fav.attribute_id = fa.id
    WHERE fa.type_id='3' AND fav.val_date=current_date + interval '20 days'
) future_tasks ON films.id = future_tasks.film_id
WHERE today_tasks.task IS NOT NULL OR future_tasks.task IS NOT NULL;


SELECT nspname || '.' || relname as name,
       pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
       pg_size_pretty(pg_relation_size(C.oid)) as relsize
FROM pg_class C
         LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
  AND relname ilike '%film%'
ORDER BY pg_total_relation_size(C.oid) DESC
LIMIT 15;
