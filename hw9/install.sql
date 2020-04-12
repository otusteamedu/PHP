CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO movies VALUES (DEFAULT, 'Однажды в Голливуде');
INSERT INTO movies VALUES (DEFAULT, 'Власть');
INSERT INTO movies VALUES (DEFAULT, 'Артимия');



CREATE TABLE IF NOT EXISTS property_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(100) NOT NULL,
    comment VARCHAR(255) DEFAULT '',
    CONSTRAINT property_type_unique UNIQUE (code)
);

CREATE INDEX idx_prop_type_code ON property_types (code);

INSERT INTO property_types VALUES 
    (DEFAULT, 'Рецензии', 'reviews'),
    (DEFAULT, 'Премии', 'awards'),
    (DEFAULT, 'Важные даты', 'important_dates'),
    (DEFAULT, 'Служебные даты', 'service_dates'),
    (DEFAULT, 'Счетчики', 'counters'),
    (DEFAULT, 'Рейтинги', 'ratings')
;



CREATE TABLE IF NOT EXISTS movie_properties (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(100) NOT NULL
);

CREATE INDEX idx_movie_prop_type ON movie_properties (type);

INSERT INTO movie_properties VALUES 
    (DEFAULT, 'Оскар', 'awards'),
    (DEFAULT, 'Золотая пальмовая ветвь', 'awards'),
    (DEFAULT, 'Рецензия одного известного критика', 'reviews'),
    (DEFAULT, 'Рецензия неизвестного критика', 'reviews'),
    (DEFAULT, 'Премьера, мир', 'important_dates'),
    (DEFAULT, 'Премьера, РФ', 'important_dates'),
    (DEFAULT, 'Старт рекламы на TV', 'service_dates'),
    (DEFAULT, 'Старт продажи билетов', 'service_dates'),
    (DEFAULT, 'Сборы в мире', 'counters'),
    (DEFAULT, 'Сборы в РФ', 'counters'),
    (DEFAULT, 'Количество зрителей', 'counters'),
    (DEFAULT, 'Рейтинг Кинопоиск', 'ratings'),
    (DEFAULT, 'Рейтинг критиков', 'ratings')
;



CREATE TABLE IF NOT EXISTS movie_property_values (
    id SERIAL PRIMARY KEY,
    movie INTEGER,
    property INTEGER,
    text_value TEXT,
    date_value DATE,
    boolean_value BOOLEAN,
    integer_value INTEGER,
    float_value NUMERIC(8, 5),
    CONSTRAINT movie_property_unique UNIQUE (movie, property),
    FOREIGN KEY (movie) REFERENCES movies (id),
    FOREIGN KEY (property) REFERENCES movie_properties (id)
);

CREATE INDEX idx_movie_prop_values ON movie_property_values (movie, property);
CREATE INDEX idx_movie_prop_values_dates ON movie_property_values (date_value);
CREATE INDEX idx_movie_prop_values_integer ON movie_property_values (integer_value);
CREATE INDEX idx_movie_prop_values_float ON movie_property_values (float_value);

INSERT INTO movie_property_values (movie, property, boolean_value) VALUES (1, 1, true);
INSERT INTO movie_property_values (movie, property, boolean_value) VALUES (1, 2, false);
INSERT INTO movie_property_values (movie, property, text_value) VALUES (1, 3, 'Отличный фильм!');
INSERT INTO movie_property_values (movie, property, text_value) VALUES (1, 4, 'Фильм так себе');
INSERT INTO movie_property_values (movie, property, date_value) VALUES (1, 5, '2019-05-19');
INSERT INTO movie_property_values (movie, property, date_value) VALUES (1, 6, '2019-08-08');
INSERT INTO movie_property_values (movie, property, date_value) VALUES (1, 7, CURRENT_DATE);
INSERT INTO movie_property_values (movie, property, date_value) VALUES (1, 8, CURRENT_DATE + interval '20 days');
INSERT INTO movie_property_values (movie, property, integer_value) VALUES (1, 9, 372679647);
INSERT INTO movie_property_values (movie, property, integer_value) VALUES (1, 10, 19260721);
INSERT INTO movie_property_values (movie, property, integer_value) VALUES (1, 11, 4300000);
INSERT INTO movie_property_values (movie, property, float_value) VALUES (1, 12, 7.589);
INSERT INTO movie_property_values (movie, property, float_value) VALUES (1, 13, 7.8);

INSERT INTO movie_property_values (movie, property, date_value) VALUES (2, 7, CURRENT_DATE + interval '1 day');
INSERT INTO movie_property_values (movie, property, date_value) VALUES (2, 7, CURRENT_DATE + interval '20 days');

INSERT INTO movie_property_values (movie, property, date_value) VALUES (3, 7, CURRENT_DATE + interval '20 days');
INSERT INTO movie_property_values (movie, property, date_value) VALUES (3, 8, CURRENT_DATE + interval '20 days');



CREATE VIEW tasks AS
    SELECT 
        movies.id AS movie_id, 
        movies.name AS movie_name, 
        today_tasks.task AS today, 
        future_tasks.task AS "in 20 days"
        FROM movies
        LEFT JOIN (
            SELECT movie, mp.name AS task FROM movie_property_values mpv
            LEFT JOIN movie_properties mp ON mpv.property = mp.id
            WHERE mp.type='service_dates' AND date_value=current_date
        ) today_tasks ON movies.id = today_tasks.movie
        LEFT JOIN (
            SELECT movie, mp.name AS task FROM movie_property_values mpv
            LEFT JOIN movie_properties mp ON mpv.property = mp.id
            WHERE mp.type='service_dates' AND date_value=current_date + interval '20 days'
        ) future_tasks ON movies.id = future_tasks.movie
    WHERE today_tasks.task IS NOT NULL OR future_tasks.task IS NOT NULL 
;



CREATE VIEW movie_props AS
    SELECT 
        m.id AS movie_id,
        m.name AS movie_name, 
        mp.name AS property_name, 
        coalesce (
            mpv.boolean_value::text , 
            mpv.date_value::text , 
            mpv.text_value::text , 
            mpv.integer_value::text ,
            mpv.float_value::text
        ) AS property_value 
        FROM movie_property_values mpv
    LEFT JOIN movies m ON m.id = mpv.movie 
    LEFT JOIN movie_properties mp ON mp.id = mpv.property 
    LEFT JOIN property_types pt ON pt.code = mp.type
;
