\connect movie_eav

CREATE VIEW marketing_info AS
    SELECT 
        m.title AS movie,
        a.name AS attribute,
        at.name AS type,
        CASE
            WHEN at.code = 'date' THEN to_char(val.value_date, 'DD.MM.YYYY')
            WHEN at.code = 'integer' THEN cast(val.value_int as VARCHAR)
            WHEN at.code = 'dict' THEN (SELECT value FROM movie_attribute_dict_value WHERE id = val.value_int)
            WHEN at.code = 'numeric' THEN cast(val.value_num as VARCHAR)
            WHEN at.code = 'text' THEN val.value_text
            ELSE ''
        END as value
    FROM movie_attribute_value AS val
    JOIN movie AS m ON m.id = val.movie_id
    JOIN movie_attribute AS a ON a.id = val.movie_attribute_id
    JOIN attribute_type AS at ON at.id = a.attribute_type_id;

CREATE VIEW tasks AS
    WITH task_name AS (
        SELECT
            id,
            CASE
                WHEN code = 'date_adv' THEN 'Запустить рекламу'
                WHEN code = 'date_print_posters' THEN 'Напечатать постеры'
                WHEN code = 'date_start' THEN 'Запустить в прокат'
                ELSE ''
            END as name
        FROM    
            movie_attribute
    )

    SELECT 
        m.title AS movie,
        CASE
            WHEN val.value_date = current_date THEN tn.name
            ELSE ''
        END as today_task,
        CASE
            WHEN val.value_date = current_date + interval '20' day THEN tn.name
            ELSE ''
        END as task_in_20_days
    FROM
        movie_attribute_value AS val
    JOIN movie AS m ON m.id = val.movie_id
    JOIN task_name AS tn ON tn.id = val.movie_attribute_id 
    WHERE
        val.value_date = current_date OR val.value_date = current_date + interval '20' day
    ORDER BY val.value_date;



