-- Adminer 4.7.5 PostgreSQL dump

\connect "hw5";

DROP TABLE IF EXISTS "category";
DROP SEQUENCE IF EXISTS category_id_seq;
CREATE SEQUENCE category_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."category" (
                                     "id" integer DEFAULT nextval('category_id_seq') NOT NULL,
                                     "name" character varying NOT NULL,
                                     "code" text,
                                     "sort" integer DEFAULT '500',
                                     CONSTRAINT "category_id_uindex" UNIQUE ("id"),
                                     CONSTRAINT "category_pk" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "category" ("id", "name", "code", "sort") VALUES
(18,	'фильмы',	'film',	100),
(19,	'Зал',	'hall',	200),
(20,	'Расписание',	'timetable',	200);

DROP TABLE IF EXISTS "element";
DROP SEQUENCE IF EXISTS element_id_seq;
CREATE SEQUENCE element_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."element" (
                                    "id" integer DEFAULT nextval('element_id_seq') NOT NULL,
                                    "name" character varying,
                                    "category_id" integer,
                                    "sort" integer,
                                    "code" text,
                                    CONSTRAINT "element_id_uindex" UNIQUE ("id"),
                                    CONSTRAINT "element_pk" PRIMARY KEY ("id"),
                                    CONSTRAINT "element_category_id_fkey" FOREIGN KEY (category_id) REFERENCES category(id) NOT DEFERRABLE
) WITH (oids = false);

INSERT INTO "element" ("id", "name", "category_id", "sort", "code") VALUES
(6,	'Большой зал',	19,	10,	'bit_hall'),
(8,	'3d Зал',	19,	30,	'3d'),
(7,	'Малый зал',	19,	20,	'small'),
(10,	'А зори здесь тихие',	18,	400,	' dawns_here_are_quiet'),
(9,	'Большая перемена',	18,	200,	'big_change'),
(5,	'Девчата!',	18,	10,	'girls');

DROP TABLE IF EXISTS "property";
DROP SEQUENCE IF EXISTS property_id_seq;
CREATE SEQUENCE property_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."property" (
                                     "id" integer DEFAULT nextval('property_id_seq') NOT NULL,
                                     "name" character varying(255),
                                     "code" character varying(255),
                                     "category_id" integer,
                                     "type" character varying(255),
                                     "sort" integer DEFAULT '500',
                                     CONSTRAINT "property_id_uindex" UNIQUE ("id"),
                                     CONSTRAINT "property_pk" PRIMARY KEY ("id"),
                                     CONSTRAINT "property_category_id_fkey" FOREIGN KEY (category_id) REFERENCES category(id) NOT DEFERRABLE
) WITH (oids = false);

INSERT INTO "property" ("id", "name", "code", "category_id", "type", "sort") VALUES
(10,	'Год выпуска',	'year',	18,	'string',	20),
(9,	'Продолжительность',	'duration',	18,	'string',	10),
(11,	'Количество мест',	'count',	19,	'int',	10),
(12,	'рецензии',	'reviews',	18,	'string',	600),
(13,	'премия',	'prize',	18,	'string',	900);

DROP TABLE IF EXISTS "value";
DROP SEQUENCE IF EXISTS value_id_seq;
CREATE SEQUENCE value_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."value" (
                                  "id" integer DEFAULT nextval('value_id_seq') NOT NULL,
                                  "property_id" integer,
                                  "category_id" integer,
                                  "s_value" character varying,
                                  "i_value" integer,
                                  "element_id" integer,
                                  CONSTRAINT "value_id_uindex" UNIQUE ("id"),
                                  CONSTRAINT "value_pk" PRIMARY KEY ("id"),
                                  CONSTRAINT "value_category_id_fkey" FOREIGN KEY (category_id) REFERENCES category(id) NOT DEFERRABLE,
                                  CONSTRAINT "value_element_id_fkey" FOREIGN KEY (element_id) REFERENCES element(id) NOT DEFERRABLE,
                                  CONSTRAINT "value_property_id_fkey" FOREIGN KEY (property_id) REFERENCES property(id) NOT DEFERRABLE
) WITH (oids = false);

INSERT INTO "value" ("id", "property_id", "category_id", value_text, value_integer, "element_id") VALUES
(22,	11,	19,	'',	50,	6),
(23,	11,	19,	'',	20,	8),
(24,	11,	19,	'',	25,	7),
(25,	10,	18,	'1972',	0,	10),
(26,	9,	18,	'3 часа 8 минут',	0,	10),
(27,	12,	18,	'отличный фильм',	0,	10),
(28,	13,	18,	'гремми',	0,	10),
(20,	10,	18,	'1971',	0,	9),
(21,	9,	18,	'258 мин.',	0,	9),
(29,	12,	18,	'тяжелый фильм',	0,	9),
(30,	13,	18,	'оскар',	0,	9),
(18,	10,	18,	'1962',	0,	5),
(19,	9,	18,	'92 минуты',	0,	5),
(31,	12,	18,	'Отличная комедия',	0,	5),
(32,	13,	18,	'Золотая маска',	0,	5);

-- 2020-02-23 18:50:55.717327+00