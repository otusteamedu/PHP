-- CREATE

-- Типы атрибутов
CREATE TABLE attributes_types
(
    id smallserial,
    name varchar(50) NOT NULL,

    CONSTRAINT "pk-attributes_types-id"
        PRIMARY KEY (id)
);

CREATE UNIQUE INDEX "idx-attributes_types-name" ON attributes_types (lower(name));

-- Атрибуты фильма
CREATE TABLE movies_attributes
(
    id smallserial,
    name varchar(100) NOT NULL,
    type_id smallint NOT NULL,
    is_system bool DEFAULT FALSE,

    CONSTRAINT "pk-movies_attributes-id"
        PRIMARY KEY (id),

    CONSTRAINT "fk-movies_attributes-type_id-attributes_types-id"
        FOREIGN KEY (type_id) REFERENCES attributes_types (id)
            ON DELETE RESTRICT
            ON UPDATE RESTRICT
);

CREATE INDEX "idx-movies_attributes-type_id" ON movies_attributes (type_id);

-- Значения атрибутов фильма
CREATE TABLE movies_attributes_value
(
    id serial,
    movie_id int NOT NULL,
    attribute_id smallint NOT NULL,
    text_value varchar,
    numeric_value numeric(18, 2),
    date_value timestamp,
    int_value int,

    CONSTRAINT "pk-movies_attributes_value-id"
        PRIMARY KEY (id),

    CONSTRAINT "fk-movies_attributes_value-movie_id-movies-id"
        FOREIGN KEY (movie_id) REFERENCES movies (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,

    CONSTRAINT "fk-movies_attributes_value-attribute_id-movies_attributes-id"
        FOREIGN KEY (attribute_id) REFERENCES movies_attributes (id)
            ON DELETE RESTRICT
            ON UPDATE RESTRICT
);

CREATE INDEX "idx-movies_attributes_value-movie_id" ON movies_attributes_value (movie_id);
CREATE INDEX "idx-movies_attributes_value-attribute_id" ON movies_attributes_value (attribute_id);

-- UNDO

DROP TABLE attributes_types;
DROP TABLE movies_attributes;
DROP TABLE movies_attributes_value;
