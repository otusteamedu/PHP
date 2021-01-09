CREATE OR REPLACE VIEW view_movie_tasks
AS
SELECT movies.title,
       string_agg(
               CASE
                   WHEN mav.value_date = CURRENT_DATE
                       THEN ma.name
                   ELSE NULL::text
                   END,
               '; ') AS tasks_today,
       string_agg(
               CASE
                   WHEN mav.value_date > CURRENT_DATE AND mav.value_date <= (CURRENT_DATE + '20 days'::interval)
                       THEN ma.name
                   ELSE NULL::text
                   END,
               '; ') AS tasks_20d
FROM movies
         JOIN movieAttributeValues mav ON mav.movie_id = movies.id
         LEFT JOIN movieAttributes ma ON ma.id = mav.attribute_id
GROUP BY movies.id
ORDER BY movies.id;

CREATE OR REPLACE VIEW view_movie_information
AS
SELECT movies.title  as movie_title,
       ma.name  as movie_attr_name,
       mat.name AS movie_attr_type,
       COALESCE(
               mav.value_text,
               mav.value_int::text,
               mav.value_float::text,
               mav.value_date::text,
               mav.value_bool::text
           )    AS movie_attr_val
FROM movies
         JOIN movieAttributeValues mav ON movies.id = mav.movie_id
         LEFT JOIN movieAttributes ma ON mav.attribute_id = ma.id
         LEFT JOIN movieAttributeTypes mat ON ma.type_id = mat.id
ORDER BY movies.id DESC, ma.id;