CREATE VIEW actual_tasks_today
SELECT f.name AS film_name, fa."name" AS date_name, fav.date_value AS service_dates FROM films AS
JOIN film_attribute_values fav ON f.id = fav.film_id
JOIN film_attributes fa ON fa.id = fav.film_attribute_id
JOIN film_attribute_types fat ON fat.id = fa.film_attribute_type_id
WHERE fat.name = 'service_dates' AND DATE(fav.date_value) = DATE(NOW());

CREATE VIEW actual_tasks_through_20days
SELECT f.name AS film_name, fa."name" AS date_name, fav.date_value as service_dates FROM films AS f
JOIN film_attribute_values fav ON f.id = fav.film_id
JOIN film_attributes fa ON fa.id = fav.film_attribute_id
JOIN film_attribute_types fat ON fat.id = fa.film_attribute_type_id
where fat.name = 'service_dates' AND DATE(fav.date_value) = DATE(NOW() + INTERVAL '20 days');

CREATE VIEW marketing_report
SELECT f.name AS film_name, fat."name" AS attr_type, fa."name" AS attr_name,
       (CASE
            WHEN fav.date_value IS NOT NULL THEN fav.date_value ::text
            WHEN fav.text_value IS NOT NULL THEN fav.text_value ::text
            WHEN fav.boolean_value IS NOT NULL THEN fav.boolean_value ::text
       END) AS attr_value
FROM films AS f
JOIN film_attribute_values fav ON f.id = fav.film_id
JOIN film_attributes fa ON fa.id = fav.film_attribute_id
JOIN film_attribute_types fat ON fat.id = fa.film_attribute_type_id