-- фильм, тип атрибута, атрибут, значение (значение выводим как текст) ----

CREATE OR REPLACE VIEW public."movies_attr_data_view" AS
    SELECT t1.movie_id AS movie_id, t1.movie_name AS movie_name, t1.attribute_name AS attribute_name, t1.value AS value
    FROM (SELECT mv.id   AS movie_id,
                 mv.name AS movie_name,
                 a.name AS attribute_name,
        CASE
            WHEN at.name = 'Рецензии' THEN av.value_string::text
            WHEN at.name = 'Премия' THEN av.value_bool::text
            WHEN at.name = 'Рейтинги' THEN av.value_numeric::text
            WHEN at.name = 'Важные даты' THEN av.value_date::text
            WHEN at.name = 'Служебные даты' THEN av.value_date::text
            WHEN at.name = 'Возрастные ограничения' THEN av.value_int::text
        ELSE NULL
        END  AS "value"
        FROM public.movies mv
            INNER JOIN public.movies_attr_value av ON mv.id = av.movie_id
            INNER JOIN public.movies_attr a ON av.movie_attr_id = a.id
            INNER JOIN public.movies_attr_type at ON a.type_id = at.id
        ORDER BY movie_id) t1;;

-- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней ---

CREATE OR REPLACE VIEW public."movie_service_dates" AS
SELECT mv.id AS movie_id, mv.name AS movie_name, t1.task AS task_now, t2.task AS task_future_20_days
FROM public.movies mv
    LEFT JOIN
    (
        SELECT mv.id AS movie_id, a.name AS task
        FROM public.movies mv
        INNER JOIN public.movies_attr_value av ON mv.id = av.movie_id
        INNER JOIN public.movies_attr a ON av.movie_attr_id = a.id
        INNER JOIN public.movies_attr_type at ON at.id = a.type_id
        WHERE at.name = 'Служебные даты'
        AND av.value_date::date = current_date
    ) t1 ON mv.id = t1.movie_id
    LEFT JOIN
    (
        SELECT mv.id AS movie_id, a.name AS task
        FROM public.movies mv
        INNER JOIN public.movies_attr_value av ON mv.id = av.movie_id
        INNER JOIN public.movies_attr a ON av.movie_attr_id = a.id
        INNER JOIN public.movies_attr_type at ON at.id = a.type_id
        WHERE at.name = 'Служебные даты'
        AND av.value_date::date = current_date + interval '20 day'
    ) t2 ON mv.id = t2.movie_id;