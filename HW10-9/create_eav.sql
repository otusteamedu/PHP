CREATE TABLE attributes
(
    id          BIGSERIAL,
    name        VARCHAR(255) NOT NULL,
    description TEXT         NOT NULL,
    type        INTEGER      NOT NULL,
    film_id     INTEGER      NOT NULL
);


ALTER TABLE attributes
    ADD CONSTRAINT attributes_pkey PRIMARY KEY (id);

CREATE TABLE attribute_types
(
    id          BIGSERIAL,
    name        VARCHAR(255) NOT NULL,
    description TEXT
);


ALTER TABLE attribute_types
    ADD CONSTRAINT attribute_types_pkey PRIMARY KEY (id);

CREATE TABLE attribute_values
(
    id           BIGSERIAL,
    attribute_id INTEGER NOT NULL,
    int_value    INTEGER,
    string_value TEXT,
    date_value   DATE
);


ALTER TABLE attribute_values
    ADD CONSTRAINT attribute_values_pkey PRIMARY KEY (id);

ALTER TABLE attributes
    ADD CONSTRAINT attributes_type_fkey FOREIGN KEY (type) REFERENCES attribute_types (id);
ALTER TABLE attributes
    ADD CONSTRAINT attributes_film_id_fkey FOREIGN KEY (film_id) REFERENCES films (id);
ALTER TABLE attribute_values
    ADD CONSTRAINT attribute_values_attribute_id_fkey FOREIGN KEY (attribute_id) REFERENCES attributes (id);