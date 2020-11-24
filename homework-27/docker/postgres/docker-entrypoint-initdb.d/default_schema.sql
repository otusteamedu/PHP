-- -------------------------------------------------------------
-- TablePlus 3.11.0(352)
--
-- https://tableplus.com/
--
-- Database: default
-- Generation Time: 2020-11-25 12:49:59.7910
-- -------------------------------------------------------------


-- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS failed_jobs_id_seq;

-- Table Definition
CREATE TABLE "public"."failed_jobs" (
    "id" int4 NOT NULL DEFAULT nextval('failed_jobs_id_seq'::regclass),
    "connection" text NOT NULL,
    "queue" text NOT NULL,
    "payload" text NOT NULL,
    "exception" text NOT NULL,
    "failed_at" timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY ("id")
);

-- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

-- Table Definition
CREATE TABLE "public"."messages" (
    "uuid" uuid NOT NULL,
    "data" jsonb NOT NULL,
    "status" varchar(255) NOT NULL DEFAULT 'waiting'::character varying CHECK ((status)::text = ANY ((ARRAY['waiting'::character varying, 'processing'::character varying, 'processed'::character varying])::text[])),
    "created_at" timestamp,
    "updated_at" timestamp,
    PRIMARY KEY ("uuid")
);

-- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

-- Sequence and defined type
CREATE SEQUENCE IF NOT EXISTS migrations_id_seq;

-- Table Definition
CREATE TABLE "public"."migrations" (
    "id" int4 NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
    "migration" varchar(255) NOT NULL,
    "batch" int4 NOT NULL,
    PRIMARY KEY ("id")
);

