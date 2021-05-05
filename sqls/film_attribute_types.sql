CREATE TABLE public.film_attribute_types (
     id serial NOT NULL,
     "name" varchar(100) NOT NULL,
     description varchar(255) NULL,
     created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     CONSTRAINT film_attribute_types_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX film_attribute_types_name_idx ON public.film_attribute_types USING btree (name);