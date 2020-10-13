CREATE VIEW
    pg_service_data
AS
SELECT f.title AS film_name,
       a.name  AS task_name_today,
       null    AS task_name_after_20_days
FROM films f
         LEFT JOIN attributes a ON a.film_id = f.id
         LEFT JOIN attribute_values av ON av.attribute_id = a.id
WHERE av.date_value = now()::date
UNION
SELECT f.title AS film_name,
       null    AS task_name_today,
       a.name  AS task_name_after_20_days
FROM films f
         LEFT JOIN attributes a ON a.film_id = f.id
         LEFT JOIN attribute_values av ON av.attribute_id = a.id
WHERE av.date_value = now()::date + 20;


CREATE VIEW
    marketing_data
AS
SELECT f.title                   AS film,
       at.name                   AS attribute_type,
       a.name                    AS attribute_name,
       CONCAT(
               av.int_value,
               ';',
               av.string_value,
               ';',
               av.date_value,
               ';',
               av.boolean_value) AS attribute_value
FROM films f
         LEFT JOIN attributes a ON a.film_id = f.id
         LEFT JOIN attribute_types at ON at.id = a.type
         LEFT JOIN attribute_values av ON av.attribute_id = a.id