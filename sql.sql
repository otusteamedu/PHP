-- Adminer 4.7.5 PostgreSQL dump

\connect "test";

DROP TABLE IF EXISTS "film";
DROP SEQUENCE IF EXISTS film_id_seq;
CREATE SEQUENCE film_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."film" (
                                 "id" integer DEFAULT nextval('film_id_seq') NOT NULL,
                                 "name" character(255) NOT NULL
) WITH (oids = false);

INSERT INTO "film" ("id", "name") VALUES
(16,	'Девчата                                                                                                                                                                                                                                                        '),
(17,	'Девчата                                                                                                                                                                                                                                                        '),
(18,	'Большая стирка                                                                                                                                                                                                                                                 '),
(19,	'Зеленая миля                                                                                                                                                                                                                                                   '),
(20,	'Самара                                                                                                                                                                                                                                                         '),
(15,	'Rename Rename Rename Rename Rename Rename Rename Девчата                                                                                                                                                                                                       ');

DROP TABLE IF EXISTS "property";
DROP SEQUENCE IF EXISTS property_id_seq;
CREATE SEQUENCE property_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."property" (
                                     "id" integer DEFAULT nextval('property_id_seq') NOT NULL,
                                     "name" character(255) NOT NULL,
                                     "code" integer NOT NULL,
                                     "category" integer NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "property_category";
DROP SEQUENCE IF EXISTS property_category_id_seq;
CREATE SEQUENCE property_category_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."property_category" (
                                              "id" integer DEFAULT nextval('property_category_id_seq') NOT NULL,
                                              "name" integer NOT NULL,
                                              "code" character(255) NOT NULL,
                                              "sort" integer NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "test";
CREATE TABLE "public"."test" (
    "test" integer NOT NULL
) WITH (oids = false);

INSERT INTO "test" ("test") VALUES
(2);

DROP TABLE IF EXISTS "value";
CREATE TABLE "public"."value" (
                                  "id" integer NOT NULL,
                                  "property_id" integer NOT NULL,
                                  "string" character(255) NOT NULL,
                                  "number" integer NOT NULL
) WITH (oids = false);


-- 2020-02-15 15:04:36.829542+00