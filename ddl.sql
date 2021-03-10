CREATE SCHEMA public AUTHORIZATION postgres;

CREATE TABLE public.attribute_type (
	id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar NOT NULL,
	CONSTRAINT attribute_type_pk PRIMARY KEY (id)
);
CREATE INDEX attribute_type_id_idx ON public.attribute_type USING btree (id);


-- public.movie definition

-- Drop table

-- DROP TABLE public.movie;

CREATE TABLE public.movie (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar NOT NULL,
	CONSTRAINT movie_pk PRIMARY KEY (id)
);
CREATE INDEX movie_id_idx ON public.movie USING btree (id);


-- public."attribute" definition

-- Drop table

-- DROP TABLE public."attribute";

CREATE TABLE public."attribute" (
	id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
	type_id int2 NOT NULL,
	"name" varchar NOT NULL,
	CONSTRAINT attribute_pk PRIMARY KEY (id),
	CONSTRAINT attribute_fk FOREIGN KEY (type_id) REFERENCES attribute_type(id)
);
CREATE INDEX attribute_id_idx ON public.attribute USING btree (id);


-- public.movie_attribute_value definition

-- Drop table

-- DROP TABLE public.movie_attribute_value;

CREATE TABLE public.movie_attribute_value (
	id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
	movie_id int4 NOT NULL,
	date_value date NULL,
	text_value text NULL,
	bool_value bool NULL,
	int_value int4 NULL,
	float_value float4 NULL,
	attribute_id int2 NOT NULL,
	CONSTRAINT movie_attribute_value_pk PRIMARY KEY (id),
	CONSTRAINT movie_attribute_value_fk FOREIGN KEY (movie_id) REFERENCES movie(id),
	CONSTRAINT movie_attribute_value_fk_1 FOREIGN KEY (attribute_id) REFERENCES attribute(id)
);
CREATE INDEX movie_attribute_value_movie_id_idx ON public.movie_attribute_value USING btree (movie_id, attribute_id);


INSERT INTO public.movie ("name")
	VALUES ('Зеленая книга');

INSERT INTO public.attribute_type ("name")
	VALUES ('Текст');
INSERT INTO public.attribute_type ("name")
        VALUES ('Дата');

INSERT INTO public."attribute" (type_id,"name")
	VALUES (2,'Дата премьеры в России');
INSERT INTO public."attribute" (type_id,"name")
	VALUES (2,'Начало продажи билетов');
INSERT INTO public."attribute" (type_id,"name")
	VALUES (1,'Премия');

-- Auto-generated SQL script #202103081245
INSERT INTO public.movie_attribute_value (movie_id,text_value,attribute_id)
	VALUES (1,'Оскар',3);
-- Auto-generated SQL script #202103081245
INSERT INTO public.movie_attribute_value (movie_id,text_value,attribute_id)
	VALUES (1,'Золотой глобус',3);
-- Auto-generated SQL script #202103081246
INSERT INTO public.movie_attribute_value (movie_id,date_value,attribute_id)
	VALUES (1,'2019-01-26',1);
INSERT INTO public.movie_attribute_value (movie_id,date_value,attribute_id)
        VALUES (1,'2019-01-20',2);






-- public.eav_01 source

CREATE OR REPLACE VIEW public.eav_01
AS SELECT movie.name AS movie_name,
    attribute_type.name AS attribute_type,
    attribute.name AS attribute_name,
    COALESCE(movie_attribute_value.date_value::text, movie_attribute_value.num_value::text, movie_attribute_value.text_value::text) AS attribute_value
   FROM movie_attribute_value
     LEFT JOIN movie ON movie.id = movie_attribute_value.movie_id
     LEFT JOIN attribute ON attribute.id = movie_attribute_value.attribute_id
     LEFT JOIN attribute_type ON attribute_type.id = attribute.type_id;



create view eav_02 as
select r1.movie_name, r2.future, r3.current
from (select movie.name as movie_name, movie_id, attribute.name 
from movie_attribute_value
left join movie on movie.id = movie_attribute_value.movie_id 
left join attribute on attribute.id = movie_attribute_value.attribute_id 
left join attribute_type on attribute_type.id = attribute.type_id
where attribute.type_id = 2 and date_value is not null) as r1
left join (select movie_id, coalesce(date_value::text, 'empty') as future from movie_attribute_value where date_value > current_date) as r2
on r1.movie_id = r2.movie_id
left join (select movie_id, coalesce(date_value::text, 'empty') as current from movie_attribute_value where date_value = current_date) as r3
on r1.movie_id = r3.movie_id
