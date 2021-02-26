CREATE DATABASE cinema;

CREATE SCHEMA cinema_storage;

CREATE TABLE movies
(
    id    SERIAL PRIMARY KEY,
    title VARCHAR(255)
);

CREATE TABLE attribute_type
(
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(255),
    description VARCHAR(500)
);

CREATE TABLE attributes
(
    id                SERIAL PRIMARY KEY,
    name              VARCHAR(255),
    attribute_type_id INTEGER REFERENCES attribute_type,
    UNIQUE (name)
);


CREATE TABLE attribute_value
(
    id            SERIAL PRIMARY KEY,
    attributes_id INTEGER REFERENCES attributes,
    movie_id      INTEGER REFERENCES movies,
    text_attribute          TEXT,
    date_attribute          DATE,
    bool_attribute          BOOLEAN,
    integer_attribute       INTEGER,
    float_attribute         FLOAT
);

INSERT INTO movies(title)
VALUES ('Матрица'),
       ('Матрица: Перезагрузка'),
       ('Матрица: Революция');

INSERT INTO attribute_type (name, description)
VALUES ('рецензии', 'рецензии критиков'),
       ('Премия', 'Признак получения награды'),
       ('Важные даты', 'Премьеры'),
       ('Служебные даты', 'Планирование');

INSERT INTO attributes (name, attribute_type_id)
VALUES ('Кинокритики', 1),
       ('Оскар', 2),
       ('Даты выхода фильма', 3),
       ('Даты релиза', 4);

INSERT INTO attribute_value(attributes_id, movie_id, text)
VALUES (1, 1,
        'Тема иллюзорности реальности поднималась в литературе и кино немалое кол-во раз. Все мы знаем и «Футурологический Конгресс» Станислава Лема, «Тёмный город» Алекса Прайса и аниме «Ghost in shell» Осии Мамору. А если ко всему этому вспомнить сколько было фильмов и романов посвящённых теме виртуальной реальности… Впрочем, особенность Матрицы не в этом. Абсолютная оригинальность, которой нет ни у одного известного мне фильма, Матрице тоже не присуща. Особенность её, как и любого выдающегося фильма в том, что Вачовски при её создании взяли всё лучшее, что имелось в этих источниках и соединили эти элементы в свой, поистине не обычный фильм.'),
       (1, 2,
        'Атмосфера – очень важная штука. Каким бы идеальным и захватывающим не был сюжет, какой бы состав актеров не плясал на экране, какие бы миллионы не крутились перед вашим носом в виде миллиардов пикселей без атмосферы смотреть фильм будет невозможно. Атмосфера всеобщего «доброго идиотизма» («Форрест Гамп»), атмосфера страха и ожидания («Психо»), атмосфера напряжения и отторжения («Пила»), все это делает фильм приятным глазу и мозгу. Их любят, их запоминают и пересказывают, а с недавних пор им еще и отдают немалые деньги.'),
       (1, 3,
        'Название третьего фильма, которое звучит как ''Революция'', скорее относится не непосредственно к фильму и к его сюжету, а к нашей жизни, к нашей культуре, к нашей вере, к основоположениям всего того на чем строится наше развитие, мышление, жизненные утверждения, занимающие самое глубокое место в жизни каждого из нас.Разумеется при этом революция направленная на сам кинематограф, при этом оказывая на него вполне мировое, попросту глобальное значение. И ведь так оно и есть, что далеко не каждый возможно способен заметить.');

INSERT INTO attribute_value(attributes_id, movie_id, bool)
VALUES (2, 1, true),
       (2, 2, false),
       (2, 3, false);

INSERT INTO attribute_value(attributes_id, movie_id, date)
VALUES (3, 1, '1999-03-24'),
       (3, 2, '2003-07-06'),
       (3, 3, '2003-10-27');

INSERT INTO attribute_value(attributes_id, movie_id, date)
VALUES (4, 1, '1999-01-11'),
       (4, 2, '2003-01-11'),
       (4, 3, '2003-01-11');

-- Добавляем для примера сегодняшнюю дату и дату через 20 дней.
INSERT INTO attribute_value(attributes_id, movie_id, date)
VALUES (4, 1, '2021-02-26'),
       (4, 1, '2021-03-18');

CREATE VIEW service AS
SELECT (
           SELECT title movies
           FROM movies
           WHERE id = av.movie_id
       ),
       (
           SELECT date tasks_today
        FROM attribute_value
        WHERE attributes_id = 4
        AND date = (now())::date
        ),
        (
        SELECT date tasks_in_20_days
        FROM attribute_value
        WHERE attributes_id = 4
        AND date = (now() + '20 days')::date
        )
        FROM attribute_value av
        WHERE attributes_id = 4
        AND date = (now())::date;

-- SELECT * FROM service;

-- CREATE VIEW movie AS
SELECT (
           SELECT title movies
           FROM movies title
           WHERE id = av.movie_id
       ),
       (
           SELECT name attribute_type
           FROM attribute_type ta
           WHERE ta.id = av.attributes_id
       ),
       (
           SELECT name attribute_name
           FROM attributes a
           WHERE av.attributes_id = a.id
       ),
       text,
       date::text,
       bool::text
FROM attribute_value av;

