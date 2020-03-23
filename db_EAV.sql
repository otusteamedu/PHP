-- Фильмы
CREATE TABLE public.tFilms (
	film_id serial NOT NULL CONSTRAINT film_id_pk PRIMARY KEY,
    name text NOT NULL
);
CREATE INDEX tFilms_film_id_index ON public.tFilms (film_id);


-- Типы данных атрибутов
CREATE TABLE public.tTypes (
	type_id serial NOT NULL CONSTRAINT type_id_pk PRIMARY KEY,
    name text NOT NULL,
	comment text
);
CREATE INDEX tTypes_type_id_index ON public.tTypes (type_id);


-- Типы значений атрибутов для фильмов
CREATE TABLE public.tFilmsAttrs (
	attr_id serial NOT NULL CONSTRAINT attr_id_pk PRIMARY KEY,
	type_id int4 NOT NULL CONSTRAINT type_id_tTypes_tFilmsAttrs_fk REFERENCES public.tTypes,
	name text
);
CREATE INDEX tFilmsAttrs_attr_id_index ON public.tFilmsAttrs (attr_id);

-- Значения атрибутов для фильмов
CREATE TABLE public.tFilmsValues (
	value_id serial NOT NULL CONSTRAINT value_id_pk PRIMARY KEY,
	film_id int4 NOT NULL CONSTRAINT film_id_tFilms_tFilmsValues_fk REFERENCES public.tFilms,
	attr_id int4 NOT NULL CONSTRAINT attr_id_tFilmsAttrs_tFilmsValues_fk REFERENCES public.tFilmsAttrs,
	val_date date,
	val_text text,
	val_num decimal
);
CREATE INDEX tFilmsValues_value_id_index ON public.tFilmsValues (value_id);
