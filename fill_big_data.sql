TRUNCATE TABLE
    tickets,
    sessions,
    seats,
    halls,
    films_attrs_values,
    films_attrs,
    film_attrs_types,
    films;


INSERT INTO halls(name)
SELECT
    random_string()
FROM generate_series(1,10);


INSERT INTO films (name)
SELECT
    random_string()
FROM generate_series(1,100);


INSERT INTO seats (hall_id, row, number)
SELECT
    halls.id,
    random_between(1, 20),
    random_between (1, 20)
FROM generate_series(1,100)
         CROSS  JOIN halls;


INSERT INTO sessions (film_id, hall_id, time)
SELECT
    films.id,
    halls.id,
    NOW() + (random() * (NOW()+'90 days' - NOW()))
FROM generate_series(1,10)
         CROSS  JOIN films
         CROSS  JOIN halls;

/*create 10 000 000 tickets*/
INSERT INTO tickets (session_id, seat_id, price)
SELECT
    sessions.id,
    seats.id,
    random_between(100, 500)
FROM generate_series(1,1)
         CROSS  JOIN sessions
         CROSS  JOIN seats;