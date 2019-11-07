/*
 Navicat Premium Data Transfer

 Source Server         : loc
 Source Server Type    : PostgreSQL
 Source Server Version : 110005
 Source Host           : localhost:5432
 Source Catalog        : postgres
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 110005
 File Encoding         : 65001

 Date: 07/11/2019 10:40:21
*/


-- ----------------------------
-- Sequence structure for filmSession_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."filmSession_id_seq";
CREATE SEQUENCE "public"."filmSession_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for halls_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."halls_id_seq";
CREATE SEQUENCE "public"."halls_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for places_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."places_id_seq";
CREATE SEQUENCE "public"."places_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for relationPlasesSession_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."relationPlasesSession_id_seq";
CREATE SEQUENCE "public"."relationPlasesSession_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 32767
START 1
CACHE 1;

-- ----------------------------
-- Table structure for film
-- ----------------------------
DROP TABLE IF EXISTS "public"."film";
CREATE TABLE "public"."film" (
  "id" int4 NOT NULL DEFAULT nextval('"filmSession_id_seq"'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of film
-- ----------------------------
INSERT INTO "public"."film" VALUES (1, 'Rembo');
INSERT INTO "public"."film" VALUES (2, 'Joker');
INSERT INTO "public"."film" VALUES (3, 'Maleficent');
INSERT INTO "public"."film" VALUES (4, 'Zombieland');
INSERT INTO "public"."film" VALUES (5, 'Gemini Man');
INSERT INTO "public"."film" VALUES (6, 'Haunt');

-- ----------------------------
-- Table structure for film_session
-- ----------------------------
DROP TABLE IF EXISTS "public"."film_session";
CREATE TABLE "public"."film_session" (
  "id" int4 NOT NULL DEFAULT nextval('"filmSession_id_seq"'::regclass),
  "date" timestamp(6) NOT NULL,
  "filmId" int4
)
;

-- ----------------------------
-- Records of film_session
-- ----------------------------
INSERT INTO "public"."film_session" VALUES (7, '2019-10-25 16:00:00', 1);
INSERT INTO "public"."film_session" VALUES (8, '2019-10-25 16:00:00', 2);
INSERT INTO "public"."film_session" VALUES (9, '2019-10-25 16:00:00', 3);
INSERT INTO "public"."film_session" VALUES (10, '2019-10-25 18:00:00', 1);
INSERT INTO "public"."film_session" VALUES (11, '2019-10-25 19:00:00', 3);
INSERT INTO "public"."film_session" VALUES (12, '2019-10-26 09:00:00', 2);
INSERT INTO "public"."film_session" VALUES (13, '2019-10-26 09:00:00', 1);
INSERT INTO "public"."film_session" VALUES (14, '2019-10-26 10:00:00', 4);
INSERT INTO "public"."film_session" VALUES (15, '2019-10-27 10:00:00', 5);

-- ----------------------------
-- Table structure for halls
-- ----------------------------
DROP TABLE IF EXISTS "public"."halls";
CREATE TABLE "public"."halls" (
  "id" int4 NOT NULL DEFAULT nextval('halls_id_seq'::regclass)
)
;

-- ----------------------------
-- Records of halls
-- ----------------------------
INSERT INTO "public"."halls" VALUES (1);
INSERT INTO "public"."halls" VALUES (2);
INSERT INTO "public"."halls" VALUES (3);

-- ----------------------------
-- Table structure for places
-- ----------------------------
DROP TABLE IF EXISTS "public"."places";
CREATE TABLE "public"."places" (
  "id" int2 NOT NULL DEFAULT nextval('places_id_seq'::regclass),
  "num_place" int2 NOT NULL,
  "idHall" int2 NOT NULL,
  "cost" int2 NOT NULL
)
;

-- ----------------------------
-- Records of places
-- ----------------------------
INSERT INTO "public"."places" VALUES (2, 1, 1, 100);
INSERT INTO "public"."places" VALUES (3, 2, 1, 100);
INSERT INTO "public"."places" VALUES (4, 3, 1, 100);
INSERT INTO "public"."places" VALUES (5, 4, 1, 200);
INSERT INTO "public"."places" VALUES (6, 5, 1, 300);
INSERT INTO "public"."places" VALUES (7, 1, 2, 200);
INSERT INTO "public"."places" VALUES (9, 3, 2, 200);
INSERT INTO "public"."places" VALUES (10, 4, 2, 100);
INSERT INTO "public"."places" VALUES (11, 5, 2, 100);
INSERT INTO "public"."places" VALUES (12, 1, 3, 500);
INSERT INTO "public"."places" VALUES (13, 2, 3, 500);
INSERT INTO "public"."places" VALUES (14, 3, 3, 500);
INSERT INTO "public"."places" VALUES (8, 2, 2, 400);

-- ----------------------------
-- Table structure for relation_places_session
-- ----------------------------
DROP TABLE IF EXISTS "public"."relation_places_session";
CREATE TABLE "public"."relation_places_session" (
  "id" int2 NOT NULL DEFAULT nextval('"relationPlasesSession_id_seq"'::regclass),
  "id_film_session" int2 NOT NULL,
  "id_place" int2,
  "free" bool NOT NULL
)
;

-- ----------------------------
-- Records of relation_places_session
-- ----------------------------
INSERT INTO "public"."relation_places_session" VALUES (2, 7, 2, 't');
INSERT INTO "public"."relation_places_session" VALUES (3, 7, 3, 't');
INSERT INTO "public"."relation_places_session" VALUES (4, 7, 4, 'f');
INSERT INTO "public"."relation_places_session" VALUES (5, 7, 5, 'f');
INSERT INTO "public"."relation_places_session" VALUES (6, 7, 6, 'f');
INSERT INTO "public"."relation_places_session" VALUES (7, 7, 6, 't');
INSERT INTO "public"."relation_places_session" VALUES (8, 8, 7, 'f');
INSERT INTO "public"."relation_places_session" VALUES (9, 8, 8, 't');
INSERT INTO "public"."relation_places_session" VALUES (10, 8, 9, 'f');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."filmSession_id_seq"
OWNED BY "public"."film_session"."id";
SELECT setval('"public"."filmSession_id_seq"', 17, true);
ALTER SEQUENCE "public"."halls_id_seq"
OWNED BY "public"."halls"."id";
SELECT setval('"public"."halls_id_seq"', 3, false);
ALTER SEQUENCE "public"."places_id_seq"
OWNED BY "public"."places"."id";
SELECT setval('"public"."places_id_seq"', 15, true);
ALTER SEQUENCE "public"."relationPlasesSession_id_seq"
OWNED BY "public"."relation_places_session"."id";
SELECT setval('"public"."relationPlasesSession_id_seq"', 11, true);

-- ----------------------------
-- Primary Key structure for table film
-- ----------------------------
ALTER TABLE "public"."film" ADD CONSTRAINT "film_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table film_session
-- ----------------------------
CREATE UNIQUE INDEX "id" ON "public"."film_session" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table film_session
-- ----------------------------
ALTER TABLE "public"."film_session" ADD CONSTRAINT "filmSession_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table halls
-- ----------------------------
ALTER TABLE "public"."halls" ADD CONSTRAINT "halls_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table places
-- ----------------------------
ALTER TABLE "public"."places" ADD CONSTRAINT "places_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table relation_places_session
-- ----------------------------
ALTER TABLE "public"."relation_places_session" ADD CONSTRAINT "relationPlasesSession_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table places
-- ----------------------------
ALTER TABLE "public"."places" ADD CONSTRAINT "hall" FOREIGN KEY ("idHall") REFERENCES "public"."halls" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table relation_places_session
-- ----------------------------
ALTER TABLE "public"."relation_places_session" ADD CONSTRAINT "films" FOREIGN KEY ("id_film_session") REFERENCES "public"."film_session" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."relation_places_session" ADD CONSTRAINT "place" FOREIGN KEY ("id_place") REFERENCES "public"."places" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
