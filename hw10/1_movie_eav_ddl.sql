CREATE DATABASE movie_eav;

\connect movie_eav; 

CREATE TABLE IF NOT EXISTS movie (
   id SERIAL PRIMARY KEY,
   title VARCHAR (255) NOT NULL
);

CREATE TABLE IF NOT EXISTS attribute_type (
    id SERIAL PRIMARY KEY,
    code VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS movie_attribute (
    id serial PRIMARY KEY,
    code VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    is_required BOOLEAN,
    is_multi BOOLEAN,
    attribute_type_id INT,
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_type (id)    
);

CREATE TABLE IF NOT EXISTS movie_attribute_dict_value (
    id SERIAL PRIMARY KEY,
    code VARCHAR(255) NOT NULL,
    value TEXT NOT NULL,
    movie_attribute_id INT,
    FOREIGN KEY (movie_attribute_id) REFERENCES movie_attribute (id)
);

CREATE TABLE IF NOT EXISTS movie_attribute_value (
    id SERIAL PRIMARY KEY,
    movie_id INT,
    FOREIGN KEY (movie_id) REFERENCES movie (id),
    movie_attribute_id INT,
    FOREIGN KEY (movie_attribute_id) REFERENCES movie_attribute (id),
    value_date TIMESTAMP,
    value_text TEXT,
    value_int INT,
    value_real REAL
);

