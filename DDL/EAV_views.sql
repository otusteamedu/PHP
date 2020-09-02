-- Add tasks view
CREATE OR REPLACE VIEW public.date_tasks
AS
SELECT m.title,
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
FROM movie m
         JOIN movie_attr_value mav ON mav.id_movie = m.id
         LEFT JOIN movie_attr ma ON ma.id = mav.id_attr
GROUP BY m.id
ORDER BY m.id;


CREATE OR REPLACE VIEW public.service_information
AS
SELECT m.title  as movie_title,
       ma.name  as movie_attr_name,
       mat.name AS movie_attr_type,
       COALESCE(
               mav.value_text,
               mav.value_int::text,
               mav.value_double::text,
               mav.value_date::text,
               mav.value_boolean::text
           )    AS movie_attr_val
FROM movie m
         JOIN movie_attr_value mav ON m.id = mav.id_movie
         LEFT JOIN movie_attr ma ON mav.id_attr = ma.id
         LEFT JOIN movie_attr_type mat ON ma.id_type = mat.id
ORDER BY m.id DESC, ma.id;