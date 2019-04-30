-- Drop table

-- DROP TABLE test_db.attribute_name;

CREATE TABLE test_db.attribute_name
(
    id    bigserial    NOT NULL,
    title varchar(255) NOT NULL,
    CONSTRAINT idx_16998_primary PRIMARY KEY (id)
);
CREATE UNIQUE INDEX idx_16998_title_unique ON test_db.attribute_name USING btree (title);

-- Drop table

-- DROP TABLE test_db.attribute_type;

CREATE TABLE test_db.attribute_type
(
    id     bigserial    NOT NULL,
    title  varchar(255) NOT NULL,
    code   varchar(45)  NOT NULL,
    "type" varchar(45)  NOT NULL,
    CONSTRAINT idx_17004_primary PRIMARY KEY (id)
);
CREATE UNIQUE INDEX idx_17004_title_unique ON test_db.attribute_type USING btree (title);

-- Drop table

-- DROP TABLE test_db.attribute_value;

CREATE TABLE test_db.attribute_value
(
    id       bigserial   NOT NULL,
    bool_val bool        NULL DEFAULT false,
    int_val  int8        NULL,
    date_val timestamptz NULL,
    text_val text        NULL,
    CONSTRAINT idx_17010_primary PRIMARY KEY (id)
);

-- Drop table

-- DROP TABLE test_db.film_attribute;

CREATE TABLE test_db.film_attribute
(
    id                 bigserial NOT NULL,
    attribute_name_id  int8      NOT NULL,
    film_id            int8      NOT NULL,
    attribute_value_id int8      NOT NULL,
    attribute_type_id  int8      NOT NULL,
    CONSTRAINT idx_17029_primary PRIMARY KEY (id),
    CONSTRAINT atribute_to_value FOREIGN KEY (attribute_value_id) REFERENCES attribute_value (id),
    CONSTRAINT attribute_to_name FOREIGN KEY (attribute_name_id) REFERENCES attribute_name (id),
    CONSTRAINT attribute_to_type FOREIGN KEY (attribute_type_id) REFERENCES attribute_type (id),
    CONSTRAINT films_attributes FOREIGN KEY (film_id) REFERENCES film (id)
);
CREATE INDEX idx_17029_atribute_to_value_idx ON test_db.film_attribute USING btree (attribute_value_id);
CREATE INDEX idx_17029_attribute_to_type_idx ON test_db.film_attribute USING btree (attribute_name_id);
CREATE INDEX idx_17029_attribute_to_type_idx1 ON test_db.film_attribute USING btree (attribute_type_id);
CREATE INDEX idx_17029_films_attributes_idx ON test_db.film_attribute USING btree (film_id);
