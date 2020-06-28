CREATE TABLE "films"
(
    "id"          Serial                  NOT NULL,
    "name"        Character Varying(255)  NOT NULL,
    "description" Character Varying(2044),
    "cost"        Numeric(6, 2) DEFAULT 0 NOT NULL,
    "length"      Interval                NOT NULL,
    PRIMARY KEY ("id")
);

COMMENT ON COLUMN "films"."length" IS 'Продолжительность';
COMMENT ON COLUMN "films"."cost" IS 'Стоимость билета';
COMMENT ON TABLE "films" IS 'Фильмы';

CREATE TABLE "halls"
(
    "id"                Serial                  NOT NULL,
    "name"              Character Varying(64)   NOT NULL,
    "description"       Character Varying(2044),
    "price_coefficient" Numeric(3, 2) DEFAULT 1 NOT NULL,
    "width"             SmallInt      DEFAULT 0 NOT NULL,
    "length"            SmallInt      DEFAULT 0 NOT NULL,
    PRIMARY KEY ("id"),
    CONSTRAINT "name_uq" UNIQUE ("name")
);

COMMENT ON COLUMN "halls"."width" IS 'Ширина зала';
COMMENT ON COLUMN "halls"."length" IS 'Длина зала';
COMMENT ON COLUMN "halls"."price_coefficient" IS 'Корректирующий коэффициент, на место, стоимости показа фильма';
COMMENT ON TABLE "halls" IS 'Залы';

CREATE TABLE "rows"
(
    "id"          Serial                NOT NULL,
    "depth"       SmallInt DEFAULT 1000 NOT NULL,
    "description" Character Varying(2044),
    "row_number"  SmallInt              NOT NULL,
    "sections"    SmallInt              NOT NULL,
    "hall_id"     Integer               NOT NULL,
    "is_active"   Boolean  DEFAULT true NOT NULL,
    PRIMARY KEY ("id"),
    CONSTRAINT "hall_row_uq" UNIQUE ("hall_id", "row_number")
);

COMMENT ON COLUMN "rows"."depth" IS 'Глубина ряда';
COMMENT ON COLUMN "rows"."sections" IS 'Количество доступных секций в ряде для размещения мест';
COMMENT ON COLUMN "rows"."is_active" IS 'Действующий ряд или нет';

CREATE TABLE "place"
(
    "id"                Serial                     NOT NULL,
    "sections"          Integer       DEFAULT 1    NOT NULL,
    "price_coefficient" Numeric(3, 2) DEFAULT 1    NOT NULL,
    "description"       Character Varying(2044),
    "depth"             Integer       DEFAULT 1000 NOT NULL,
    PRIMARY KEY ("id")
);

COMMENT ON COLUMN "place"."sections" IS 'Кол-во секций занимаемых в ряде';
COMMENT ON COLUMN "place"."price_coefficient" IS 'Корректирующий коэффициент стоимости места';
COMMENT ON COLUMN "place"."depth" IS 'Глубина места, т.е. максимальная занимаемая площадь места до передне стоящего места совместно с проходом';
COMMENT ON TABLE "place" IS 'Таблица возможных типов мест';
CREATE TABLE "rows_place"
(
    "place_id"     Integer  NOT NULL,
    "id"           Serial   NOT NULL,
    "place_number" SmallInt NOT NULL,
    "row_id"       Integer  NOT NULL,
    PRIMARY KEY ("id"),
    CONSTRAINT "row_place_uq" UNIQUE ("row_id", "place_number")
);

COMMENT ON COLUMN "rows_place"."place_number" IS 'Номер места в ряде';
COMMENT ON TABLE "rows_place" IS 'Таблица указания какой тип места установлен в ряд зала на определенную позицию';

CREATE TABLE "tickets_sold"
(
    "price"         Numeric(6, 2) DEFAULT 0 NOT NULL,
    "id"            Serial                  NOT NULL,
    "session_id"    Integer                 NOT NULL,
    "rows_place_id" Integer,
    PRIMARY KEY ("id"),
    CONSTRAINT session_place_uq UNIQUE ("session_id", "rows_place_id")
);

COMMENT ON COLUMN "tickets_sold"."price" IS 'Вырученная сумма за билет';
COMMENT ON TABLE "tickets_sold" IS 'Проданные билеты';
CREATE INDEX "index_session_id" ON "tickets_sold" USING btree ("session_id");
CREATE INDEX "index_tbl_place_MM_row_id" ON "tickets_sold" USING btree ("rows_place_id");

CREATE TABLE "session"
(
    "id"                Serial        NOT NULL,
    "date_start"        Timestamp Without Time Zone,
    "date_end"          Timestamp Without Time Zone,
    "hall_id"           Integer       NOT NULL,
    "price_coefficient" Numeric(3, 2) NOT NULL,
    "film_id"           Integer       NOT NULL,
    PRIMARY KEY ("id")
);

COMMENT ON COLUMN "session"."date_start" IS 'Время начала сеанса';
COMMENT ON COLUMN "session"."date_end" IS 'Время окончания сеанса';
COMMENT ON COLUMN "session"."price_coefficient" IS 'Корректирующий коэффициент стоимости сеанса';
COMMENT ON TABLE "session" IS 'Сеансы фильмов';
CREATE INDEX "index_hall_id" ON "session" USING btree ("hall_id" Asc NULLS Last);
CREATE INDEX "index_film1_id" ON "session" USING btree ("film_id");

CREATE TABLE "attributes"
(
    "id"        Serial                               NOT NULL,
    "name"      Character Varying(56)                NOT NULL,
    "column"    Character Varying(56) DEFAULT 'text' NOT NULL,
    "type_data" Character Varying(64)                NOT NULL,
    PRIMARY KEY ("id"),
    CONSTRAINT "unique_attribute_name" UNIQUE ("name")
);
;

COMMENT ON COLUMN "attributes"."column" IS 'Наименование столбца';
COMMENT ON COLUMN "attributes"."type_data" IS 'Тип содержимого.';

CREATE TABLE "attribute_value"
(
    "id"           Serial  NOT NULL,
    "numeric"      Decimal,
    "text"         Character Varying(2000),
    "date"         Timestamp Without Time Zone,
    "boolean"      Boolean,
    "interval"     Interval,
    "film_id"      Integer NOT NULL,
    "attribute_id" Integer NOT NULL,

    PRIMARY KEY ("id")
);
;

CREATE INDEX "index_attribute_value_film_id" ON "attribute_value" USING btree ("film_id");
CREATE OR REPLACE VIEW "marketing_data_for_film" AS
SELECT t1.film_id AS film_id, t1.film_name AS film_name, t1.attribute_name AS attribute_name, t1.value AS value
FROM (SELECT flm.id   AS film_id,
             flm.name AS film_name,
             atr.name AS attribute_name,
             CASE
                 WHEN atr.column = 'numeric' THEN av.numeric::text
                 WHEN atr.column = 'text' THEN av.text::text
                 WHEN atr.column = 'date' THEN av.date::TEXT
                 WHEN atr.column = 'interval' THEN av.interval::TEXT
                 WHEN atr.column = 'boolean' THEN av.boolean::TEXT
                 END  AS "value"
      FROM films flm
               INNER JOIN attribute_value av ON flm.id = av.film_id
               INNER JOIN attributes atr ON av.attribute_id = atr.id
      ORDER BY film_id) t1;;

CREATE OR REPLACE VIEW "service_data_for_film" AS
SELECT films.id AS film_id, films.name AS film_name, t1.task AS task_now, t2.task AS task_plus_twenty_days
FROM films
         LEFT JOIN
     (
         SELECT flm.id AS film_id, atr.name AS task
         FROM films flm
                  INNER JOIN attribute_value av ON flm.id = av.film_id
                  INNER JOIN attributes atr ON av.attribute_id = atr.id
         WHERE av.date::date = current_date
     ) t1 ON films.id = t1.film_id
         LEFT JOIN
     (
         SELECT flm.id AS film_id, atr.name AS task
         FROM films flm
                  INNER JOIN attribute_value av ON flm.id = av.film_id
                  INNER JOIN attributes atr ON av.attribute_id = atr.id
         WHERE av.date::date = current_date + interval '20 day'
     ) t2 ON films.id = t2.film_id;

ALTER TABLE "session"
    ADD CONSTRAINT "lnk_film_session" FOREIGN KEY ("film_id")
        REFERENCES "films" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;

ALTER TABLE "session"
    ADD CONSTRAINT "lnk_hall_session" FOREIGN KEY ("hall_id")
        REFERENCES "halls" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;

ALTER TABLE "rows"
    ADD CONSTRAINT "lnk_hall_row" FOREIGN KEY ("hall_id")
        REFERENCES "halls" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;

ALTER TABLE "rows_place"
    ADD CONSTRAINT "lnk_row_has_place" FOREIGN KEY ("row_id")
        REFERENCES "rows" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;

ALTER TABLE "rows_place"
    ADD CONSTRAINT "lnk_place_has_row" FOREIGN KEY ("place_id")
        REFERENCES "place" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;

ALTER TABLE "tickets_sold"
    ADD CONSTRAINT "lnk_tickets_sold_has_place" FOREIGN KEY ("rows_place_id")
        REFERENCES "rows_place" ("id") MATCH FULL
        ON DELETE No Action
        ON UPDATE Cascade;

ALTER TABLE "tickets_sold"
    ADD CONSTRAINT "lnk_session_has_tickets_sold" FOREIGN KEY ("session_id")
        REFERENCES "session" ("id") MATCH FULL
        ON DELETE No Action
        ON UPDATE Cascade;

ALTER TABLE "attribute_value"
    ADD CONSTRAINT "lnk_attribute_has_value" FOREIGN KEY ("attribute_id")
        REFERENCES "attributes" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;

ALTER TABLE "attribute_value"
    ADD CONSTRAINT "lnk_film_has_attribute_value" FOREIGN KEY ("film_id")
        REFERENCES "films" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;

