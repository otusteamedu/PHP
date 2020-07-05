-- 1st simple request
SELECT count(film_title)
FROM public.films_entity fe 
WHERE film_title like 'Se%';

-- 2nd simple request
SELECT count(attr_title)
FROM public.films_attribute fa
WHERE type_id = 3;

-- 3rd simple request
SELECT count(film_id) 
FROM public.films_value fv 
WHERE value_date >= '2020-06-01' AND value_date <= '2020-06-30';

-- 4th complex request
SELECT films_entity.film_title,
    films_types.type_title,
    films_attribute.attr_title,
    COALESCE(films_value.value_date::text, films_value.value_float::text, films_value.value_text, films_value.value_int::text, b2s(films_value.value_bool)) AS value
   FROM films_entity
     JOIN films_value ON films_entity.film_id = films_value.film_id
     JOIN films_attribute ON films_value.attr_id = films_attribute.attr_id
     JOIN films_types ON films_attribute.type_id = films_types.type_id;
    
-- 5th complex request
SELECT films_entity.film_title,
    films_attribute.attr_title,
    films_value.value_date
   FROM films_entity
     LEFT JOIN films_value ON films_entity.film_id = films_value.film_id
     LEFT JOIN films_attribute ON films_value.attr_id = films_attribute.attr_id
     LEFT JOIN films_types ON films_attribute.type_id = films_types.type_id
  WHERE films_entity.film_id = 7390;

-- 6th complex request
SELECT films_entity.film_title,
    films_attribute.attr_title,
    films_value.value_date
   FROM films_entity
     LEFT JOIN films_value ON films_entity.film_id = films_value.film_id
     LEFT JOIN films_attribute ON films_value.attr_id = films_attribute.attr_id
     LEFT JOIN films_types ON films_attribute.type_id = films_types.type_id
WHERE films_types.type_title = 'Date' AND films_value.value_date in (date(now()), date(now()+'20 day'::interval));

