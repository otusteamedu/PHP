CREATE TABLE halls (
  id   SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL UNIQUE
);

CREATE TABLE movies (
  id   SERIAL PRIMARY KEY,
  name varchar(140) NOT NULL
);

CREATE TABLE rows (
  id           SERIAL PRIMARY KEY,
  hall_id      smallint NOT NULL REFERENCES halls(id),
  row_num      smallint NOT NULL,
  seats_in_row smallint NOT NULL
);

CREATE TABLE seats (
  id       SERIAL PRIMARY KEY,
  row_id   smallint NOT NULL REFERENCES rows(id),
  seat_num smallint NOT NULL
);

CREATE TABLE sessions (
  id       SERIAL PRIMARY KEY,
  hall_id  smallint NOT NULL REFERENCES halls(id),
  movie_id int NOT NULL REFERENCES movies(id),
  price    int NOT NULL
);

CREATE TABLE tickets (
  id         SERIAL PRIMARY KEY,
  session_id int NOT NULL REFERENCES sessions(id),
  seat_id    smallint NOT NULL,
  price      int NOT NULL
);

CREATE TABLE movie_attr_types (
  id   SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL UNIQUE
);

CREATE TABLE movie_attrs (
  id	  SERIAL PRIMARY KEY,
  type_id int NOT NULL REFERENCES movie_attr_types(id),
  name    varchar(140) NOT NULL
);

CREATE TABLE movie_attr_values (
  id        SERIAL PRIMARY KEY,
  movie_id  int NOT NULL REFERENCES movies(id),
  attr_id   int NOT NULL REFERENCES movie_attrs(id),
  val_text  text,
  val_float float(24),
  val_int   int,
  val_date  date
);