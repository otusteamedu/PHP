CREATE OR REPLACE FUNCTION "public"."random_string"("length" int4)
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
  COST 100
;
-- ---------------------------------------------------------ENTITY----------------------------------------------------------------

-- Sequence structure for films_entity_film_id_seq
DROP SEQUENCE IF EXISTS "public"."films_entity_film_id_seq";
CREATE SEQUENCE "public"."films_entity_film_id_seq" 
INCREMENT 1
MINVALUE 1
MAXVALUE 2147483647
START 1
CACHE 1;

-- Table structure for films_entity
 DROP TABLE IF EXISTS "public"."films_entity";
CREATE TABLE "public"."films_entity" (
"film_id" int4 NOT NULL DEFAULT nextval('films_entity_film_id_seq'::regclass),
"film_title" varchar(255) COLLATE "pg_catalog"."default" NOT NULL
);
ALTER TABLE "public"."films_entity" ADD CONSTRAINT "films_entity_pkey" PRIMARY KEY ("film_id");
CREATE INDEX "films_entity_film_title_idx" ON "public"."films_entity" USING btree (
"film_title" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
-- Alter sequences owned by
 ALTER SEQUENCE "public"."films_entity_film_id_seq"
OWNED BY "public"."films_entity"."film_id";

-- Indexes structure for table films_entity
-- CREATE INDEX films_entity_film_id_idx ON public.films_entity (film_id);
-- CREATE INDEX films_entity_film_title_idx ON public.films_entity (film_title);


-- Generate data for testing of productivity table films_entity
-- 1...10000
INSERT INTO public.films_entity (film_id, film_title)
SELECT
gs.id,
random_string((1+random()*10)::integer)
FROM generate_series(1,10000) as gs(id);

-- 10000...10000000
INSERT INTO public.films_entity (film_id, film_title)
SELECT
gs.id,
random_string((1+random()*10)::integer)
FROM generate_series(10001,10000000) as gs(id);

-- ---------------------------------------------------------TYPES----------------------------------------------------------------

-- Sequence structure for films_types_type_id_seq
DROP SEQUENCE IF EXISTS "public"."films_types_type_id_seq";
CREATE SEQUENCE "public"."films_types_type_id_seq" 
INCREMENT 1
MINVALUE 1
MAXVALUE 2147483647
START 1
CACHE 1;

-- Table structure for films_types
DROP TABLE IF EXISTS "public"."films_types";
CREATE TABLE "public"."films_types" (
"type_id" int4 NOT NULL DEFAULT nextval('films_types_type_id_seq'::regclass),
"type_title" varchar(255) COLLATE "pg_catalog"."default"
);
-- SEQUENCE
ALTER SEQUENCE "public"."films_types_type_id_seq"
OWNED BY "public"."films_types"."type_id";
-- Primary Key structure for table films_types
ALTER TABLE "public"."films_types" ADD CONSTRAINT "films_types_pkey" PRIMARY KEY ("type_id");

-- INDEX
-- CREATE INDEX films_types_type_id_idx ON public.films_types (type_id)USING btree;
-- CREATE INDEX films_types_type_title_idx ON public.films_types USING btree (
--"type_title" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
--);
-- Records of films_types
INSERT INTO "public"."films_types" VALUES (1, 'Date');
INSERT INTO "public"."films_types" VALUES (2, 'Text');
INSERT INTO "public"."films_types" VALUES (3, 'Float number');
INSERT INTO "public"."films_types" VALUES (4, 'Integer number');
INSERT INTO "public"."films_types" VALUES (5, 'Boolean');

-- --------------------------------------------------------ATTRIBUTE-----------------------------------------------------------------

-- Sequence structure for films_attribute_attr_id_seq
DROP SEQUENCE IF EXISTS "public"."films_attribute_attr_id_seq";
CREATE SEQUENCE "public"."films_attribute_attr_id_seq" 
INCREMENT 1
MINVALUE 1
MAXVALUE 2147483647
START 1
CACHE 1;

-- Table structure for films_attribute
DROP TABLE IF EXISTS "public"."films_attribute";
CREATE TABLE "public"."films_attribute" (
"attr_id" int4 NOT NULL DEFAULT nextval('films_attribute_attr_id_seq'::regclass),
"type_id" int4 NOT NULL,
"attr_title" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."films_attribute"."type_id" IS 'fk for films_types';
-- Alter sequences owned by
ALTER SEQUENCE "public"."films_attribute_attr_id_seq"
OWNED BY "public"."films_attribute"."attr_id";
-- Primary Key structure for table films_attribute
ALTER TABLE "public"."films_attribute" ADD CONSTRAINT "films_attribute_pkey" PRIMARY KEY ("attr_id");

-- Foreign Keys structure for table films_attribute
ALTER TABLE "public"."films_attribute" ADD CONSTRAINT "fk_fimls_tipes" FOREIGN KEY ("type_id") REFERENCES "public"."films_types" ("type_id") ON DELETE CASCADE ON UPDATE CASCADE;



-- Index fo testing
-- CREATE INDEX films_attribute_attr_id_index ON public.films_attribute (attr_id);
-- CREATE INDEX filmsattrs_type_id_index ON public.films_attribute (type_id);
-- CREATE INDEX films_attribute_attr_title_index ON public.films_attribute (attr_title);


-- Generate data
-- 1...10000
INSERT INTO public.films_attribute (attr_id, type_id, attr_title)
SELECT
gs.id,
((1+random()*4)::integer),
random_string((1+random()*10)::integer)
FROM generate_series(1,10000) as gs(id);

-- 10001...10000000 
INSERT INTO public.films_attribute (attr_id, type_id, attr_title)
SELECT
gs.id,
((1+random()*4)::integer),
random_string((1+random()*10)::integer)
FROM generate_series(10001,10000000) as gs(id);

-- -----------------------------------------------------VALUES--------------------------------------------------------------------

-- Sequence structure for films_value_value_id_seq
DROP SEQUENCE IF EXISTS "public"."films_value_value_id_seq";
CREATE SEQUENCE "public"."films_value_value_id_seq" 
INCREMENT 1
MINVALUE 1
MAXVALUE 2147483647
START 1
CACHE 1;

-- Table structure for films_value
DROP TABLE IF EXISTS "public"."films_value";
CREATE TABLE "public"."films_value" (
  "value_id" int4 NOT NULL DEFAULT nextval('films_value_value_id_seq'::regclass),
  "film_id" int4 NOT NULL,
  "attr_id" int4 NOT NULL,
  "value_date" date,
  "value_float" float8,
  "value_bool" bool,
  "value_text" text COLLATE "pg_catalog"."default",
  "value_int" int4
)
;
COMMENT ON COLUMN "public"."films_value"."film_id" IS 'fk for films_entity';
COMMENT ON COLUMN "public"."films_value"."attr_id" IS 'fk for films_attribute';
-- Alter sequences owned by
ALTER SEQUENCE "public"."films_value_value_id_seq"
OWNED BY "public"."films_value"."value_id";

/*
-- Indexes structure for table films_value
CREATE INDEX "films_value_value_date_idx" ON "public"."films_value" USING btree (
  "value_date" "pg_catalog"."date_ops" ASC NULLS LAST
);
CREATE INDEX "films_value_value_int_idx" ON "public"."films_value" USING btree (
  "value_int" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "films_value_value_float_idx" ON "public"."films_value" USING btree (
  "value_float" "pg_catalog"."float_ops" ASC NULLS LAST
);
CREATE INDEX "films_value_value_text_idx" ON "public"."films_value" USING btree (
  "value_text" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
*/

-- Primary Key structure for table films_value
ALTER TABLE "public"."films_value" ADD CONSTRAINT "films_value_pkey" PRIMARY KEY ("value_id");
-- Foreign Keys structure for table films_value
ALTER TABLE "public"."films_value" ADD CONSTRAINT "fk_films_attribute" FOREIGN KEY ("attr_id") REFERENCES "public"."films_attribute" ("attr_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."films_value" ADD CONSTRAINT "fk_films_entity" FOREIGN KEY ("film_id") REFERENCES "public"."films_entity" ("film_id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Generate data (1...10000)
-- ----------------------------
INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
		((1 + random()*9999)::integer),
		date(now() + (text(round(random()*365)-180)||' day')::interval),
		null, 
		null, 
		null, 
		null
FROM generate_series(1,2000) as gs(id);

INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
		((1 + random()*9999)::integer),
		null,
		(random()*1000),
		null, 
		null, 
		null
FROM generate_series(2001,4000) as gs(id);

INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
		((1 + random()*9999)::integer),
		null, 
		null,
		(random() < 0.5),
		null, 
		null
FROM generate_series(4001,6000) as gs(id);

INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
		((1 + random()*9999)::integer),
		null, 
		null, 
		null,
		random_string((1+random()*10)::integer),
		null
FROM generate_series(6001,8000) as gs(id);

INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999)::integer),
		((1 + random()*9999)::integer),
		null, 
		null, 
		null,  
		null,
		round(random()*1000)
FROM generate_series(8001,10000) as gs(id);

-- ----------------------------
-- Generate data (10001...10000000)
-- ----------------------------
INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999999)::integer),
		((1 + random()*9999999)::integer),
		date(now() + (text(round(random()*365)-180)||' day')::interval), --value_data
		null, 
		null, 
		null, 
		null
FROM generate_series(10001,2000000) as gs(id);

INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999999)::integer),
		((1 + random()*9999999)::integer),
		null,
		(random()*1000), -- value_float
		null, 
		null, 
		null
FROM generate_series(2000001,4000000) as gs(id);

INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999999)::integer),
		((1 + random()*9999999)::integer),
		null, 
		null,
		(random() < 0.5), -- value_bool
		null, 
		null
FROM generate_series(4000001,6000000) as gs(id);

INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999999)::integer),
		((1 + random()*9999999)::integer),
		null, 
		null, 
		null,
		random_string((1+random()*10)::integer), -- value_text
		null
FROM generate_series(6000001,8000000) as gs(id);

INSERT INTO public.films_value (value_id, film_id, attr_id, value_date, value_float, value_bool, value_text, value_int)
SELECT
    gs.id,
    ((1 + random()*9999999)::integer),
		((1 + random()*9999999)::integer),
		null, 
		null, 
		null,  
		null,
		round((random()*1000))  -- value_int
FROM generate_series(8000001,10000000) as gs(id);