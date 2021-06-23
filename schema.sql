CREATE TABLE movies (
    id serial PRIMARY KEY,
    name varchar(128) NOT NULL UNIQUE
);

CREATE TABLE movies_attributes_types (
    id smallserial PRIMARY KEY,
    name varchar(128) NOT NULL UNIQUE
);

CREATE TABLE movies_attributes (
    id smallserial PRIMARY KEY,
    name varchar(128) NOT NULL UNIQUE,
    type smallint NOT NULL REFERENCES movies_attributes_types(id)
);
CREATE INDEX ON movies_attributes(type);

CREATE TABLE movies_attributes_values (
    id serial PRIMARY KEY,
    movie_id int NOT NULL REFERENCES movies(id),
    attribute_id smallint NOT NULL REFERENCES movies_attributes(id),
    date_value date,
    datetime_value timestamp,
    text_value text,
    int_value bigint,
    float_value float,
    boolean_value boolean
);
CREATE INDEX ON movies_attributes_values(movie_id);
CREATE INDEX ON movies_attributes_values(attribute_id);
