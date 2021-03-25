create table films
(
    id bigint not null
        constraint films_pk
            primary key,
    name varchar(255)
);

create table attr_types
(
    id bigint not null
        constraint attr_types_pk
            primary key,
    name varchar(50) not null unique
);

create table films_attrs
(
    id bigint not null
        constraint films_attrs_pk
            primary key,
    name varchar(100) not null unique,
    type_id bigint not null
        constraint films_attrs_fk
            references attr_types
            on update cascade
);

create table films_attrs_values
(
    id bigint not null
        constraint films_attrs_values_pk
            primary key,
    film_id bigint not null
        constraint films_attrs_values_film_id_fk
            references films
            on update cascade on delete cascade,
    attr_id bigint not null
        constraint films_attrs_values_attr_id_fk
            references films_attrs
            on update cascade,
    value_float double precision,
    value_date timestamp,
    value_text text,
    value_bool boolean,
    value_int integer,
    unique (film_id, attr_id)
);

create view view_data_for_marketing(film_name, attr_type, attr_name, attr_value) as
SELECT films.name AS film_name,
       attr_types.name AS attr_type,
       films_attrs.name AS attr_name,
       COALESCE(
           films_attrs_values.value_bool::text,
           films_attrs_values.value_date::text,
           films_attrs_values.value_float::text,
           films_attrs_values.value_text,
           films_attrs_values.value_int::text) AS attr_value
FROM films_attrs_values
         JOIN films ON films_attrs_values.film_id = films.id
         JOIN films_attrs ON films_attrs.id = films_attrs_values.attr_id
         JOIN attr_types ON films_attrs.type_id = attr_types.id
ORDER BY films.name, attr_types.name;

create view view_tasks_today_and_20_days(film_name, tasks_today, tasks_20_days) as
WITH tasks_today AS (
    SELECT films_attrs_values.film_id,
           films_attrs.name AS attr_name
    FROM films_attrs_values
             JOIN films_attrs ON films_attrs_values.attr_id = films_attrs.id
    WHERE films_attrs.type_id = 4
      AND films_attrs_values.value_date = CURRENT_DATE
),
     tasks_20_days AS (
         SELECT films_attrs_values.film_id,
                films_attrs.name AS attr_name
         FROM films_attrs_values
                  JOIN films_attrs ON films_attrs_values.attr_id = films_attrs.id
         WHERE films_attrs.type_id = 4
           AND films_attrs_values.value_date = (CURRENT_DATE + interval '20 days')
     )
SELECT films.name              AS film_name,
       tasks_today.attr_name   AS tasks_today,
       tasks_20_days.attr_name AS tasks_20_days
FROM films
         LEFT JOIN tasks_today ON tasks_today.film_id = films.id
         LEFT JOIN tasks_20_days ON tasks_20_days.film_id = films.id
WHERE NOT tasks_today.attr_name IS NULL
   OR NOT tasks_20_days.attr_name IS NULL
ORDER BY films.name, tasks_today, tasks_20_days;
