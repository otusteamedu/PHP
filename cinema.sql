-- создание и заполнение таблиц
CREATE TABLE films
(
  Id SERIAL PRIMARY KEY,
  Film_name text not null,
  Actors text,
  Description text
);

INSERT INTO films(id, Film_name, Actors, Description)
SELECT id
    , 'Film_name_' || id
    ,md5(random()::text)
    ,md5(random()::text)

FROM generate_series(1,100) id;

CREATE TABLE sessions
(
  Id SERIAL PRIMARY KEY,
  Time time not null,
  Film_id int REFERENCES Films (id),
  Hall int not null,
  Seat int not null
);

INSERT INTO sessions(sessions_id, time, film_id, hall, seat)
SELECT id
    , NOW() + (random() * (interval '90 days'))
    , floor(random() * 100 + 1)::int
    , floor(random() * 5 + 1)::int
    , floor(random() * 100 + 1)::int
FROM generate_series(1,100) id;

CREATE TABLE tickets
(
  Id SERIAL PRIMARY KEY,
  Price money not null,
  session_id int REFERENCES sessions (id)
);

INSERT INTO tickets(tickets_id, price, session_id)
SELECT id
    , floor(random() * 100 + 1)::float8::numeric::money
    , floor(random() * 100 + 1)::int
FROM generate_series(1,100) id;

CREATE TABLE clients
(
  Id SERIAL PRIMARY KEY,
  Client_name text,
  Client_email text not null unique,
  password text not null,
  ticket_id int REFERENCES tickets (id)
);

 INSERT INTO clients(id, client_name, client_email, password, ticket_id)
 SELECT id
     , md5(random()::text)
     , 'user_' || id || '@' || (
     CASE (RANDOM() * 2)::INT
       WHEN 0 THEN 'gmail'
       WHEN 1 THEN 'hotmail'
       WHEN 2 THEN 'yahoo'
         END
     ) || '.com' AS email
     , md5(random()::text)
     , floor(random() * 100 + 1)::int
 FROM generate_series(1,100) id;


-- запрос на нахождение самого прибыльного фильма
CREATE OR REPLACE VIEW income
 AS SELECT film_id, SUM(price) as sum
 FROM
    tickets t JOIN sessions s ON ( s.sessions_id = t.session_id )
 GROUP BY film_id ORDER BY sum DESC






