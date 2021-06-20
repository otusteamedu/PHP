CREATE VIEW actual_tasks AS (
    WITH actual_tasks AS (
        SELECT movies.id AS movie_id, movies_attributes.name AS task_name, movies_attributes_values.date_value AS date
        FROM movies_attributes_values
        INNER JOIN movies_attributes ON movies_attributes_values.attribute_id = movies_attributes.id
        INNER JOIN movies ON movies_attributes_values.movie_id = movies.id
        WHERE movies_attributes.name IN ('Дата начала продажи билетов', 'Дата начала запуска рекламы')
    )
    SELECT movies.name,
           (
               SELECT STRING_AGG(actual_tasks.task_name, ', ')
               FROM actual_tasks
               WHERE actual_tasks.movie_id = movies.id AND actual_tasks.date = current_date
           ) AS tasks_actual_today,
           (
               SELECT STRING_AGG(actual_tasks.task_name, ', ')
               FROM actual_tasks
               WHERE actual_tasks.movie_id = movies.id AND actual_tasks.date = current_date + interval '20' day
           ) AS tasks_actual_in_20_days
    FROM movies
    INNER JOIN actual_tasks ON movies.id = actual_tasks.movie_id
    WHERE actual_tasks.date = current_date OR actual_tasks.date = current_date + interval '20' day
    GROUP BY movies.id
);
