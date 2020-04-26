
CREATE SEQUENCE cinemas_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "homework"."cinemas" (
    "id" bigint DEFAULT nextval('cinemas_id_seq') NOT NULL,
    "title" character(255) NOT NULL,
    CONSTRAINT "cinemas_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


CREATE SEQUENCE client_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "homework"."client" (
    "id" bigint DEFAULT nextval('client_id_seq') NOT NULL,
    "first_name" character(255) NOT NULL,
    "last_name" character(255) NOT NULL,
    CONSTRAINT "client_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


CREATE SEQUENCE halls_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE SEQUENCE halls_cinema_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "homework"."halls" (
    "id" bigint DEFAULT nextval('halls_id_seq') NOT NULL,
    "title" character(255) NOT NULL,
    "cinema_id" bigint DEFAULT nextval('halls_cinema_id_seq') NOT NULL,
    CONSTRAINT "halls_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "halls_cinema_id_fkey" FOREIGN KEY (cinema_id) REFERENCES cinemas(id) NOT VALID NOT DEFERRABLE
) WITH (oids = false);


CREATE SEQUENCE movies_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "homework"."movies" (
    "id" bigint DEFAULT nextval('movies_id_seq') NOT NULL,
    "title" character(255) NOT NULL,
    "cost" numeric NOT NULL,
    CONSTRAINT "movies_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


CREATE SEQUENCE movies_attributes_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "homework"."movies_attributes" (
    "id" bigint DEFAULT nextval('movies_attributes_id_seq') NOT NULL,
    "title" character varying(255) NOT NULL,
    "type" integer NOT NULL,
    CONSTRAINT "movies_attributes_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "movies_attributes_type_fkey" FOREIGN KEY (type) REFERENCES movies_attributes_types(id) NOT VALID NOT DEFERRABLE
) WITH (oids = false);


CREATE SEQUENCE movies_attributes_types_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "homework"."movies_attributes_types" (
    "id" integer DEFAULT nextval('movies_attributes_types_id_seq') NOT NULL,
    "title" character(255) NOT NULL,
    CONSTRAINT "movies_attributes_types_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


CREATE SEQUENCE movies_attributes_values_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE SEQUENCE movies_attributes_values_movie_attribute_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE SEQUENCE movies_attributes_values_movie_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "homework"."movies_attributes_values" (
    "id" bigint DEFAULT nextval('movies_attributes_values_id_seq') NOT NULL,
    "movie_attribute_id" bigint DEFAULT nextval('movies_attributes_values_movie_attribute_id_seq') NOT NULL,
    "movie_id" bigint DEFAULT nextval('movies_attributes_values_movie_id_seq') NOT NULL,
    "val_bool" smallint,
    "val_text" text,
    "val_integer" integer,
    "val_real" real,
    "val_date" date,
    CONSTRAINT "movies_attributes_values_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "movies_attributes_values_movie_attribute_id_fkey" FOREIGN KEY (movie_attribute_id) REFERENCES movies_attributes(id) NOT DEFERRABLE,
    CONSTRAINT "movies_attributes_values_movie_id_fkey" FOREIGN KEY (movie_id) REFERENCES movies(id) NOT DEFERRABLE
) WITH (oids = false);


CREATE SEQUENCE seats_hall_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "homework"."seats_hall" (
    "id" bigint DEFAULT nextval('seats_hall_id_seq') NOT NULL,
    "hall_id" bigint NOT NULL,
    "series" character(255) NOT NULL,
    "number" bigint NOT NULL,
    CONSTRAINT "seats_hall_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "seats_hall_series_number_hall_id_key" UNIQUE ("series", "number", "hall_id"),
    CONSTRAINT "fx-seats_hall-halls" FOREIGN KEY (hall_id) REFERENCES halls(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
) WITH (oids = false);


CREATE SEQUENCE sessions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "homework"."sessions" (
    "id" bigint DEFAULT nextval('sessions_id_seq') NOT NULL,
    "title" character(255) NOT NULL,
    "movie_id" bigint NOT NULL,
    "hall_id" bigint NOT NULL,
    CONSTRAINT "sessions_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "sessions_hall_id_fkey" FOREIGN KEY (hall_id) REFERENCES halls(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE,
    CONSTRAINT "sessions_movie_id_fkey" FOREIGN KEY (movie_id) REFERENCES movies(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
) WITH (oids = false);


CREATE SEQUENCE tickets_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "homework"."tickets" (
    "id" bigint DEFAULT nextval('tickets_id_seq') NOT NULL,
    "session_id" bigint NOT NULL,
    "client_id" bigint NOT NULL,
    "seat_hall_id" bigint NOT NULL,
    "cost" numeric NOT NULL,
    CONSTRAINT "tickets_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "tickets_client_id_fkey" FOREIGN KEY (client_id) REFERENCES client(id) NOT DEFERRABLE,
    CONSTRAINT "tickets_seat_hall_id_fkey" FOREIGN KEY (seat_hall_id) REFERENCES seats_hall(id) NOT DEFERRABLE,
    CONSTRAINT "tickets_session_id_fkey" FOREIGN KEY (session_id) REFERENCES sessions(id) NOT DEFERRABLE
) WITH (oids = false);


