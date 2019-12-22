CREATE TYPE timetable AS ENUM ('07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00');

CREATE TABLE IF NOT EXISTS halls
(
    id               SERIAL                       NOT NULL
        CONSTRAINT hall_id PRIMARY KEY,
    title            CHAR(255) DEFAULT ''::BPCHAR NOT NULL,
    lines_count      INTEGER   DEFAULT 20         NOT NULL,
    line_seats_count INTEGER   DEFAULT 40         NOT NULL
);
COMMENT ON TABLE halls IS 'Залы кинотеатра';
COMMENT ON COLUMN halls.id IS 'Индентификатор зала';
COMMENT ON COLUMN halls.title IS 'Название зала';
COMMENT ON COLUMN halls.lines_count IS 'Кол-во рядов кресел в зале';
COMMENT ON COLUMN halls.line_seats_count IS 'Кол-во кресел в каждом ряду';


CREATE TABLE IF NOT EXISTS movies
(
    id       SERIAL                   NOT NULL
        CONSTRAINT movie_id PRIMARY KEY,
    title    VARCHAR(255) DEFAULT ''::CHARACTER VARYING,
    duration INTEGER      DEFAULT 120 NOT NULL
);
COMMENT ON TABLE movies IS 'Фильмы';
COMMENT ON COLUMN movies.id IS 'Идентификатор фильма';
COMMENT ON COLUMN movies.title IS 'Название фильма';
COMMENT ON COLUMN movies.duration IS 'Продолжительность фильма в минутах';

CREATE TABLE IF NOT EXISTS sessions
(
    id       SERIAL    NOT NULL
        CONSTRAINT sessions_id PRIMARY KEY,
    hall_id  INTEGER   NOT NULL
        CONSTRAINT sessions_halls_id REFERENCES halls ON UPDATE CASCADE ON DELETE RESTRICT,
    movie_id INTEGER   NOT NULL
        CONSTRAINT sessions_movies_id_fk REFERENCES movies ON UPDATE CASCADE ON DELETE CASCADE,
    date     DATE      NOT NULL,
    time     TIMETABLE NOT NULL
);
COMMENT ON TABLE sessions IS 'Сеансы показа фильмов';
COMMENT ON COLUMN sessions.id IS 'Идентификатор сеанса';
COMMENT ON COLUMN sessions.hall_id IS 'Идентификатор зала, в котором проводится сеанс показа фильма';
COMMENT ON COLUMN sessions.movie_id IS 'Идентификатор показываемого фильма';
COMMENT ON COLUMN sessions.date IS 'Дата сеанса';
COMMENT ON COLUMN sessions.time IS 'Время начала сеанса';

CREATE TABLE IF NOT EXISTS tickets
(
    id          SERIAL             NOT NULL
        CONSTRAINT ticket_id PRIMARY KEY,
    session_id INTEGER NOT NULL
        CONSTRAINT tickets_sessions_id_fk
            REFERENCES sessions
            ON UPDATE CASCADE ON DELETE RESTRICT,
    seat_number INTEGER            NOT NULL,
    line_number INTEGER            NOT NULL,
    price       MONEY DEFAULT 0.00 NOT NULL
);
COMMENT ON TABLE tickets IS 'Проданные билеты на сеансы';
COMMENT ON COLUMN tickets.session_id IS 'Идентификатор сеанса';
COMMENT ON COLUMN tickets.seat_number IS 'Номер места в ряду';
COMMENT ON COLUMN tickets.line_number IS 'Номер ряда';
COMMENT ON COLUMN tickets.price IS 'Цена билета в копейках';