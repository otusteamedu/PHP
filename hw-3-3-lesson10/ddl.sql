DROP TABLE IF EXISTS "filmAttributeValues";
DROP TABLE IF EXISTS "filmAttributes";
DROP TABLE IF EXISTS "filmAttributeTypes";
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS order_statuses;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS places;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS films;

CREATE TABLE IF NOT EXISTS films (
 id serial PRIMARY KEY,
 title varchar(50) UNIQUE NOT NULL,
 duration_in_minutes smallint NOT NULL,
 comment varchar NULL
);

CREATE TABLE IF NOT EXISTS halls (
 id serial PRIMARY KEY,
 title varchar(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS places (
  id serial PRIMARY KEY,
  number smallint NOT NULL,
  hall_id smallint NOT NULL REFERENCES halls,
  UNIQUE (number, hall_id)
);

CREATE TABLE IF NOT EXISTS events (
  id serial PRIMARY KEY,
  hall_id smallint NOT NULL REFERENCES halls,
  film_id integer NOT NULL REFERENCES films,
  datetime timestamp NOT NULL,
  price numeric(6, 2) NULL CHECK (price >= 0),
  comment varchar NULL,
  created_at timestamp(0),
  updated_at timestamp(0),
  UNIQUE (hall_id, datetime)
);

CREATE TABLE IF NOT EXISTS users (
 id serial PRIMARY KEY,
 username varchar(50) UNIQUE NOT NULL,
 password varchar(50) NOT NULL,
 email varchar(255) UNIQUE NOT NULL,
 created_on timestamp NOT NULL,
 last_login timestamp
);

CREATE TABLE IF NOT EXISTS order_statuses (
  id serial PRIMARY KEY,
  title varchar(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS orders (
  id serial PRIMARY KEY,
  event_id integer NOT NULL REFERENCES events,
  place_id integer NULL REFERENCES places,
  order_status_id integer NOT NULL REFERENCES order_statuses,
  user_id integer NULL REFERENCES users,
  datetime timestamp NOT NULL,
  UNIQUE (event_id, place_id)
);

CREATE TABLE "filmAttributeTypes" (
  id serial,
  title varchar(60) NOT NULL,
  comment text NULL DEFAULT ''::text,
  CONSTRAINT filmattrtypes_pk PRIMARY KEY (id),
  CONSTRAINT filmattrtypes_un UNIQUE (title)
);

CREATE TABLE "filmAttributes" (
  id serial,
  title varchar(60) NOT NULL,
  type_id integer NOT NULL,
  CONSTRAINT filmattributes_pk PRIMARY KEY (id),
  CONSTRAINT filmattributes_type_fk FOREIGN KEY (type_id) REFERENCES "filmAttributeTypes",
  CONSTRAINT filmattributes_un UNIQUE (title)
);

CREATE TABLE "filmAttributeValues" (
  id serial,
  film_id integer NOT NULL,
  attribute_id integer NOT NULL,
  val_bool boolean NULL,
  val_bigint bigint NULL,
  val_double double precision NULL,
  val_timestamp timestamp NULL,
  val_text text NULL,
  comment text NULL DEFAULT ''::text,
  CONSTRAINT filmattrvalues_pk PRIMARY KEY (id),
  CONSTRAINT filmattrvalues_film_fk FOREIGN KEY (film_id) REFERENCES "films",
  CONSTRAINT filmattrvalues_attribute_fk FOREIGN KEY (attribute_id) REFERENCES "filmAttributes"
);
