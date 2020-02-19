-- EAV ddl
DROP TABLE IF EXISTS attribute_type CASCADE;
CREATE TABLE attribute_type (
    id serial UNIQUE,
    type_name varchar(255) NOT NULL,
    CONSTRAINT attribute_type_pk PRIMARY KEY (id)
);

DROP TABLE IF EXISTS attribute CASCADE;
CREATE TABLE attribute (
    id serial UNIQUE,
    attr_name varchar(255) NOT NULL,
    type_id int,
    CONSTRAINT attribute_pk PRIMARY KEY (id),
    CONSTRAINT attribute_type_fk FOREIGN KEY (type_id) REFERENCES attribute_type(id)
);

DROP TABLE IF EXISTS film CASCADE;
CREATE TABLE film (
    id serial UNIQUE,
    name varchar(255) NOT NULL,
    comment text,
    CONSTRAINT film_pk PRIMARY KEY (id)
);

DROP TABLE IF EXISTS attribute_value CASCADE;
CREATE TABLE attribute_value (
    id serial UNIQUE,
    attribute_id int NOT NULL,
    film_id int NOT NULL,
    val_text text,
    val_numeric numeric,
    val_date date,
    val_bool bool,
    CONSTRAINT attribute_value_pk PRIMARY KEY (id),
    CONSTRAINT attribute_value_attribute_fk FOREIGN KEY (attribute_id) REFERENCES attribute(id),
    CONSTRAINT attribute_value_film_fk FOREIGN KEY (film_id) REFERENCES film(id)
);


-- Init data
INSERT INTO film (name) VALUES ('Побег из Шоушенка');
INSERT INTO film (name) VALUES ('Зеленая миля');
INSERT INTO film (name) VALUES ('Форрест Гамп');
INSERT INTO film (name) VALUES ('Список Шиндлера');
INSERT INTO film (name) VALUES ('1+1');
INSERT INTO film (name) VALUES ('Начало');
INSERT INTO film (name) VALUES ('Леон');
INSERT INTO film (name) VALUES ('Король Лев');

INSERT INTO attribute_type (type_name) VALUES ('Text');
INSERT INTO attribute_type (type_name) VALUES ('Numeric');
INSERT INTO attribute_type (type_name) VALUES ('Date');
INSERT INTO attribute_type (type_name) VALUES ('Boolean');
INSERT INTO attribute_type (type_name) VALUES ('Service date');

INSERT INTO attribute (attr_name, type_id) VALUES ('Слоган', 1);
INSERT INTO attribute (attr_name, type_id) VALUES ('Бюджет, USD', 2);
INSERT INTO attribute (attr_name, type_id) VALUES ('Премия.Оскар', 4);
INSERT INTO attribute (attr_name, type_id) VALUES ('Премия.Золотой глобус', 4);
INSERT INTO attribute (attr_name, type_id) VALUES ('Премия.Ника', 4);
INSERT INTO attribute (attr_name, type_id) VALUES ('Премия.Британская академия', 4);
INSERT INTO attribute (attr_name, type_id) VALUES ('Премия.Эмми', 4);
INSERT INTO attribute (attr_name, type_id) VALUES ('Премьера (мир)', 3);
INSERT INTO attribute (attr_name, type_id) VALUES ('Премьера (РФ)', 3);
INSERT INTO attribute (attr_name, type_id) VALUES ('Заказать рекламу на радио', 5);
INSERT INTO attribute (attr_name, type_id) VALUES ('Заказать контекстную рекламу', 5);
INSERT INTO attribute (attr_name, type_id) VALUES ('Старт продажи билетов в кассах', 5);
INSERT INTO attribute (attr_name, type_id) VALUES ('Старт продажи билетов online', 5);

INSERT INTO attribute_value (attribute_id, film_id, val_text) VALUES (1, 1, 'Страх - это кандалы. Надежда - это свобода');
INSERT INTO attribute_value (attribute_id, film_id, val_numeric) VALUES (2, 1, 25000000);
INSERT INTO attribute_value (attribute_id, film_id, val_bool) VALUES (3, 1, true);
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (8, 1, '1994-09-10');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (9, 1, '2019-10-24');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (10, 1, '2020-02-18');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (11, 1, '2020-02-18');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (12, 1, '2020-03-10');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (13, 1, '2020-03-11');

INSERT INTO attribute_value (attribute_id, film_id, val_text) VALUES (1, 2, 'Пол Эджкомб не верил в чудеса. Пока не столкнулся с одним из них');
INSERT INTO attribute_value (attribute_id, film_id, val_numeric) VALUES (2, 2, 60000000);
INSERT INTO attribute_value (attribute_id, film_id, val_bool) VALUES (3, 2, true);
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (8, 2, '1999-12-06');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (9, 2, '2000-04-18');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (10, 2, '2020-02-19');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (11, 2, '2020-02-18');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (12, 2, '2020-03-05');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (13, 2, '2020-03-20');

INSERT INTO attribute_value (attribute_id, film_id, val_text) VALUES (1, 3, 'Мир уже никогда не будет прежним, после того как вы увидите его глазами Форреста Гампа');
INSERT INTO attribute_value (attribute_id, film_id, val_numeric) VALUES (2, 3, 55000000);
INSERT INTO attribute_value (attribute_id, film_id, val_bool) VALUES (3, 3, true);
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (8, 3, '1994-06-23');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (9, 3, '2020-02-13');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (10, 3, '2020-02-15');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (11, 3, '2020-02-15');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (12, 3, '2020-03-18');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (13, 3, '2020-03-30');

INSERT INTO attribute_value (attribute_id, film_id, val_text) VALUES (1, 4, 'Этот список - жизнь');
INSERT INTO attribute_value (attribute_id, film_id, val_numeric) VALUES (2, 4, 22000000);
INSERT INTO attribute_value (attribute_id, film_id, val_bool) VALUES (3, 4, true);
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (8, 4, '1993-11-30');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (9, 4, '1994-05-21');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (10, 4, '2020-02-15');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (11, 4, '2020-02-20');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (12, 4, '2020-02-19');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (13, 4, '2020-03-30');

INSERT INTO attribute_value (attribute_id, film_id, val_text) VALUES (1, 5, 'Sometimes you have to reach into someone else''s world to find out what''s missing in your own');
INSERT INTO attribute_value (attribute_id, film_id, val_numeric) VALUES (2, 5, 10000000);
INSERT INTO attribute_value (attribute_id, film_id, val_bool) VALUES (4, 5, true);
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (8, 5, '2011-09-11');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (9, 5, '2012-04-26');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (10, 5, '2020-02-21');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (11, 5, '2020-02-20');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (12, 5, '2020-02-28');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (13, 5, '2020-02-28');

INSERT INTO attribute_value (attribute_id, film_id, val_text) VALUES (1, 6, 'Твой разум - место преступления');
INSERT INTO attribute_value (attribute_id, film_id, val_numeric) VALUES (2, 6, 160000000);
INSERT INTO attribute_value (attribute_id, film_id, val_bool) VALUES (3, 6, true);
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (8, 6, '2010-07-08');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (9, 6, '2010-07-22');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (10, 6, '2020-02-21');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (11, 6, '2020-02-20');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (12, 6, '2020-02-28');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (13, 6, '2020-02-28');

INSERT INTO attribute_value (attribute_id, film_id, val_text) VALUES (1, 7, 'Вы не можете остановить того, кого не видно');
INSERT INTO attribute_value (attribute_id, film_id, val_numeric) VALUES (2, 7, 10000000);
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (8, 7, '1994-09-14');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (11, 7, '2020-02-20');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (12, 7, '2020-02-28');

INSERT INTO attribute_value (attribute_id, film_id, val_text) VALUES (1, 8, 'The Circle of Life');
INSERT INTO attribute_value (attribute_id, film_id, val_numeric) VALUES (2, 8, 10000000);
INSERT INTO attribute_value (attribute_id, film_id, val_bool) VALUES (4, 8, true);
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (8, 8, '1994-05-07');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (9, 8, '2012-03-22');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (11, 8, '2020-02-20');
INSERT INTO attribute_value (attribute_id, film_id, val_date) VALUES (12, 8, '2020-02-28');


-- Views
CREATE VIEW "Tasks" AS
    select *
        from (
            select j1."name" as film_name, a."attr_name" as "Задачи на сегодня"
                from (film f join attribute_value av on f.id = av.film_id) as j1
                    join "attribute" as a on j1.attribute_id = a.id
                where (j1.val_date = current_date) and (a.type_id = 5)
        ) as "1d"
        right join (
            select j1."name" as film_name, a."attr_name" as "Задачи на 20 дней"
                from (film f join attribute_value av on f.id = av.film_id) as j1
                         join "attribute" a on j1.attribute_id = a.id
                where (j1.val_date >= (current_date + interval '20 days')) and (a.type_id = 5)
        ) as "20d" using (film_name)
;

CREATE VIEW "Attributes" AS
    SELECT film."name", attribute_type."type_name", "attribute".attr_name,
    CASE
        WHEN av.val_text::text <> '' THEN av.val_text::text
        WHEN av.val_numeric::text <> '' THEN av.val_numeric::text
        WHEN av.val_date::text <> '' THEN av.val_date::text
        WHEN av.val_bool::text <> '' THEN av.val_bool::text
        ELSE 'empty'
    END AS "value"
    FROM (
          film JOIN attribute_value av ON film.id = av.film_id
               JOIN "attribute" ON av.attribute_id = "attribute".id
               JOIN attribute_type ON "attribute".type_id = attribute_type.id
    )
;
