CREATE TABLE film_attribute_type
(
    id_film_attribute_type SERIAL PRIMARY KEY,
    name                   VARCHAR(32) NOT NULL,
    type                   VARCHAR(32) NOT NULL
);

CREATE TABLE film_attribute
(
    id_film_attribute      SERIAL PRIMARY KEY,
    name                   VARCHAR(256) NOT NULL,
    id_film_attribute_type INT REFERENCES film_attribute_type (id_film_attribute_type)
);

CREATE TABLE film_attribute_value
(
    id_film_attribute_value SERIAL PRIMARY KEY,
    id_film                 INT REFERENCES film (id_film),
    id_film_attribute       INT REFERENCES film_attribute (id_film_attribute),
    bool_value              BOOLEAN   NULL,
    int_value               INT       NULL,
    text_value              TEXT      NULL,
    date_value              TIMESTAMP NULL,
    CHECK ( bool_value IS NOT NULL OR int_value IS NOT NULL OR text_value IS NOT NULL OR date_value IS NOT NULL)
);


INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type)
VALUES (1, 'Целое', 'integer');
INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type)
VALUES (2, 'Текст', 'text');
INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type)
VALUES (3, 'Дата', 'timestamp');
INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type)
VALUES (4, 'Да/Нет', 'boolean');
INSERT INTO public.film_attribute_type (id_film_attribute_type, name, type)
VALUES (5, 'Раб.Дата', 'timestamp');
