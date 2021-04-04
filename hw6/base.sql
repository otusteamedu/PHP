-- DROP SCHEMA public;

CREATE SCHEMA public AUTHORIZATION postgres;

-- DROP SEQUENCE public.attribute_types_id_seq;

CREATE SEQUENCE public.attribute_types_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.attribute_types_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.attribute_types_id_seq TO postgres;

-- DROP SEQUENCE public.attribute_value_id_seq;

CREATE SEQUENCE public.attribute_value_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.attribute_value_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.attribute_value_id_seq TO postgres;

-- DROP SEQUENCE public.attributes_id_seq;

CREATE SEQUENCE public.attributes_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.attributes_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.attributes_id_seq TO postgres;

-- DROP SEQUENCE public.films_id_seq;

CREATE SEQUENCE public.films_id_seq
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;

-- Permissions

ALTER SEQUENCE public.films_id_seq OWNER TO postgres;
GRANT ALL ON SEQUENCE public.films_id_seq TO postgres;
-- public.attribute_types definition

-- Drop table

-- DROP TABLE public.attribute_types;

CREATE TABLE public.attribute_types (
	id bigserial NOT NULL,
	"name" varchar NULL,
	other varchar NULL,
	CONSTRAINT attribute_types_pk PRIMARY KEY (id)
);

-- Permissions

ALTER TABLE public.attribute_types OWNER TO postgres;
GRANT ALL ON TABLE public.attribute_types TO postgres;


-- public.films definition

-- Drop table

-- DROP TABLE public.films;

CREATE TABLE public.films (
	id bigserial NOT NULL,
	"name" varchar NULL,
	CONSTRAINT films_pk PRIMARY KEY (id)
);

-- Permissions

ALTER TABLE public.films OWNER TO postgres;
GRANT ALL ON TABLE public.films TO postgres;


-- public."attributes" definition

-- Drop table

-- DROP TABLE public."attributes";

CREATE TABLE public."attributes" (
	id bigserial NOT NULL,
	"name" varchar NULL,
	id_type int4 NULL,
	CONSTRAINT attributes_pk PRIMARY KEY (id),
	CONSTRAINT attributes_fk FOREIGN KEY (id_type) REFERENCES attribute_types(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Permissions

ALTER TABLE public."attributes" OWNER TO postgres;
GRANT ALL ON TABLE public."attributes" TO postgres;


-- public.attribute_value definition

-- Drop table

-- DROP TABLE public.attribute_value;

CREATE TABLE public.attribute_value (
	id bigserial NOT NULL,
	id_film int4 NULL,
	id_attr int4 NULL,
	v_varchar varchar NULL,
	v_date date NULL,
	v_int int4 NULL,
	v_double float4 NULL,
	v_boolean bool NULL,
	CONSTRAINT attribute_value_pk PRIMARY KEY (id),
	CONSTRAINT attribute_value_fk FOREIGN KEY (id_film) REFERENCES films(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT attribute_value_fk_1 FOREIGN KEY (id_attr) REFERENCES attributes(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Permissions

ALTER TABLE public.attribute_value OWNER TO postgres;
GRANT ALL ON TABLE public.attribute_value TO postgres;


-- public.data_for_marketing source

CREATE OR REPLACE VIEW public.data_for_marketing
AS SELECT films.name,
    attribute_types.name AS type,
    attributes.name AS attribute,
    COALESCE(attribute_value.v_varchar, attribute_value.v_date::character varying, attribute_value.v_int::character varying, attribute_value.v_double::character varying, attribute_value.v_boolean::character varying) AS value
   FROM attribute_value
     JOIN films ON films.id = attribute_value.id_film
     JOIN attributes ON attribute_value.id_attr = attributes.id
     JOIN attribute_types ON attributes.id_type = attribute_types.id
  ORDER BY films.name, attributes.name;

-- Permissions

ALTER TABLE public.data_for_marketing OWNER TO postgres;
GRANT ALL ON TABLE public.data_for_marketing TO postgres;


-- public.service_tasks source

CREATE OR REPLACE VIEW public.service_tasks
AS SELECT m.name,
    m.today,
    m.in_twenty_days
   FROM ( SELECT films.name,
                CASE attribute_value.v_date
                    WHEN CURRENT_DATE THEN attributes.name
                    ELSE NULL::character varying
                END AS today,
                CASE attribute_value.v_date
                    WHEN CURRENT_DATE + 20 THEN attributes.name
                    ELSE NULL::character varying
                END AS in_twenty_days
           FROM films
             JOIN attribute_value ON films.id = attribute_value.id_film AND (attribute_value.v_date = CURRENT_DATE OR attribute_value.v_date = (CURRENT_DATE + 20))
             JOIN attributes ON attribute_value.id_attr = attributes.id
          GROUP BY films.name, attribute_value.v_date, attributes.name) m
  ORDER BY m.name, m.today, m.in_twenty_days;

-- Permissions

ALTER TABLE public.service_tasks OWNER TO postgres;
GRANT ALL ON TABLE public.service_tasks TO postgres;




-- Permissions

GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO public;
