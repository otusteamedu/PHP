-- Adminer 4.7.5 PostgreSQL dump

DROP TABLE IF EXISTS "basket";
DROP SEQUENCE IF EXISTS basket_id_seq;
CREATE SEQUENCE basket_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."basket"
(
    "id"          integer DEFAULT nextval(''basket_id_seq '') NOT NULL,
    "film_id"     integer,
    "hall_id"     integer,
    "sessions_id" integer,
    "plase_id"    integer,
    "price"       double precision,
    "order_id"    integer,
    "byer_id"     integer,
    "user_id"     integer,
    CONSTRAINT "basket_id_uindex" UNIQUE ("id"),
    CONSTRAINT "basket_pk" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "films";
DROP SEQUENCE IF EXISTS films_id_seq;
CREATE SEQUENCE films_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."films"
(
    "id"         integer DEFAULT nextval(''films_id_seq '') NOT NULL,
    "name"       character varying                          NOT NULL,
    "decription" text,
    CONSTRAINT "films_pk" PRIMARY KEY ("id")
) WITH (oids = false);

COMMENT ON TABLE "films"."films" IS ''hw8 table films'';

COMMENT ON COLUMN "films"."films"."decription" IS ''description films'';


DROP TABLE IF EXISTS "hall";
DROP SEQUENCE IF EXISTS hall_id_seq;
CREATE SEQUENCE hall_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."hall"
(
    "id"           integer DEFAULT nextval(''hall_id_seq '') NOT NULL,
    "name"         character varying,
    "total_places" integer,
    "free_places"  integer,
    CONSTRAINT "hall_id_uindex" UNIQUE ("id"),
    CONSTRAINT "hall_pk" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "order";
DROP SEQUENCE IF EXISTS order_id_seq;
CREATE SEQUENCE order_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."order"
(
    "id"       integer DEFAULT nextval(''order_id_seq '') NOT NULL,
    "price"    double precision,
    "date_pay" timestamp,
    "user_id"  integer,
    CONSTRAINT "order_id_uindex" UNIQUE ("id"),
    CONSTRAINT "order_pk" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "places";
DROP SEQUENCE IF EXISTS places_id_seq;
CREATE SEQUENCE places_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."places"
(
    "id"      integer DEFAULT nextval(''places_id_seq '') NOT NULL,
    "hall_id" integer,
    "number"  integer,
    "price"   double precision,
    CONSTRAINT "places_id_uindex" UNIQUE ("id"),
    CONSTRAINT "places_pk" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "sessions";
DROP SEQUENCE IF EXISTS sessions_id_seq;
CREATE SEQUENCE sessions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."sessions"
(
    "id"            integer DEFAULT nextval(''sessions_id_seq '') NOT NULL,
    "film_id"       integer                                       NOT NULL,
    "holl_id"       integer,
    "date_delivery" timestamp,
    CONSTRAINT "sessions_id_uindex" UNIQUE ("id"),
    CONSTRAINT "sessions_pk" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "ticket";
DROP SEQUENCE IF EXISTS ticket_id_seq;
CREATE SEQUENCE ticket_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."ticket"
(
    "id"          integer DEFAULT nextval(''ticket_id_seq '') NOT NULL,
    "film_id"     integer                                     NOT NULL,
    "hall_id"     integer                                     NOT NULL,
    "sessions_id" integer                                     NOT NULL,
    "places_id"   integer                                     NOT NULL,
    "basket_id"   integer,
    "order_id"    integer,
    "user_id"     integer,
    CONSTRAINT "ticket_id_uindex" UNIQUE ("id"),
    CONSTRAINT "ticket_pk" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "user";
DROP SEQUENCE IF EXISTS user_id_seq;
CREATE SEQUENCE user_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."user"
(
    "id"        integer DEFAULT nextval(''user_id_seq '') NOT NULL,
    "name"      character varying,
    "last_name" character varying,
    "email"     character varying,
    "password"  integer,
    "phone"     character varying,
    CONSTRAINT "user_id_uindex" UNIQUE ("id"),
    CONSTRAINT "user_pk" PRIMARY KEY ("id")
) WITH (oids = false);


-- 2020-01-29 21:18:11.187809+00