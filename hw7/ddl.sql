CREATE TABLE public.attribute_type (
    id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
    "name" varchar NOT NULL,
    CONSTRAINT attribute_type_pk PRIMARY KEY (id)
);
CREATE INDEX attribute_type_id_idx ON public.attribute_type USING btree (id);


CREATE TABLE public.movie (
    id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
    "name" varchar NOT NULL,
    CONSTRAINT movie_pk PRIMARY KEY (id)
);
CREATE INDEX movie_id_idx ON public.movie USING btree (id);


CREATE TABLE public."attribute" (
    id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
    type_id int2 NOT NULL,
    "name" varchar NOT NULL,
    CONSTRAINT attribute_pk PRIMARY KEY (id),
    CONSTRAINT attribute_fk FOREIGN KEY (type_id) REFERENCES attribute_type(id)
);
CREATE INDEX attribute_id_idx ON public.attribute USING btree (id);


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
