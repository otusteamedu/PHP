DROP TABLE IF EXISTS public.movies, public.movie_attrs_values, public.movie_attrs, public.movie_attrs_types;

CREATE TABLE public.movies (
	id serial NOT NULL,
	"name" varchar NOT NULL,
	CONSTRAINT movies_pkey PRIMARY KEY (id)
);

CREATE TABLE public.movie_attrs_types (
	id serial NOT NULL,
	"name" varchar NOT NULL,
	CONSTRAINT movie_attrs_types_name_key UNIQUE (name),
	CONSTRAINT movie_attrs_types_pkey PRIMARY KEY (id)
);

CREATE TABLE public.movie_attrs (
	id serial NOT NULL,
	"name" varchar NOT NULL,
	type_id int4 NOT NULL,
	CONSTRAINT movie_attrs_name_key UNIQUE (name),
	CONSTRAINT movie_attrs_pkey PRIMARY KEY (id),
	CONSTRAINT movie_attrs_type_id_fkey FOREIGN KEY (type_id) REFERENCES movie_attrs_types(id)
);


CREATE TABLE public.movie_attrs_values (
	id serial NOT NULL,
	movie_id int4 NOT NULL,
	attr_id int4 NOT NULL,
	text_value varchar NULL,
	int_value int4 NULL,
	date_value date NULL,
	time_value time NULL,
	numeric_value numeric(3,1) NULL,
	CONSTRAINT movie_attrs_values_pkey PRIMARY KEY (id),
	CONSTRAINT movie_attrs_values_attr_id_fkey FOREIGN KEY (attr_id) REFERENCES movie_attrs(id),
	CONSTRAINT movie_attrs_values_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES movies(id)
);

CREATE UNIQUE INDEX movie_attrs_values_attr_id_movie_idx ON public.movie_attrs_values (attr_id, movie_id);
CREATE INDEX movie_attrs_type_idx ON public.movie_attrs (type_id);