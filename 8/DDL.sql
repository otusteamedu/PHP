CREATE TABLE IF NOT EXISTS movie_attribute_type (
    id serial PRIMARY KEY,
    name varchar(255) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS movie_attribute (
    id serial PRIMARY KEY,
    name varchar(255) DEFAULT NULL,
    type_id int,
    CONSTRAINT FK_attribute_type FOREIGN KEY (type_id) REFERENCES movie_attribute_type(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS movie_fields (
    id serial PRIMARY KEY,
    name varchar(255) DEFAULT NULL,
    attribute_id int,
    CONSTRAINT FK_attribute_filed FOREIGN KEY (attribute_id) REFERENCES movie_attribute(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS movie_attribute_value (
    id serial PRIMARY KEY,
    movie_id int,
    field_id int,
    value_int int,
    value_float float,
    value_text varchar,
    value_date date,
    value_boolean bool,
    value_money money,
    CONSTRAINT FK_value_movie FOREIGN KEY (movie_id) REFERENCES movies(id),
    CONSTRAINT FK_value_field FOREIGN KEY (field_id) REFERENCES movie_fields(id)
);

CREATE VIEW test_view AS
SELECT m.name as movie_name, ma.name as attribute_name, mf.name as filed_name, mav.value_text, mav.value_date, mav.value_boolean FROM movies m
JOIN movie_attribute_value mav on m.id = mav.movie_id
JOIN movie_fields mf on mf.id = mav.field_id
JOIN movie_attribute ma on mf.attribute_id = ma.id
JOIN movie_attribute_type mat on ma.type_id = mat.id;
