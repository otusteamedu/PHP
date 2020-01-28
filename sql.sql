-- Adminer 4.7.5 PostgreSQL dump

\connect "hw7";

DROP TABLE IF EXISTS "films";
DROP SEQUENCE IF EXISTS films_id_seq;
CREATE SEQUENCE films_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."films" (
                                 "id" integer DEFAULT nextval('films_id_seq') NOT NULL,
                                 "name" character varying NOT NULL,
                                 "decription" text,
                                 CONSTRAINT "films_pk" PRIMARY KEY ("id")
) WITH (oids = false);

COMMENT ON TABLE "films"."films" IS 'hw8 table films';

COMMENT ON COLUMN "films"."films"."decription" IS 'description films';


DROP TABLE IF EXISTS "hall";
DROP SEQUENCE IF EXISTS hall_id_seq;
CREATE SEQUENCE hall_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."hall" (
                                "id" integer DEFAULT nextval('hall_id_seq') NOT NULL,
                                "name" character varying,
                                "total_places" integer,
                                "free_places" integer,
                                CONSTRAINT "hall_id_uindex" UNIQUE ("id"),
                                CONSTRAINT "hall_pk" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "order";
DROP SEQUENCE IF EXISTS order_id_seq;
CREATE SEQUENCE order_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."order" (
                                 "id" integer DEFAULT nextval('order_id_seq') NOT NULL,
                                 "price" double precision,
                                 "date_pay" timestamp,
                                 CONSTRAINT "order_id_uindex" UNIQUE ("id"),
                                 CONSTRAINT "order_pk" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "places";
DROP SEQUENCE IF EXISTS places_id_seq;
CREATE SEQUENCE places_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."places" (
                                  "id" integer DEFAULT nextval('places_id_seq') NOT NULL,
                                  "hall_id" integer,
                                  "number" integer,
                                  "price" double precision,
                                  CONSTRAINT "places_id_uindex" UNIQUE ("id"),
                                  CONSTRAINT "places_pk" PRIMARY KEY ("id"),
                                  CONSTRAINT "places_hall_id_fkey" FOREIGN KEY (hall_id) REFERENCES hall(id) NOT DEFERRABLE
) WITH (oids = false);


DROP TABLE IF EXISTS "sessions";
DROP SEQUENCE IF EXISTS sessions_id_seq;
CREATE SEQUENCE sessions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."sessions" (
                                    "id" integer DEFAULT nextval('sessions_id_seq') NOT NULL,
                                    "film_id" integer NOT NULL,
                                    "holl_id" integer,
                                    "date_delivery" timestamp,
                                    CONSTRAINT "sessions_id_uindex" UNIQUE ("id"),
                                    CONSTRAINT "sessions_pk" PRIMARY KEY ("id"),
                                    CONSTRAINT "sessions_film_id_fkey" FOREIGN KEY (film_id) REFERENCES films(id) NOT DEFERRABLE
) WITH (oids = false);


DROP TABLE IF EXISTS "ticket";
DROP SEQUENCE IF EXISTS ticket_id_seq;
CREATE SEQUENCE ticket_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "films"."ticket" (
                                  "id" integer DEFAULT nextval('ticket_id_seq') NOT NULL,
                                  "film_id" integer NOT NULL,
                                  "price" double precision DEFAULT '0' NOT NULL,
                                  "hall_id" integer NOT NULL,
                                  "sessions_id" integer NOT NULL,
                                  "places_id" integer NOT NULL,
                                  CONSTRAINT "ticket_id_uindex" UNIQUE ("id"),
                                  CONSTRAINT "ticket_pk" PRIMARY KEY ("id"),
                                  CONSTRAINT "ticket_film_id_fkey" FOREIGN KEY (film_id) REFERENCES films(id) NOT DEFERRABLE,
                                  CONSTRAINT "ticket_hall_id_fkey" FOREIGN KEY (hall_id) REFERENCES hall(id) NOT DEFERRABLE,
                                  CONSTRAINT "ticket_places_id_fkey" FOREIGN KEY (places_id) REFERENCES places(id) NOT DEFERRABLE,
                                  CONSTRAINT "ticket_sessions_id_fkey" FOREIGN KEY (sessions_id) REFERENCES sessions(id) NOT DEFERRABLE
) WITH (oids = false);


-- 2020-01-28 21:41:47.761523+00


ALTER TABLE hw7.films.ticket
    ADD FOREIGN KEY ("film_id") REFERENCES hw7.films.films ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE hw7.films.ticket
    ADD FOREIGN KEY ("hall_id") REFERENCES hw7.films.hall ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE hw7.films.ticket
    ADD FOREIGN KEY ("sessions_id") REFERENCES hw7.films.sessions ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE hw7.films.ticket
    ADD FOREIGN KEY ("places_id") REFERENCES hw7.films.places ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE hw7.films.sessions
    ADD FOREIGN KEY ("film_id") REFERENCES hw7.films.films ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE hw7.films.places
    ADD FOREIGN KEY ("hall_id") REFERENCES hw7.films.hall ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;