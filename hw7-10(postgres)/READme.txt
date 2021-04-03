For optimization I created such indexes (indexes of primary columns are not shown):

CREATE INDEX movie_attribute_types_name_idx ON otus.movie_attribute_types USING btree (name);

CREATE INDEX movie_attribute_values_attribute_id_idx ON otus.movie_attribute_values USING btree (attribute_id);

CREATE INDEX movie_attribute_values_attribute_type_id_idx ON otus.movie_attribute_values USING btree (attribute_type_id);

CREATE INDEX movie_attribute_values_movie_id_idx ON otus.movie_attribute_values USING btree (movie_id);

CREATE INDEX movie_attribute_values_value_date_idx ON otus.movie_attribute_values USING btree (value_date);

CREATE INDEX sessions_movie_id_idx ON otus.sessions USING btree (movie_id);

CREATE INDEX tickets_hall_seat_id_idx ON otus.tickets USING btree (hall_seat_id DESC);

CREATE INDEX tickets_session_id_idx ON otus.tickets USING btree (session_id);

CREATE INDEX tickets_status_idx ON otus.tickets USING btree (status);

Also changed value of random_page_cost from 4.0 to 1.1 as recommended for ssd, shared_buffers set to 1024MB.
