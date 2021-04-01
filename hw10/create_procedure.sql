create procedure insert_records(first_number int, last_number int)
language sql
as $$
    -- Заполняем список фильмов
    INSERT INTO public.films (id, name, production_year)
    SELECT film.id, random_string(7), random_int(1895, 2021)
    FROM generate_series(first_number, last_number) as film(id);

    -- Заполняем список атрибутов
    INSERT INTO public.films_attrs (id, name, type_id)
    SELECT attr_ids.id, random_string(20), random_int(1, 6)
    FROM generate_series(first_number, last_number) as attr_ids(id);

    -- Заполняем значения атрибутов
    INSERT INTO films_attrs_values (id, film_id, attr_id, value_text, value_bool, value_date, value_float, value_int)
    SELECT nextval('serial'),
           random_int(first_number, last_number),
           films_attrs.id,
           CASE films_attrs.type_id WHEN 1 THEN random_string(7) END,
           CASE films_attrs.type_id WHEN 2 THEN random_boolean() END,
           CASE films_attrs.type_id WHEN 3 THEN random_timestamp()
                                    WHEN 4 THEN random_timestamp()
           END,
           CASE films_attrs.type_id WHEN 5 THEN random_double_precision(10000, 9000000) END,
           CASE films_attrs.type_id WHEN 6 THEN random_int(3, 18) END
    FROM films_attrs
    WHERE films_attrs.id between first_number and last_number;
$$;