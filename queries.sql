--Queries
-- 1
SELECT * FROM films WHERE age_restrict > 6 AND EXTRACT(hour FROM duration) < 2 ORDER BY age_restrict LIMIT 10;

-- 2
SELECT * FROM seances WHERE EXTRACT(MONTH FROM show_at) = 5 AND EXTRACT(YEAR FROM show_at) = EXTRACT(YEAR FROM NOW()) LIMIT 10;

-- 3
SELECT * FROM tickets WHERE price > 10000 ORDER BY price DESC LIMIT 10;

-- 4
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

-- 5
SELECT f.name AS film_name, fa."name" AS date_name, fav.date_value as service_dates FROM films AS f
JOIN film_attribute_values fav ON f.id = fav.film_id
JOIN film_attributes fa ON fa.id = fav.film_attribute_id
JOIN film_attribute_types fat ON fat.id = fa.film_attribute_type_id
where fav.date_value IS NOT NULL AND DATE(fav.date_value) = DATE(NOW() + INTERVAL '20 days')
LIMIT 20;

-- 6
SELECT f.name, COUNT (t.id) as tickets_count_purchase, SUM(t.price) as yield FROM public.films AS f
JOIN public.seances AS s ON f.id = s.film_id
JOIN public.tickets AS t ON s.id = t.seance_id
GROUP BY f.id
ORDER BY yield DESC
LIMIT 1;