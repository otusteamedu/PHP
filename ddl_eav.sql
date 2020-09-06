CREATE TABLE public.films (
	film_id int4 NOT NULL,
	"name" varchar(300) NOT NULL,
	description text NULL,
	CONSTRAINT films_pk PRIMARY KEY (film_id),
	CONSTRAINT films_un UNIQUE (film_id)
);

CREATE TABLE public.film_attr (
	attr_id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	name varchar(300) NOT NULL,
	type_id int4 NOT NULL,
	CONSTRAINT film_attr_pk PRIMARY KEY (attr_id),
	CONSTRAINT film_attr_fk FOREIGN KEY (type_id) REFERENCES type_attr(type_id)
);

CREATE TABLE public.type_attr (
	type_id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar(300) NOT NULL,
	val_col varchar(300) NOT NULL,
	CONSTRAINT type_attr_pk PRIMARY KEY (type_id)
);

CREATE TABLE public.value_film_attr (
	value_id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	type_id int4 NOT NULL,
	val_date timestamp NULL,
	val_text text NULL,
	val_money numeric(16,6) NULL,
	film_id int4 NOT NULL,
	CONSTRAINT value_film_attr_pk PRIMARY KEY (value_id),
	CONSTRAINT value_film_attr_un UNIQUE (value_id),
	CONSTRAINT value_film_attr_fk FOREIGN KEY (film_id) REFERENCES films(film_id),
	CONSTRAINT value_film_attr_fk_1 FOREIGN KEY (type_id) REFERENCES type_attr(type_id)
);
