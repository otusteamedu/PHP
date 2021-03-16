SELECT f.name AS film_name, fa."name" AS date_name, fav.date_value as service_dates FROM films AS f
JOIN film_attribute_values fav ON f.id = fav.film_id
JOIN film_attributes fa ON fa.id = fav.film_attribute_id
JOIN film_attribute_types fat ON fat.id = fa.film_attribute_type_id
where fav.date_value IS NOT NULL AND DATE(fav.date_value) = DATE(NOW() + INTERVAL '20 days')
LIMIT 20;