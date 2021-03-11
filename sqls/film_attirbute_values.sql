CREATE TABLE public.film_attribute_values (
      id serial NOT NULL,
      film_attribute_id int4 NULL,
      film_id int4 NULL,
      text_value text NULL,
      boolean_value bool NULL,
      date_value timestamp NULL,
      created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      integer_value int4 NULL,
      float_value float8 NULL,
      CONSTRAINT film_attribute_values_pkey PRIMARY KEY (id),
      CONSTRAINT film_attribute_values_film_attribute_id_fkey FOREIGN KEY (film_attribute_id) REFERENCES film_attributes(id) ON UPDATE CASCADE ON DELETE CASCADE,
      CONSTRAINT film_attribute_values_film_id_fkey FOREIGN KEY (film_id) REFERENCES films(id) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE UNIQUE INDEX film_attribute_values_film_attribute_id_idx ON public.film_attribute_values USING btree (film_attribute_id, film_id);