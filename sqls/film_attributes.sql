CREATE TABLE public.film_attributes (
    id serial NOT NULL,
    "name" varchar(100) NOT NULL,
    description varchar(255) NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "type" varchar(20) NOT NULL,
    film_attribute_type_id int2 NULL,
    CONSTRAINT film_attributes_pkey PRIMARY KEY (id),
    CONSTRAINT film_attributes_fk FOREIGN KEY (film_attribute_type_id) REFERENCES film_attribute_types(id)
);
CREATE UNIQUE INDEX film_attributes_name_idx ON public.film_attributes USING btree (name, type);