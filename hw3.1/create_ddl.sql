-- create database

CREATE DATABASE cinema;

-- users

-- public.users definition

-- Drop table

-- DROP TABLE public.users;

CREATE TABLE public.users (
  id serial NOT NULL,
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  email varchar(255) NOT NULL,
  created_on timestamp NOT NULL,
  last_login timestamp NULL,
  CONSTRAINT users_email_key UNIQUE (email),
  CONSTRAINT users_pkey PRIMARY KEY (id)
);


-- films

-- public.films definition

-- Drop table

-- DROP TABLE public.films;

CREATE TABLE public.films (
   id int4 NOT NULL,
   name varchar(500) NOT NULL DEFAULT ''::character varying,
   cost_rental float4 NOT NULL DEFAULT 0,
   views_num int4 NOT NULL DEFAULT 0,
   hall_id int4 NOT NULL,
   started_at timestamp NULL,
   finished_at timestamp NULL,
   CONSTRAINT films_pk PRIMARY KEY (id)
);


-- public.films foreign keys

ALTER TABLE public.films ADD CONSTRAINT films_halls_id_fk FOREIGN KEY (hall_id) REFERENCES halls(id);

-- halls

-- public.halls definition

-- Drop table

-- DROP TABLE public.halls;

CREATE TABLE public.halls (
  id int4 NOT NULL,
  capacity int4 NOT NULL,
  CONSTRAINT halls_pk PRIMARY KEY (id)
);

-- films_users

-- public.films_users definition

-- Drop table

-- DROP TABLE public.films_users;

CREATE TABLE public.films_users (
    film_id int4 NOT NULL,
    user_id int4 NOT NULL,
    CONSTRAINT films_users_pk PRIMARY KEY (film_id, user_id)
);


-- public.films_users foreign keys

ALTER TABLE public.films_users ADD CONSTRAINT films_users_films_id_fk FOREIGN KEY (film_id) REFERENCES films(id);
ALTER TABLE public.films_users ADD CONSTRAINT films_users_users_id_fk FOREIGN KEY (user_id) REFERENCES users(id);