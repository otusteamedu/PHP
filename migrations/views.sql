CREATE VIEW service_data AS
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


CREATE OR REPLACE VIEW marketing_data
AS SELECT f.name AS film_name,
          fa.name AS attribut,
          case fa.type_id
              WHEN 1 THEN cast(fav.film_id as text)
              WHEN 2 THEN cast(fav.val_text as text)
              WHEN 3 THEN cast(fav.val_date as text)
              WHEN 4 THEN cast(fav.val_float as text)
              ELSE NULL
              end AS value
   FROM films f
            JOIN film_attributes_values fav ON fav.film_id = f.id
            JOIN film_attributes fa ON fa.id = fav.attribute_id
   WHERE fa.id = ANY (ARRAY[1, 2, 3, 4]);

-- Запуск
select * from service_data;
select * from marketing_data;
