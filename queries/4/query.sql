SELECT f.name AS film_name, fat."name" AS attr_type, fa."name" AS attr_name,
       (CASE
            WHEN fav.date_value IS NOT NULL THEN fav.date_value ::text
            WHEN fav.text_value IS NOT NULL THEN fav.text_value ::text
            WHEN fav.boolean_value IS NOT NULL THEN fav.boolean_value ::text
            WHEN fav.integer_value IS NOT NULL THEN fav.integer_value ::text
            WHEN fav.float_value IS NOT NULL THEN fav.float_value ::text
           END) AS attr_value
FROM films AS f
JOIN film_attribute_values fav ON f.id = fav.film_id
JOIN film_attributes fa ON fa.id = fav.film_attribute_id
JOIN film_attribute_types fat ON fat.id = fa.film_attribute_type_id
ORDER BY f.name
LIMIT 20;