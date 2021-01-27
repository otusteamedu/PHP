-- tables

CREATE TABLE halls
(
    id    smallserial NOT NULL,
    title varchar(50) NOT NULL,
    CONSTRAINT halls_pk PRIMARY KEY (id)
);

CREATE TABLE films
(
    id              serial       NOT NULL,
    title           varchar(100) NOT NULL,
    show_start_date timestamp    NOT NULL,
    length          int4         NOT NULL,
    CONSTRAINT films_pk PRIMARY KEY (id),
    CONSTRAINT films_title_and_date_un UNIQUE (title, show_start_date)
);

CREATE TABLE seances
(
    id         serial        NOT NULL,
    hall_id    integer       NOT NULL,
    film_id    integer       NOT NULL,
    date_start timestamp     NOT NULL,
    price      numeric(6, 2) NOT NULL,
    CONSTRAINT seances_pk PRIMARY KEY (id),
    CONSTRAINT seances_halls_fk FOREIGN KEY (hall_id) REFERENCES halls (id),
    CONSTRAINT seances_films_fk FOREIGN KEY (film_id) REFERENCES films (id)
);

CREATE TABLE places
(
    id        smallserial NOT NULL,
    hall_id   int4        NOT NULL,
    hall_row  int4        NOT NULL,
    row_place int4        NOT NULL,
    CONSTRAINT places_pk PRIMARY KEY (id),
    CONSTRAINT places_halls_fk FOREIGN KEY (hall_id) REFERENCES halls (id)
);
CREATE
UNIQUE INDEX places_place_in_hall_idx ON places USING btree (hall_id, hall_row, row_place);

CREATE TABLE tickets
(
    id        serial  NOT NULL,
    seance_id integer NOT NULL,
    place_id  integer NOT NULL,
    CONSTRAINT tickets_pk PRIMARY KEY (id),
    CONSTRAINT tickets_seances_fk FOREIGN KEY (seance_id) REFERENCES seances (id),
    CONSTRAINT tickets_places_fk FOREIGN KEY (place_id) REFERENCES places (id)
);
CREATE
UNIQUE INDEX tickets_seance_place_idx ON tickets USING btree (seance_id, place_id);

CREATE TABLE films_attr_types
(
    id      serial       NOT NULL,
    name    varchar(50)  NOT NULL,
    comment varchar(100) NOT NULL,
    CONSTRAINT filmsattr_type_pk PRIMARY KEY (id),
    CONSTRAINT films_attr_types_un UNIQUE (name)
);

CREATE TABLE films_attr
(
    id      serial      NOT NULL,
    name    varchar(60) NOT NULL,
    type_id int4        NOT NULL,
    CONSTRAINT films_attr_pk PRIMARY KEY (id),
    CONSTRAINT films_attr_un UNIQUE (name),
    CONSTRAINT films_attr_fk FOREIGN KEY (type_id) REFERENCES films_attr_types (id)
);

CREATE TABLE films_attr_values
(
    id        serial  NOT NULL,
    film_id   integer NOT NULL,
    attr_id   integer NOT NULL,
    val_date  date NULL,
    val_bool  bool NULL,
    val_text  text NULL,
    val_int   integer NULL,
    val_float float NULL,
    CONSTRAINT films_attr_values_pk PRIMARY KEY (id),
    CONSTRAINT films_attr_values_un UNIQUE (film_id, attr_id),
    CONSTRAINT films_attr_values_films_fk FOREIGN KEY (film_id) REFERENCES films (id),
    CONSTRAINT films_attr_values_attr_fk FOREIGN KEY (attr_id) REFERENCES films_attr (id)
);

-- functions

CREATE
OR REPLACE FUNCTION random_between(low INT, high INT)
   RETURNS INT AS
$$
BEGIN
RETURN floor(random() * (high - low + 1) + low);
END;
$$
language 'plpgsql' STRICT;

CREATE
OR REPLACE FUNCTION random_string(length integer) RETURNS text AS
$$
declare
chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result
text := '';
  i
integer := 0;
begin
  if
length < 0 then
    raise exception 'Given length cannot be less than 0';
end if;
for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
end loop;
return result;
end;
$$
LANGUAGE plpgsql;

CREATE
OR REPLACE FUNCTION random_date_between(start_date date, end_date date) RETURNS date AS
$BODY$
DECLARE
    interval_days integer;
    random_days   integer;
    random_date   date;
BEGIN
	interval_days := end_date - start_date;
	random_days := random_between(0, interval_days);
	random_date := start_date + random_days;
RETURN random_date;
END;
$BODY$
LANGUAGE plpgsql;