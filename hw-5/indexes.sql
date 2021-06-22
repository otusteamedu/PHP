CREATE INDEX movie_attr_values_movie_id_idx ON movie_attr_values (movie_id);

CREATE INDEX movie_attr_values_attr_id_idx ON movie_attr_values (attr_id);

CREATE INDEX movie_attrs_type_id_idx ON movie_attrs (type_id);

CREATE INDEX movie_attrs_name_idx ON movie_attrs (name);

CREATE INDEX movie_attr_types_name_idx ON movie_attr_types (name);

CREATE INDEX seats_row_id_idx ON seats (row_id);

CREATE INDEX rows_hall_id_idx ON rows (hall_id);

CREATE INDEX movies_name_idx ON movies (name);