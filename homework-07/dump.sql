-- -------------------------------------------------------------
-- TablePlus 3.7.1(332)
--
-- https://tableplus.com/
--
-- Database: cinema
-- Generation Time: 2020-09-11 19:18:53.8900
-- -------------------------------------------------------------


DROP TABLE IF EXISTS "public"."halls";
-- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS halls_id_seq;

-- Table Definition
CREATE TABLE "public"."halls" (
    "id" int2 NOT NULL DEFAULT nextval('halls_id_seq'::regclass),
    "name" varchar(255) NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."movies";
-- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS movies_id_seq;

-- Table Definition
CREATE TABLE "public"."movies" (
    "id" int8 NOT NULL DEFAULT nextval('movies_id_seq'::regclass),
    "name" varchar(255) NOT NULL,
    "description" text NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."rows";
-- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS rows_id_seq;

-- Table Definition
CREATE TABLE "public"."rows" (
    "id" int2 NOT NULL DEFAULT nextval('rows_id_seq'::regclass),
    "hall_id" int2 NOT NULL,
    "number" int2 NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."seats";
-- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS seats_id_seq;

-- Table Definition
CREATE TABLE "public"."seats" (
    "id" int2 NOT NULL DEFAULT nextval('seats_id_seq'::regclass),
    "row_id" int2 NOT NULL,
    "number" int2 NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."sessions";
-- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS sessions_id_seq;

-- Table Definition
CREATE TABLE "public"."sessions" (
    "id" int4 NOT NULL DEFAULT nextval('sessions_id_seq'::regclass),
    "hall_id" int2 NOT NULL,
    "movie_id" int8 NOT NULL,
    "starts_at" timestamp(0) NOT NULL,
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS "public"."tickets";
-- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS tickets_id_seq;

-- Table Definition
CREATE TABLE "public"."tickets" (
    "id" int8 NOT NULL DEFAULT nextval('tickets_id_seq'::regclass),
    "session_id" int4 NOT NULL,
    "seat_id" int2 NOT NULL,
    "price" numeric(10,2) NOT NULL,
    "created_at" timestamp(0) NOT NULL,
    PRIMARY KEY ("id")
);

ALTER TABLE "public"."rows" ADD FOREIGN KEY ("hall_id") REFERENCES "public"."halls"("id");
ALTER TABLE "public"."seats" ADD FOREIGN KEY ("row_id") REFERENCES "public"."rows"("id");
ALTER TABLE "public"."sessions" ADD FOREIGN KEY ("movie_id") REFERENCES "public"."movies"("id");
ALTER TABLE "public"."sessions" ADD FOREIGN KEY ("hall_id") REFERENCES "public"."halls"("id");
ALTER TABLE "public"."tickets" ADD FOREIGN KEY ("seat_id") REFERENCES "public"."seats"("id");
ALTER TABLE "public"."tickets" ADD FOREIGN KEY ("session_id") REFERENCES "public"."sessions"("id");
