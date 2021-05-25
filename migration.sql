CREATE TABLE rooms
(
  id   SERIAL       NOT NULL,
  name VARCHAR(250) NOT NULL,
  CONSTRAINT rooms_pk PRIMARY KEY (id)
);

CREATE TABLE places
(
  id      SERIAL  NOT NULL,
  room_id INTEGER NOT NULL,
  row     INTEGER NOT NULL,
  place   INTEGER NOT NULL,
  CONSTRAINT places_pk PRIMARY KEY (id),
  CONSTRAINT places_room_fk FOREIGN KEY (room_id) REFERENCES rooms (id)
);

CREATE TABLE movies
(
  id   SERIAL       NOT NULL,
  name VARCHAR(250) NOT NULL,
  CONSTRAINT movies_pk PRIMARY KEY (id)
);

CREATE TABLE seances
(
  id       SERIAL  NOT NULL,
  room_id  INTEGER NOT NULL,
  movie_id INTEGER NOT NULL,
  price    INTEGER NOT NULL,
  CONSTRAINT seances_pk PRIMARY KEY (id),
  CONSTRAINT seances_rooms_fk FOREIGN KEY (room_id) REFERENCES rooms (id),
  CONSTRAINT seances_movies_fk FOREIGN KEY (movie_id) REFERENCES movies (id)
);

CREATE TABLE discounts
(
  id    SERIAL  NOT NULL,
  value INTEGER NOT NULL,
  CONSTRAINT discounts_pk PRIMARY KEY (id)
);

CREATE TABLE tickets
(
  id          SERIAL  NOT NULL,
  seance_id   INTEGER NOT NULL,
  place_id    INTEGER NOT NULL,
  price       INTEGER NOT NULL,
  discount_id INTEGER NOT NULL,
  CONSTRAINT tickets_pk PRIMARY KEY (id),
  CONSTRAINT tickets_seances_fk FOREIGN KEY (seance_id) REFERENCES seances (id),
  CONSTRAINT tickets_places_fk FOREIGN KEY (place_id) REFERENCES places (id),
  CONSTRAINT tickets_discounts_fk FOREIGN KEY (discount_id) REFERENCES discounts (id)
);

CREATE TABLE movies_attribute_types
(
  id    SERIAL       NOT NULL,
  name  VARCHAR(250) NOT NULL,
  value VARCHAR(250) NOT NULL,
  CONSTRAINT movies_attribute_types_pk PRIMARY KEY (id),
  CONSTRAINT movies_attribute_types_un UNIQUE (name)
);

CREATE TABLE movie_attributes
(
  id      SERIAL       NOT NULL,
  name    VARCHAR(250) NOT NULL,
  type_id INTEGER      NOT NULL,
  CONSTRAINT movie_attributes_pk PRIMARY KEY (id),
  CONSTRAINT movie_attributes_un UNIQUE (name),
  CONSTRAINT movie_attributes_fk FOREIGN KEY (type_id) REFERENCES movies_attribute_types (id)
);

CREATE TABLE movie_attribute_values
(
  id            SERIAL  NOT NULL,
  movie_id      INTEGER NOT NULL,
  attr_id       INTEGER NOT NULL,
  value_integer INTEGER NULL,
  value_float   FLOAT   NULL,
  value_text    TEXT    NULL,
  value_bool    BOOL    NULL,
  value_date    DATE    NULL,
  CONSTRAINT movie_attribute_values_pk PRIMARY KEY (id),
  CONSTRAINT movie_attribute_values_un UNIQUE (movie_id, attr_id),
  CONSTRAINT movie_attribute_values_movies_fk FOREIGN KEY (movie_id) REFERENCES movies (id),
  CONSTRAINT movie_attribute_values_attributes_fk FOREIGN KEY (attr_id) REFERENCES movie_attributes (id)
);
