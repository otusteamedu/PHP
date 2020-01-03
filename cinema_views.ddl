CREATE VIEW service_data_view AS
(
SELECT m.title   AS movie_title,
       a.name    AS today_task,
       null      AS task_over_20_days,
       v.as_date AS task_date
FROM movies m
         INNER JOIN movies_attributes_values v on m.id = v.id_movie
         INNER JOIN movies_attributes a on v.id_attribute = a.id
WHERE v.as_date = current_date
  AND a.id IN (8, 9)
UNION
SELECT m.title   AS movie_title,
       null      AS today_task,
       a.name    AS task_over_20_days,
       v.as_date AS task_date
FROM movies m
         INNER JOIN movies_attributes_values v on m.id = v.id_movie
         INNER JOIN movies_attributes a on v.id_attribute = a.id
WHERE v.as_date BETWEEN current_date + interval '20 Days' AND current_date + interval '60 Days'
  AND a.id IN (8, 9)
    );

CREATE VIEW marketing_data_view AS
(
SELECT m.title                                  AS movie,
       concat(t.name, ' (', t.description, ')') AS type,
       a.name                                   AS name,
       concat(
               v.as_text, v.as_bool::int, v.as_date, v.as_int, v.as_float, v.as_dec
           )                                    AS value
FROM movies_attributes a
         INNER JOIN movies_attributes_values v on a.id = v.id_attribute
         INNER JOIN movies m on v.id_movie = m.id
         INNER JOIN movies_attributes_types t ON a.type_id = t.id
ORDER BY movie, name
    );