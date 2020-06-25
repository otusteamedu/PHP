/*
 Navicat PostgreSQL Data Transfer

 Source Server         : leffalt
 Source Server Type    : PostgreSQL
 Source Server Version : 120003
 Source Host           : localhost:5432
 Source Catalog        : cinema_control_system
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 120003
 File Encoding         : 65001

 Date: 25/06/2020 17:54:42
*/


-- ----------------------------
-- Table structure for base_cost
-- ----------------------------
DROP TABLE IF EXISTS "public"."base_cost";
CREATE TABLE "public"."base_cost" (
  "base_cost_id" int4 NOT NULL,
  "time" time(6) NOT NULL,
  "cost" numeric(12,4) NOT NULL
)
;

-- ----------------------------
-- Table structure for cinema
-- ----------------------------
DROP TABLE IF EXISTS "public"."cinema";
CREATE TABLE "public"."cinema" (
  "cinema_id" int2 NOT NULL,
  "ctitle" varchar(255) COLLATE "pg_catalog"."default",
  "address" varchar(255) COLLATE "pg_catalog"."default",
  "phone" varchar(255) COLLATE "pg_catalog"."default",
  "district" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for clients
-- ----------------------------
DROP TABLE IF EXISTS "public"."clients";
CREATE TABLE "public"."clients" (
  "clients_id" int4 NOT NULL,
  "email" varchar(255) COLLATE "pg_catalog"."default",
  "phone" varchar(255) COLLATE "pg_catalog"."default",
  "login" varchar(255) COLLATE "pg_catalog"."default",
  "ticket_id" int4
)
;

-- ----------------------------
-- Table structure for film
-- ----------------------------
DROP TABLE IF EXISTS "public"."film";
CREATE TABLE "public"."film" (
  "film_id" int2 NOT NULL,
  "country" varchar(255) COLLATE "pg_catalog"."default",
  "release_date" date,
  "genre_id" int2 NOT NULL,
  "description" text COLLATE "pg_catalog"."default",
  "ftitle" varchar(255) COLLATE "pg_catalog"."default" NOT NULL
)
;

-- ----------------------------
-- Table structure for genre
-- ----------------------------
DROP TABLE IF EXISTS "public"."genre";
CREATE TABLE "public"."genre" (
  "genre_id" int2 NOT NULL,
  "genre" varchar(255) COLLATE "pg_catalog"."default",
  "description" text COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for hall
-- ----------------------------
DROP TABLE IF EXISTS "public"."hall";
CREATE TABLE "public"."hall" (
  "hall_id" int2 NOT NULL,
  "htitle" varchar(255) COLLATE "pg_catalog"."default",
  "is_works" bool NOT NULL,
  "cinema_id" int2 NOT NULL,
  "hall_rating_id" int4 NOT NULL DEFAULT 1
)
;
COMMENT ON COLUMN "public"."hall"."cinema_id" IS 'Внешний ключ к таблице сinema.cinema_id';

-- ----------------------------
-- Table structure for hall_rating
-- ----------------------------
DROP TABLE IF EXISTS "public"."hall_rating";
CREATE TABLE "public"."hall_rating" (
  "hall_rating_id" int4 NOT NULL,
  "hall_coef" numeric(4,2) NOT NULL DEFAULT 1
)
;

-- ----------------------------
-- Table structure for place
-- ----------------------------
DROP TABLE IF EXISTS "public"."place";
CREATE TABLE "public"."place" (
  "place_id" int2 NOT NULL,
  "place_no" int2 NOT NULL,
  "row_no" int2 NOT NULL,
  "category_place" varchar(10) COLLATE "pg_catalog"."default" NOT NULL
)
;

-- ----------------------------
-- Table structure for place_rating
-- ----------------------------
DROP TABLE IF EXISTS "public"."place_rating";
CREATE TABLE "public"."place_rating" (
  "category_place" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "place_coef" numeric(4,2) NOT NULL
)
;

-- ----------------------------
-- Table structure for session
-- ----------------------------
DROP TABLE IF EXISTS "public"."session";
CREATE TABLE "public"."session" (
  "session_id" int2 NOT NULL,
  "date" date NOT NULL,
  "time" time(6) NOT NULL,
  "hall_id" int2 NOT NULL,
  "place_id" int2 NOT NULL,
  "film_id" int2 NOT NULL,
  "session_rating_id" int4 NOT NULL,
  "tickets_id" int4 NOT NULL,
  "base_cost_id" int4 NOT NULL
)
;

-- ----------------------------
-- Table structure for session_rating
-- ----------------------------
DROP TABLE IF EXISTS "public"."session_rating";
CREATE TABLE "public"."session_rating" (
  "session_rating_id" int4 NOT NULL,
  "date" date NOT NULL,
  "time" time(6) NOT NULL,
  "session_coef" numeric(4,2) NOT NULL
)
;

-- ----------------------------
-- Table structure for tickets
-- ----------------------------
DROP TABLE IF EXISTS "public"."tickets";
CREATE TABLE "public"."tickets" (
  "ticket_id" int4 NOT NULL,
  "clients_id" int4 NOT NULL
)
;

-- ----------------------------
-- View structure for ticket_for_client
-- ----------------------------
DROP VIEW IF EXISTS "public"."ticket_for_client";
CREATE VIEW "public"."ticket_for_client" AS  SELECT 
	session.date,
    session."time",
    film.ftitle,
    cinema.ctitle,
    hall.htitle,
    place.place_no,
    place.row_no,
    tickets.ticket_id,
    (((base_cost.cost * session_rating.session_coef) * hall_rating.hall_coef) * place_rating.place_coef) AS tick_cost
   FROM (((((((((session
     JOIN hall ON ((session.hall_id = hall.hall_id)))
     JOIN hall_rating ON ((hall.hall_rating_id = hall_rating.hall_rating_id)))
     JOIN cinema ON ((hall.cinema_id = cinema.cinema_id)))
     JOIN place ON ((session.place_id = place.place_id)))
     JOIN place_rating ON (((place.category_place)::text = (place_rating.category_place)::text)))
     JOIN film ON ((session.film_id = film.film_id)))
     JOIN session_rating ON ((session.session_rating_id = session_rating.session_rating_id)))
     JOIN tickets ON ((session.tickets_id = tickets.ticket_id)))
     JOIN base_cost ON ((session.base_cost_id = base_cost.base_cost_id)));

-- ----------------------------
-- Primary Key structure for table base_cost
-- ----------------------------
ALTER TABLE "public"."base_cost" ADD CONSTRAINT "base_cost_pkey" PRIMARY KEY ("base_cost_id");

-- ----------------------------
-- Primary Key structure for table cinema
-- ----------------------------
ALTER TABLE "public"."cinema" ADD CONSTRAINT "cinema_pkey" PRIMARY KEY ("cinema_id");

-- ----------------------------
-- Primary Key structure for table clients
-- ----------------------------
ALTER TABLE "public"."clients" ADD CONSTRAINT "clients_pkey" PRIMARY KEY ("clients_id");

-- ----------------------------
-- Uniques structure for table film
-- ----------------------------
ALTER TABLE "public"."film" ADD CONSTRAINT "uk_filmid" UNIQUE ("film_id");
COMMENT ON CONSTRAINT "uk_filmid" ON "public"."film" IS 'set_unique_film_id';

-- ----------------------------
-- Primary Key structure for table film
-- ----------------------------
ALTER TABLE "public"."film" ADD CONSTRAINT "film_pkey" PRIMARY KEY ("film_id");

-- ----------------------------
-- Primary Key structure for table genre
-- ----------------------------
ALTER TABLE "public"."genre" ADD CONSTRAINT "genre_pkey" PRIMARY KEY ("genre_id");

-- ----------------------------
-- Uniques structure for table hall
-- ----------------------------
ALTER TABLE "public"."hall" ADD CONSTRAINT "uk_hallid" UNIQUE ("hall_id");
COMMENT ON CONSTRAINT "uk_hallid" ON "public"."hall" IS 'uniq_for_session';

-- ----------------------------
-- Primary Key structure for table hall
-- ----------------------------
ALTER TABLE "public"."hall" ADD CONSTRAINT "hall_pkey" PRIMARY KEY ("hall_id");

-- ----------------------------
-- Primary Key structure for table hall_rating
-- ----------------------------
ALTER TABLE "public"."hall_rating" ADD CONSTRAINT "hall_rating_pkey" PRIMARY KEY ("hall_rating_id");

-- ----------------------------
-- Checks structure for table place
-- ----------------------------
ALTER TABLE "public"."place" ADD CONSTRAINT "place_check" CHECK (category_place::text = ANY (ARRAY['VIP'::character varying::text, 'normal'::character varying::text, 'econom'::character varying::text]));

-- ----------------------------
-- Primary Key structure for table place
-- ----------------------------
ALTER TABLE "public"."place" ADD CONSTRAINT "place_pkey" PRIMARY KEY ("place_id");

-- ----------------------------
-- Primary Key structure for table place_rating
-- ----------------------------
ALTER TABLE "public"."place_rating" ADD CONSTRAINT "place_rating_pkey" PRIMARY KEY ("category_place");

-- ----------------------------
-- Uniques structure for table session
-- ----------------------------
ALTER TABLE "public"."session" ADD CONSTRAINT "uk_sessionid" UNIQUE ("session_id");
COMMENT ON CONSTRAINT "uk_sessionid" ON "public"."session" IS 'set_uniq_seesionid';

-- ----------------------------
-- Primary Key structure for table session
-- ----------------------------
ALTER TABLE "public"."session" ADD CONSTRAINT "session_pkey" PRIMARY KEY ("session_id");

-- ----------------------------
-- Primary Key structure for table session_rating
-- ----------------------------
ALTER TABLE "public"."session_rating" ADD CONSTRAINT "session_rating_pkey" PRIMARY KEY ("session_rating_id");

-- ----------------------------
-- Uniques structure for table tickets
-- ----------------------------
ALTER TABLE "public"."tickets" ADD CONSTRAINT "uk_clients_id" UNIQUE ("clients_id");

-- ----------------------------
-- Primary Key structure for table tickets
-- ----------------------------
ALTER TABLE "public"."tickets" ADD CONSTRAINT "tickets_pkey" PRIMARY KEY ("ticket_id");

-- ----------------------------
-- Foreign Keys structure for table clients
-- ----------------------------
ALTER TABLE "public"."clients" ADD CONSTRAINT "fk_tickets_clients" FOREIGN KEY ("clients_id") REFERENCES "public"."tickets" ("clients_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table film
-- ----------------------------
ALTER TABLE "public"."film" ADD CONSTRAINT "fk_genres" FOREIGN KEY ("genre_id") REFERENCES "public"."genre" ("genre_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table hall
-- ----------------------------
ALTER TABLE "public"."hall" ADD CONSTRAINT "fk_cinema" FOREIGN KEY ("cinema_id") REFERENCES "public"."cinema" ("cinema_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."hall" ADD CONSTRAINT "fk_hall_rating" FOREIGN KEY ("hall_rating_id") REFERENCES "public"."hall_rating" ("hall_rating_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table place
-- ----------------------------
ALTER TABLE "public"."place" ADD CONSTRAINT "fk_place_rating" FOREIGN KEY ("category_place") REFERENCES "public"."place_rating" ("category_place") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table session
-- ----------------------------
ALTER TABLE "public"."session" ADD CONSTRAINT "fk_base_cost" FOREIGN KEY ("base_cost_id") REFERENCES "public"."base_cost" ("base_cost_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."session" ADD CONSTRAINT "fk_film" FOREIGN KEY ("film_id") REFERENCES "public"."film" ("film_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."session" ADD CONSTRAINT "fk_hall" FOREIGN KEY ("hall_id") REFERENCES "public"."hall" ("hall_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."session" ADD CONSTRAINT "fk_place" FOREIGN KEY ("place_id") REFERENCES "public"."place" ("place_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."session" ADD CONSTRAINT "fk_session_rating" FOREIGN KEY ("session_rating_id") REFERENCES "public"."session_rating" ("session_rating_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."session" ADD CONSTRAINT "fk_tickets" FOREIGN KEY ("tickets_id") REFERENCES "public"."tickets" ("ticket_id") ON DELETE CASCADE ON UPDATE CASCADE;
