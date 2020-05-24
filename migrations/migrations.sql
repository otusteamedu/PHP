CREATE SEQUENCE films_ids;
CREATE TABLE films
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('films_ids'),
    name VARCHAR NOT NULL
);

CREATE SEQUENCE film_attributes_types_ids;
CREATE TABLE film_attributes_types
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('film_attributes_types_ids'),
    name VARCHAR NOT NULL,
    comment VARCHAR NOT NULL
);

CREATE SEQUENCE film_attributes_ids;
CREATE TABLE film_attributes
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('film_attributes_ids'),
    type_id INTEGER NOT NULL,
    name VARCHAR NOT NULL ,
    FOREIGN KEY (type_id) REFERENCES film_attributes_types (id)

);

CREATE SEQUENCE film_attributes_values_ids;
CREATE TABLE film_attributes_values
(
    id INTEGER PRIMARY KEY DEFAULT NEXTVAL('film_attributes_values_ids'),
    attribute_id INTEGER NOT NULL,
    film_id INTEGER NOT NULL,
    FOREIGN KEY (attribute_id) REFERENCES film_attributes (id),
    FOREIGN KEY (film_id) REFERENCES films (id),
    review VARCHAR,
    premium VARCHAR,
    important_dates TIMESTAMP,
    service_dates TIMESTAMP
);
