CREATE OR REPLACE VIEW public.eav_01
AS SELECT movie.name AS movie_name,
          attribute_type.name AS attribute_type,
          attribute.name AS attribute_name,
          COALESCE(movie_attribute_value.date_value::text, movie_attribute_value.num_value::text, movie_attribute_value.text_value::text) AS attribute_value
FROM movie_attribute_value
LEFT JOIN movie ON movie.id = movie_attribute_value.movie_id
LEFT JOIN attribute ON attribute.id = movie_attribute_value.attribute_id
LEFT JOIN attribute_type ON attribute_type.id = attribute.type_id;



CREATE OR REPLACE VIEW public.eav_02
AS SELECT r1.movie_name, r2.future, r3.current
FROM (SELECT movie.name AS movie_name, movie_id, attribute.name
        FROM movie_attribute_value
               LEFT JOIN movie ON movie.id = movie_attribute_value.movie_id
               LEFT JOIN attribute ON attribute.id = movie_attribute_value.attribute_id
               LEFT JOIN attribute_type ON attribute_type.id = attribute.type_id
        WHERE attribute.type_id = 2 AND date_value IS NOT NULL
 ) AS r1
 LEFT JOIN (SELECT movie_id, coalesce(date_value::text, 'empty') AS future FROM movie_attribute_value WHERE date_value > current_date) AS r2 ON r1.movie_id = r2.movie_id
 LEFT JOIN (SELECT movie_id, coalesce(date_value::text, 'empty') AS current FROM movie_attribute_value WHERE date_value = current_date) AS r3 ON r1.movie_id = r3.movie_id