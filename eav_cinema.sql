/*
 Navicat Premium Data Transfer

 Source Server         : loc
 Source Server Type    : PostgreSQL
 Source Server Version : 110005
 Source Host           : localhost:5432
 Source Catalog        : postgres
 Source Schema         : eav_cinema

 Target Server Type    : PostgreSQL
 Target Server Version : 110005
 File Encoding         : 65001

 Date: 17/12/2019 15:01:36
*/


-- ----------------------------
-- Table structure for film
-- ----------------------------
DROP TABLE IF EXISTS "eav_cinema"."film";
CREATE TABLE "eav_cinema"."film" (
  "id" int4 NOT NULL DEFAULT nextval('"filmSession_id_seq"'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of film
-- ----------------------------
INSERT INTO "eav_cinema"."film" VALUES (1, 'Rembo');
INSERT INTO "eav_cinema"."film" VALUES (2, 'Joker');
INSERT INTO "eav_cinema"."film" VALUES (3, 'Maleficent');
INSERT INTO "eav_cinema"."film" VALUES (4, 'Zombieland');
INSERT INTO "eav_cinema"."film" VALUES (5, 'Gemini Man');
INSERT INTO "eav_cinema"."film" VALUES (6, 'Haunt');

-- ----------------------------
-- Table structure for film_attributes
-- ----------------------------
DROP TABLE IF EXISTS "eav_cinema"."film_attributes";
CREATE TABLE "eav_cinema"."film_attributes" (
  "id" int8 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of film_attributes
-- ----------------------------
INSERT INTO "eav_cinema"."film_attributes" VALUES (1, 'рецензии');
INSERT INTO "eav_cinema"."film_attributes" VALUES (2, 'премия');
INSERT INTO "eav_cinema"."film_attributes" VALUES (3, 'важные даты');
INSERT INTO "eav_cinema"."film_attributes" VALUES (4, 'служебные даты');

-- ----------------------------
-- Table structure for film_attributes_types
-- ----------------------------
DROP TABLE IF EXISTS "eav_cinema"."film_attributes_types";
CREATE TABLE "eav_cinema"."film_attributes_types" (
  "id" int8 NOT NULL,
  "type" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of film_attributes_types
-- ----------------------------
INSERT INTO "eav_cinema"."film_attributes_types" VALUES (1, 'text');
INSERT INTO "eav_cinema"."film_attributes_types" VALUES (2, 'bool');
INSERT INTO "eav_cinema"."film_attributes_types" VALUES (3, 'int');
INSERT INTO "eav_cinema"."film_attributes_types" VALUES (4, 'date');

-- ----------------------------
-- Table structure for film_attributes_values
-- ----------------------------
DROP TABLE IF EXISTS "eav_cinema"."film_attributes_values";
CREATE TABLE "eav_cinema"."film_attributes_values" (
  "id" int8 NOT NULL,
  "film_id" int8,
  "attribute_id" int8,
  "attribute_type_id" int8,
  "value_text" text COLLATE "pg_catalog"."default",
  "value_bool" bool,
  "value_date" timestamp(6),
  "value_int" int4
)
;

-- ----------------------------
-- Records of film_attributes_values
-- ----------------------------
INSERT INTO "eav_cinema"."film_attributes_values" VALUES (1, 1, 1, 1, 'Текст рецензии', NULL, NULL, NULL);
INSERT INTO "eav_cinema"."film_attributes_values" VALUES (2, 2, 1, 1, 'Текст рецензии 2', NULL, NULL, NULL);
INSERT INTO "eav_cinema"."film_attributes_values" VALUES (4, 1, 2, 3, NULL, NULL, NULL, 2);
INSERT INTO "eav_cinema"."film_attributes_values" VALUES (3, 1, 3, 4, NULL, NULL, '2019-12-17 13:11:25', NULL);

-- ----------------------------
-- Function structure for random
-- ----------------------------
DROP FUNCTION IF EXISTS "eav_cinema"."random"(numeric, numeric);
CREATE OR REPLACE FUNCTION "eav_cinema"."random"(numeric, numeric)
  RETURNS "pg_catalog"."numeric" AS $BODY$
   SELECT ($1 + ($2 - $1) * random())::numeric;
$BODY$
  LANGUAGE sql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for random_string
-- ----------------------------
DROP FUNCTION IF EXISTS "eav_cinema"."random_string"("length" int4);
CREATE OR REPLACE FUNCTION "eav_cinema"."random_string"("length" int4)
  RETURNS "pg_catalog"."text" AS $BODY$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- View structure for today
-- ----------------------------
DROP VIEW IF EXISTS "eav_cinema"."today";
CREATE VIEW "eav_cinema"."today" AS  SELECT f.id,
    f.name,
    film_attributes.name AS name_task
   FROM (((eav_cinema.film f
     LEFT JOIN eav_cinema.film_attributes_values ON ((film_attributes_values.film_id = f.id)))
     LEFT JOIN eav_cinema.film_attributes_types ON ((film_attributes_types.id = film_attributes_values.attribute_type_id)))
     LEFT JOIN eav_cinema.film_attributes ON ((film_attributes.id = film_attributes_values.attribute_id)))
  WHERE (((film_attributes_types.type)::text = 'date'::text) AND ((film_attributes_values.value_date)::date = '2019-12-17'::date));

-- ----------------------------
-- View structure for day20
-- ----------------------------
DROP VIEW IF EXISTS "eav_cinema"."day20";
CREATE VIEW "eav_cinema"."day20" AS  SELECT f.id,
    f.name,
    film_attributes.name AS name_task
   FROM (((eav_cinema.film f
     LEFT JOIN eav_cinema.film_attributes_values ON ((film_attributes_values.film_id = f.id)))
     LEFT JOIN eav_cinema.film_attributes_types ON ((film_attributes_types.id = film_attributes_values.attribute_type_id)))
     LEFT JOIN eav_cinema.film_attributes ON ((film_attributes.id = film_attributes_values.attribute_id)))
  WHERE (((film_attributes_types.type)::text = 'date'::text) AND ((film_attributes_values.value_date)::date = ('2019-12-17'::date + '20 days'::interval)));

-- ----------------------------
-- View structure for tasks
-- ----------------------------
DROP VIEW IF EXISTS "eav_cinema"."tasks";
CREATE VIEW "eav_cinema"."tasks" AS  SELECT f.name,
    today.name_task AS today_task,
    day20.name_task AS day20_name_task
   FROM ((eav_cinema.film f
     LEFT JOIN eav_cinema.today ON ((f.id = today.id)))
     LEFT JOIN eav_cinema.day20 ON ((f.id = day20.id)))
  WHERE ((today.name_task IS NOT NULL) OR (day20.name_task IS NOT NULL));

-- ----------------------------
-- View structure for marketing
-- ----------------------------
DROP VIEW IF EXISTS "eav_cinema"."marketing";
CREATE VIEW "eav_cinema"."marketing" AS  SELECT f.name,
    film_attributes_types.type,
    film_attributes.name AS attribut_name,
    concat(fav.value_text, fav.value_bool, fav.value_date, fav.value_int) AS val
   FROM (((eav_cinema.film f
     LEFT JOIN eav_cinema.film_attributes_values fav ON ((fav.film_id = f.id)))
     LEFT JOIN eav_cinema.film_attributes_types ON ((film_attributes_types.id = fav.attribute_type_id)))
     LEFT JOIN eav_cinema.film_attributes ON ((film_attributes.id = fav.attribute_id)));

-- ----------------------------
-- Primary Key structure for table film
-- ----------------------------
ALTER TABLE "eav_cinema"."film" ADD CONSTRAINT "film_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table film_attributes
-- ----------------------------
ALTER TABLE "eav_cinema"."film_attributes" ADD CONSTRAINT "film_attributes_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table film_attributes_types
-- ----------------------------
ALTER TABLE "eav_cinema"."film_attributes_types" ADD CONSTRAINT "film_attributes_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table film_attributes_values
-- ----------------------------
CREATE INDEX "film_id" ON "eav_cinema"."film_attributes_values" USING btree (
  "film_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table film_attributes_values
-- ----------------------------
ALTER TABLE "eav_cinema"."film_attributes_values" ADD CONSTRAINT "film_attributes_values_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table film_attributes_values
-- ----------------------------
ALTER TABLE "eav_cinema"."film_attributes_values" ADD CONSTRAINT "attribute_film" FOREIGN KEY ("film_id") REFERENCES "eav_cinema"."film" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
