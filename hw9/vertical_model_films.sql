/*
 Navicat PostgreSQL Data Transfer

 Source Server         : leffalt
 Source Server Type    : PostgreSQL
 Source Server Version : 120003
 Source Host           : localhost:5432
 Source Catalog        : vertical_model_films
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 120003
 File Encoding         : 65001

 Date: 28/06/2020 22:03:05
*/


-- ----------------------------
-- Sequence structure for films_attribute_attr_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."films_attribute_attr_id_seq";
CREATE SEQUENCE "public"."films_attribute_attr_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for films_entity_film_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."films_entity_film_id_seq";
CREATE SEQUENCE "public"."films_entity_film_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for films_types_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."films_types_type_id_seq";
CREATE SEQUENCE "public"."films_types_type_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for films_value_val_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."films_value_val_id_seq";
CREATE SEQUENCE "public"."films_value_val_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Table structure for films_attribute
-- ----------------------------
DROP TABLE IF EXISTS "public"."films_attribute";
CREATE TABLE "public"."films_attribute" (
  "attr_id" int4 NOT NULL DEFAULT nextval('films_attribute_attr_id_seq'::regclass),
  "type_id" int4 NOT NULL,
  "attr_title" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."films_attribute"."type_id" IS 'fk for films_types';

-- ----------------------------
-- Records of films_attribute
-- ----------------------------
INSERT INTO "public"."films_attribute" VALUES (1, 4, 'Release date');
INSERT INTO "public"."films_attribute" VALUES (2, 2, 'Country');
INSERT INTO "public"."films_attribute" VALUES (3, 2, 'Director');
INSERT INTO "public"."films_attribute" VALUES (4, 2, 'Screenplay');
INSERT INTO "public"."films_attribute" VALUES (5, 3, 'USA fees ');
INSERT INTO "public"."films_attribute" VALUES (6, 3, 'Russia fees');
INSERT INTO "public"."films_attribute" VALUES (7, 5, 'Advertising company');
INSERT INTO "public"."films_attribute" VALUES (8, 5, 'In screen');
INSERT INTO "public"."films_attribute" VALUES (9, 5, 'Out screen');
INSERT INTO "public"."films_attribute" VALUES (11, 6, 'Runtime');
INSERT INTO "public"."films_attribute" VALUES (10, 5, 'Profit date');
INSERT INTO "public"."films_attribute" VALUES (12, 7, 'Awards');

-- ----------------------------
-- Table structure for films_entity
-- ----------------------------
DROP TABLE IF EXISTS "public"."films_entity";
CREATE TABLE "public"."films_entity" (
  "film_id" int4 NOT NULL DEFAULT nextval('films_entity_film_id_seq'::regclass),
  "film_title" varchar(255) COLLATE "pg_catalog"."default" NOT NULL
)
;

-- ----------------------------
-- Records of films_entity
-- ----------------------------
INSERT INTO "public"."films_entity" VALUES (1, 'Forrest Gump');

-- ----------------------------
-- Table structure for films_types
-- ----------------------------
DROP TABLE IF EXISTS "public"."films_types";
CREATE TABLE "public"."films_types" (
  "type_id" int4 NOT NULL DEFAULT nextval('films_types_type_id_seq'::regclass),
  "type_title" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of films_types
-- ----------------------------
INSERT INTO "public"."films_types" VALUES (1, 'Date');
INSERT INTO "public"."films_types" VALUES (2, 'Text');
INSERT INTO "public"."films_types" VALUES (4, 'Importante date');
INSERT INTO "public"."films_types" VALUES (5, 'Service date');
INSERT INTO "public"."films_types" VALUES (3, 'Float number');
INSERT INTO "public"."films_types" VALUES (6, 'Integer number');
INSERT INTO "public"."films_types" VALUES (7, 'Boolean');

-- ----------------------------
-- Table structure for films_value
-- ----------------------------
DROP TABLE IF EXISTS "public"."films_value";
CREATE TABLE "public"."films_value" (
  "value_id" int4 NOT NULL DEFAULT nextval('films_value_val_id_seq'::regclass),
  "film_id" int4 NOT NULL,
  "attr_id" int4 NOT NULL,
  "value_date" date,
  "value_numeric" numeric(255),
  "value_bool" bool,
  "value_text" text COLLATE "pg_catalog"."default",
  "value_int" int4
)
;
COMMENT ON COLUMN "public"."films_value"."film_id" IS 'fk for films_entity';
COMMENT ON COLUMN "public"."films_value"."attr_id" IS 'fk for films_attribute';

-- ----------------------------
-- Records of films_value
-- ----------------------------
INSERT INTO "public"."films_value" VALUES (1, 1, 1, '1994-06-23', NULL, NULL, NULL, NULL);
INSERT INTO "public"."films_value" VALUES (11, 1, 9, '2020-06-21', NULL, NULL, NULL, NULL);
INSERT INTO "public"."films_value" VALUES (2, 1, 2, NULL, NULL, NULL, 'USA', NULL);
INSERT INTO "public"."films_value" VALUES (3, 1, 3, NULL, NULL, NULL, 'Robert Zemeckis', NULL);
INSERT INTO "public"."films_value" VALUES (4, 1, 4, NULL, NULL, NULL, 'Eric Roth (screenplay)', NULL);
INSERT INTO "public"."films_value" VALUES (5, 1, 4, NULL, NULL, NULL, 'Winston Groom (novel)', NULL);
INSERT INTO "public"."films_value" VALUES (6, 1, 5, NULL, 330455270, NULL, NULL, NULL);
INSERT INTO "public"."films_value" VALUES (7, 1, 6, NULL, 84460, NULL, NULL, NULL);
INSERT INTO "public"."films_value" VALUES (8, 1, 7, '2020-06-01', NULL, NULL, NULL, NULL);
INSERT INTO "public"."films_value" VALUES (9, 1, 8, '2020-06-01', NULL, NULL, NULL, NULL);
INSERT INTO "public"."films_value" VALUES (10, 1, 10, '2020-06-21', NULL, NULL, NULL, NULL);
INSERT INTO "public"."films_value" VALUES (12, 1, 11, NULL, NULL, NULL, NULL, 142);
INSERT INTO "public"."films_value" VALUES (13, 1, 12, NULL, NULL, 't', NULL, NULL);

-- ----------------------------
-- Function structure for b2s
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."b2s"("bool_value" bool);
CREATE OR REPLACE FUNCTION "public"."b2s"("bool_value" bool)
  RETURNS "pg_catalog"."text" AS $BODY$BEGIN
  IF bool_value THEN 
      RETURN 'да';
  END IF;
  IF NOT bool_value THEN 
      RETURN 'нет';
  END IF;
  RETURN NULL;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- View structure for assembling_service_data
-- ----------------------------
DROP VIEW IF EXISTS "public"."assembling_service_data";
CREATE VIEW "public"."assembling_service_data" AS  SELECT films_entity.film_title,
    films_attribute.attr_title,
    films_value.value_date
   FROM (((films_entity
     LEFT JOIN films_value ON ((films_entity.film_id = films_value.film_id)))
     LEFT JOIN films_attribute ON ((films_value.attr_id = films_attribute.attr_id)))
     LEFT JOIN films_types ON ((films_attribute.type_id = films_types.type_id)))
  WHERE (((films_types.type_title)::text = 'Service date'::text) AND (films_value.value_date = ANY (ARRAY[date(now()), date((now() + '20 days'::interval))])));

-- ----------------------------
-- View structure for marketing_data_assembly
-- ----------------------------
DROP VIEW IF EXISTS "public"."marketing_data_assembly";
CREATE VIEW "public"."marketing_data_assembly" AS  SELECT films_entity.film_title,
    films_types.type_title,
    films_attribute.attr_title,
    COALESCE((films_value.value_date)::text, (films_value.value_numeric)::text, films_value.value_text, (films_value.value_int)::text, b2s(films_value.value_bool)) AS value
   FROM (((films_entity
     JOIN films_value ON ((films_entity.film_id = films_value.film_id)))
     JOIN films_attribute ON ((films_value.attr_id = films_attribute.attr_id)))
     JOIN films_types ON ((films_attribute.type_id = films_types.type_id)));

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."films_attribute_attr_id_seq"
OWNED BY "public"."films_attribute"."attr_id";
SELECT setval('"public"."films_attribute_attr_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."films_entity_film_id_seq"
OWNED BY "public"."films_entity"."film_id";
SELECT setval('"public"."films_entity_film_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."films_types_type_id_seq"
OWNED BY "public"."films_types"."type_id";
SELECT setval('"public"."films_types_type_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."films_value_val_id_seq"
OWNED BY "public"."films_value"."value_id";
SELECT setval('"public"."films_value_val_id_seq"', 2, false);

-- ----------------------------
-- Indexes structure for table films_attribute
-- ----------------------------
CREATE INDEX "films_attribute_attr_title_idx" ON "public"."films_attribute" USING btree (
  "attr_title" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table films_attribute
-- ----------------------------
ALTER TABLE "public"."films_attribute" ADD CONSTRAINT "films_attribute_pkey" PRIMARY KEY ("attr_id");

-- ----------------------------
-- Indexes structure for table films_entity
-- ----------------------------
CREATE INDEX "films_entity_film_title_idx" ON "public"."films_entity" USING btree (
  "film_title" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table films_entity
-- ----------------------------
ALTER TABLE "public"."films_entity" ADD CONSTRAINT "films_entity_pkey" PRIMARY KEY ("film_id");

-- ----------------------------
-- Indexes structure for table films_types
-- ----------------------------
CREATE INDEX "films_types_type_title_idx" ON "public"."films_types" USING btree (
  "type_title" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table films_types
-- ----------------------------
ALTER TABLE "public"."films_types" ADD CONSTRAINT "films_types_pkey" PRIMARY KEY ("type_id");

-- ----------------------------
-- Indexes structure for table films_value
-- ----------------------------
CREATE INDEX "films_value_value_date_idx" ON "public"."films_value" USING btree (
  "value_date" "pg_catalog"."date_ops" ASC NULLS LAST
);
CREATE INDEX "films_value_value_int_idx" ON "public"."films_value" USING btree (
  "value_int" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "films_value_value_numeric_idx" ON "public"."films_value" USING btree (
  "value_numeric" "pg_catalog"."numeric_ops" ASC NULLS LAST
);
CREATE INDEX "films_value_value_text_idx" ON "public"."films_value" USING btree (
  "value_text" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table films_value
-- ----------------------------
ALTER TABLE "public"."films_value" ADD CONSTRAINT "films_value_pkey" PRIMARY KEY ("value_id");

-- ----------------------------
-- Foreign Keys structure for table films_attribute
-- ----------------------------
ALTER TABLE "public"."films_attribute" ADD CONSTRAINT "fk_fimls_tipes" FOREIGN KEY ("type_id") REFERENCES "public"."films_types" ("type_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table films_value
-- ----------------------------
ALTER TABLE "public"."films_value" ADD CONSTRAINT "fk_films_attribute" FOREIGN KEY ("attr_id") REFERENCES "public"."films_attribute" ("attr_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."films_value" ADD CONSTRAINT "fk_films_entity" FOREIGN KEY ("film_id") REFERENCES "public"."films_entity" ("film_id") ON DELETE CASCADE ON UPDATE CASCADE;
