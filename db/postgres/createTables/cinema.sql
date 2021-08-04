CREATE TABLE IF NOT exists movie_genre (
  id smallserial not null primary key,
  name VARCHAR(25)
 );
comment on column movie_genre.name is 'наименование жанра';
CREATE UNIQUE INDEX movie_genre_id_UNIQUE ON movie_genre(id);

CREATE TABLE IF NOT EXISTS movie (
  id serial not null primary key,
  name VARCHAR(100) NULL,
  age_limit smallint NULL,
  movie_genre_id smallint NOT null references movie_genre(id)
  );
comment on column movie.name is 'наименование фильма';
comment on column movie.age_limit is 'возрастное ограничение';
CREATE UNIQUE INDEX movie_id_UNIQUE ON movie(id);

CREATE TABLE IF NOT EXISTS room (
  id smallserial not null primary key,
  name VARCHAR(25) NULL
  );
comment on column room.name is 'Наименование зала';
CREATE UNIQUE INDEX room_id_UNIQUE ON room(id);

CREATE TABLE IF NOT EXISTS seat (
  id smallserial not null primary key,
  seat_type VARCHAR(45) NULL,
  cost_factor DECIMAL(2,1) NULL
  );
comment on column seat.seat_type is 'название типа места (кресло простое, кресло кожанное элитное, диван и т.д.)';
comment on column seat.cost_factor is 'коэффициент на стоимость билета';
CREATE UNIQUE INDEX seat_id_UNIQUE ON seat(id);

CREATE TABLE IF NOT EXISTS room_schema (
  id smallserial not null primary key,
  "row" smallint null,
  "number" smallint NULL,
  room_id smallint references room(id),
  seat_id smallint references seat(id)
  );
comment on column room_schema.row is 'ряд';
comment on column room_schema.number is 'место';
CREATE UNIQUE INDEX room_schema_id_UNIQUE ON room_schema(id);

CREATE TABLE IF NOT EXISTS schedule (
  id serial not null primary key,
  session_start timestamp NULL,
  session_end timestamp NULL,
  cost_base DECIMAL(6,2) NULL,
  movie_id INT4 NOT null references movie(id),
  room_id INT2 NOT null references room(id)
  );
comment on column schedule.session_start is 'Начало сеанса';
comment on column schedule.session_end is 'Конец сеанса';
comment on column schedule.cost_base is 'Базовая стоимость билета';
CREATE UNIQUE INDEX schedule_id_UNIQUE ON schedule(id);

CREATE TABLE IF NOT EXISTS ticket (
  id serial not null primary key,
  schedule_id INT4 not null references schedule(id),
  room_schema_id INT2 not null references room_schema(id),
  cost DECIMAL(6,2) null
);
comment on column ticket.cost is 'Стоимость проданного билета';
CREATE UNIQUE INDEX ticket_id_UNIQUE ON ticket(id);
