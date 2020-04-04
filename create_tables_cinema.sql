CREATE TABLE customer
(
id serial PRIMARY KEY,
firstname varchar(128),
secondname varchar(128),
lastname varchar(128),
sex smallint,
birthday date,
created_at timestamp
);

CREATE TABLE movie
(
id serial PRIMARY KEY,
title varchar(512),
duration integer,
status smallint,
created_at timestamp
);

CREATE TABLE hall
(
id serial PRIMARY KEY,
title varchar(512),
description text,
screen_type varchar(512),
comfort_category varchar(512),
status smallint
);

CREATE TABLE place_schema
(
id serial PRIMARY KEY,
id_hall integer REFERENCES hall(id),
line smallint,
place smallint,
type smallint,
condition smallint,
status smallint
);

CREATE TABLE comments
(
id serial PRIMARY KEY,
id_item integer,
type_item varchar(512),
id_commentator integer,
text_comment text,
status smallint,
created_at timestamp
);

CREATE TABLE movie_session
(
id serial PRIMARY KEY,
id_hall integer REFERENCES hall(id),
id_movie integer REFERENCES movie(id),
price numeric(10,2),
datetime_start timestamp,
datetime_end timestamp,
status smallint,
created_at timestamp
);

CREATE TABLE ticket
(
id serial PRIMARY KEY,
id_place integer REFERENCES place_schema(id),
id_session integer REFERENCES movie_session(id),
id_customer integer REFERENCES customer(id),
status smallint,
created_at timestamp
);
