BEGIN;


-- CREATE TABLE "film" -----------------------------------------
CREATE TABLE "cinema"."film"
(
    "id"          Serial                  NOT NULL,
    "name"        Character Varying(255)  NOT NULL,
    "description" Character Varying(2044),
    "cost"        Numeric(6, 2) DEFAULT 0 NOT NULL,
    "cost_full"   Numeric(9, 2) DEFAULT 0 NOT NULL,
    "length"      Interval                NOT NULL,
    PRIMARY KEY ("id")
);
;
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "length" -------------------------
COMMENT ON COLUMN "cinema"."film"."length" IS 'Продолжительность фильма';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "cost" -------------------------
COMMENT ON COLUMN "cinema"."film"."cost" IS 'Стоимость одного билета на фильм';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "cost_full" -------------------------
COMMENT ON COLUMN "cinema"."film"."cost_full" IS 'Стоимость фильма в прокате';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "TABLE "film" ---------------------------
COMMENT ON TABLE "cinema"."film" IS 'Таблица фильмов';
-- -------------------------------------------------------------


-- CREATE TABLE "hall" -----------------------------------------
CREATE TABLE "cinema"."hall"
(
    "id"                Serial                  NOT NULL,
    "name"              Character Varying(64)  NOT NULL,
    "description"       Character Varying(2044),
    "price_coefficient" Numeric(3, 2) DEFAULT 1 NOT NULL,
    "width"             SmallInt      DEFAULT 0 NOT NULL,
    "length"            SmallInt      DEFAULT 0 NOT NULL,
    PRIMARY KEY ("id"),
    CONSTRAINT "name_uq" UNIQUE ("name")
);
;
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "width" --------------------------
COMMENT ON COLUMN "cinema"."hall"."width" IS 'Ширина зала';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "length" -------------------------
COMMENT ON COLUMN "cinema"."hall"."length" IS 'Длина зала';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "length" -------------------------
COMMENT ON COLUMN "cinema"."hall"."price_coefficient" IS 'Корректирующий коэффициент, на место, стоимости показа фильма';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "TABLE "hall" ---------------------------
COMMENT ON TABLE "cinema"."hall" IS 'Зал кинотеатра';
-- -------------------------------------------------------------


-- CREATE TABLE "row" ------------------------------------------
CREATE TABLE "cinema"."row"
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
;
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "depth" --------------------------
COMMENT ON COLUMN "cinema"."row"."depth" IS 'Глубина ряда';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "sections" -----------------------
COMMENT ON COLUMN "cinema"."row"."sections" IS 'Количество доступных секций в ряде для размещения мест';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "is_active" -----------------------
COMMENT ON COLUMN "cinema"."row"."is_active" IS 'Действующий ряд или нет';
-- -------------------------------------------------------------


-- CREATE TABLE "place" ----------------------------------------
CREATE TABLE "cinema"."place"
(
    "id"                Serial                     NOT NULL,
    "sections"          Integer       DEFAULT 1    NOT NULL,
    "price_coefficient" Numeric(3, 2) DEFAULT 1    NOT NULL,
    "description"       Character Varying(2044),
    "depth"             Integer       DEFAULT 1000 NOT NULL,
    PRIMARY KEY ("id")
);
;
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "sections" -----------------------
COMMENT ON COLUMN "cinema"."place"."sections" IS 'Кол-во секций занимаемых в ряде';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "price_coefficient" --------------
COMMENT ON COLUMN "cinema"."place"."price_coefficient" IS 'Корректирующий коэффициент стоимости места';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "depth" --------------------------
COMMENT ON COLUMN "cinema"."place"."depth" IS 'Глубина места, т.е. максимальная занимаемая площадь места до передне стоящего места совместно с проходом';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "TABLE "place" --------------------------
COMMENT ON TABLE "cinema"."place" IS 'Таблица возможных типов мест';
-- -------------------------------------------------------------


-- CREATE TABLE "row_has_place" --------------------------------
CREATE TABLE "cinema"."row_has_place"
(
    "place_id"     Integer  NOT NULL,
    "id"           Serial   NOT NULL,
    "place_number" SmallInt NOT NULL,
    "row_id"       Integer  NOT NULL,
    PRIMARY KEY ("id"),
    CONSTRAINT "row_place_uq" UNIQUE ("row_id", "place_number")
);
;
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "price_coefficient" --------------
COMMENT ON COLUMN "cinema"."row_has_place"."place_number" IS 'Номер места в ряде';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "TABLE "row_has_place" --------------------------
COMMENT ON TABLE "cinema"."row_has_place" IS 'Таблица указания какой тип места установлен в ряд зала на определенную позицию';
-- -------------------------------------------------------------


-- CREATE TABLE "tickets_sold" --------------------------------
CREATE TABLE "cinema"."tickets_sold"
(
    "price"            Numeric(6, 2) DEFAULT 0 NOT NULL,
    "id"               Serial                  NOT NULL,
    "session_id"      Integer                 NOT NULL,
    "row_has_place_id" Integer,
    PRIMARY KEY ("id"),
    CONSTRAINT session_place_uq UNIQUE ("session_id", "row_has_place_id")
);
;
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "price" --------------------------
COMMENT ON COLUMN "cinema"."tickets_sold"."price" IS 'Вырученная сумма за билет';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "TABLE "tickets_sold" ------------------
COMMENT ON TABLE "cinema"."tickets_sold" IS 'Проданные билеты';
-- -------------------------------------------------------------

-- CREATE INDEX "index_session_id" ----------------------------
CREATE INDEX "index_session_id" ON "cinema"."tickets_sold" USING btree ("session_id");
-- -------------------------------------------------------------

-- CREATE INDEX "index_tbl_place_MM_row_id" --------------------
CREATE INDEX "index_tbl_place_MM_row_id" ON "cinema"."tickets_sold" USING btree ("row_has_place_id");
-- -------------------------------------------------------------


-- CREATE TABLE "session" -------------------------------------
CREATE TABLE "cinema"."session"
(
    "id"                Serial        NOT NULL,
    "date_start"        Timestamp Without Time Zone,
    "date_end"          Timestamp Without Time Zone,
    "hall_id"           Integer       NOT NULL,
    "price_coefficient" Numeric(3, 2) NOT NULL,
    "film_id"           Integer       NOT NULL,
    PRIMARY KEY ("id")
);
;
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "date_start" ---------------------
COMMENT ON COLUMN "cinema"."session"."date_start" IS 'Время начала сеанса';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "date_end" -----------------------
COMMENT ON COLUMN "cinema"."session"."date_end" IS 'Время окончания сеанса';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "FIELD "price_coefficient" --------------
COMMENT ON COLUMN "cinema"."session"."price_coefficient" IS 'Корректирующий коэффициент стоимости сеанса';
-- -------------------------------------------------------------

-- CHANGE "COMMENT" OF "TABLE "session" -----------------------
COMMENT ON TABLE "cinema"."session" IS 'Сеансы фильмов';
-- -------------------------------------------------------------

-- CREATE INDEX "index_hall_id" --------------------------------
CREATE INDEX "index_hall_id" ON "cinema"."session" USING btree ("hall_id" Asc NULLS Last);
-- -------------------------------------------------------------

-- CREATE INDEX "index_film1_id" -------------------------------
CREATE INDEX "index_film1_id" ON "cinema"."session" USING btree ("film_id");
-- -------------------------------------------------------------


-- CREATE LINK "lnk_film_session" -----------------------------
ALTER TABLE "cinema"."session"
    ADD CONSTRAINT "lnk_film_session" FOREIGN KEY ("film_id")
        REFERENCES "cinema"."film" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;
-- -------------------------------------------------------------

-- CREATE LINK "lnk_hall_session" -----------------------------
ALTER TABLE "cinema"."session"
    ADD CONSTRAINT "lnk_hall_session" FOREIGN KEY ("hall_id")
        REFERENCES "cinema"."hall" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;
-- -------------------------------------------------------------

-- CREATE LINK "lnk_hall_has_row" ----------------------------------
ALTER TABLE "cinema"."row"
    ADD CONSTRAINT "lnk_hall_row" FOREIGN KEY ("hall_id")
        REFERENCES "cinema"."hall" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;
-- -------------------------------------------------------------

-- CREATE LINK "lnk_row_has_place" -----------------------------
ALTER TABLE "cinema"."row_has_place"
    ADD CONSTRAINT "lnk_row_has_place" FOREIGN KEY ("row_id")
        REFERENCES "cinema"."row" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;
-- -------------------------------------------------------------

-- CREATE LINK "lnk_place_has_row" -----------------------------
ALTER TABLE "cinema"."row_has_place"
    ADD CONSTRAINT "lnk_place_has_row" FOREIGN KEY ("place_id")
        REFERENCES "cinema"."place" ("id") MATCH FULL
        ON DELETE Cascade
        ON UPDATE Cascade;
-- -------------------------------------------------------------

-- CREATE LINK "lnk_tickets_sold_has_place" -------------------
ALTER TABLE "cinema"."tickets_sold"
    ADD CONSTRAINT "lnk_tickets_sold_has_place" FOREIGN KEY ("row_has_place_id")
        REFERENCES "cinema"."row_has_place" ("id") MATCH FULL
        ON DELETE No Action
        ON UPDATE Cascade;
-- -------------------------------------------------------------

-- CREATE LINK "lnk_session_has_tickets_sold" ----------------
ALTER TABLE "cinema"."tickets_sold"
    ADD CONSTRAINT "lnk_session_has_tickets_sold" FOREIGN KEY ("session_id")
        REFERENCES "cinema"."session" ("id") MATCH FULL
        ON DELETE No Action
        ON UPDATE Cascade;
-- -------------------------------------------------------------

COMMIT;

