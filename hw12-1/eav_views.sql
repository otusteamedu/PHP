-- marketing
CREATE OR REPLACE VIEW public.movie_marketing_view
AS SELECT m.name,
    mac.attribute_class_name,
    ma.attribute_name,
        CASE mat.attribute_type
            WHEN 'text'::text THEN mav.text_value
            WHEN 'boolean'::text THEN mav.bool_value::text
            WHEN 'timestamp'::text THEN mav.date_value::text
            WHEN 'integer'::text THEN mav.int_value::text
            ELSE NULL::text
        END AS value
   FROM movie m
     JOIN movie_attribute_value mav ON mav.movie_id = m.movie_id
     JOIN movie_attribute ma ON ma.attribute_id = mav.attribute_id
     JOIN movie_attribute_type mat ON mat.attribute_type_id = ma.attribute_type_id
     JOIN movie_attribute_class mac ON mac.attribute_class_id = ma.attribute_class_id;

-- service
CREATE OR REPLACE VIEW public.movie_service_view
AS SELECT movie.name,
    today_tasks.attribute_name AS today_task,
    future_tasks.attribute_name AS future_task,
    future_tasks.date_value AS future_task_date
   FROM movie
     LEFT JOIN ( SELECT m.name,
            ma.attribute_name,
            mav.date_value
           FROM movie m
             JOIN movie_attribute_value mav ON mav.movie_id = m.movie_id
             JOIN movie_attribute ma ON ma.attribute_id = mav.attribute_id
          WHERE ma.attribute_class_id = 4 AND mav.date_value = CURRENT_DATE) today_tasks ON today_tasks.name::text = movie.name::text
     LEFT JOIN ( SELECT m.name,
            ma.attribute_name,
            mav.date_value
           FROM movie m
             JOIN movie_attribute_value mav ON mav.movie_id = m.movie_id
             JOIN movie_attribute ma ON ma.attribute_id = mav.attribute_id
          WHERE ma.attribute_class_id = 4 AND mav.date_value >= (CURRENT_DATE + '1 day'::interval day) AND mav.date_value <= (CURRENT_DATE + '20 days'::interval day)) future_tasks ON future_tasks.name::text = movie.name::text;