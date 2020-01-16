/* Фильмы */
INSERT INTO films(name, duration)
VALUES
    ('Сторож', 130*60),
    ('Джокер', 123*60),
    ('Гемини', 120*60),
    ('Дождливый день в Нью-Йорке', 90*60),
    ('Текст', 85*60),
    ('Они', 93*60),
    ('Джуди', 99*60),
    ('Мысленный волк', 102*60),
    ('Холодное сердце 2', 110*60),
    ('Джуманджи: Новый уровень', 145*60),
    ('Тварь', 98*60),
    ('Рождество на двоих', 74*60),
    ('Достать ножи', 123*60),
    ('Сиротский Бруклин', 85*60),
    ('Ржев', 93*60),
    ('Война токов', 99*60),
    ('Ford против Ferrari', 102*60),
    ('Холоп', 112*60),
    ('Камуфляж и шпионаж', 89*60),
    ('Вторжение', 134*60),
    ('Союз Спасения', 119*60),
    ('Полицейский с Рублевки. Новогодний беспредел 2', 94*60);

/* Генерация рандомных 10000 фильмов */
DO $$
DECLARE
    count integer := 10000;
BEGIN
    RAISE NOTICE 'Fill Films';
    FOR num in 1..count LOOP
        INSERT INTO films(name, duration) VALUES (random_string(), (random_numeric(70, 140) * 60));
    END LOOP;
END $$;

/* Залы */
INSERT INTO halls(name, total_seats, total_rows)
VALUES
    ('Обычный зал 1', 260, 10),
    ('Обычный зал 2', 250, 10),
    ('Обычный зал 3', 240, 10),
    ('Обычный зал 4', 230, 10),
    ('Обычный зал 5', 220, 10),
    ('Малый зал 1', 120, 10),
    ('Малый зал 2', 110, 10),
    ('Малый зал 3', 100, 10),
    ('Малый зал 4', 90, 10),
    ('Малый зал 5', 80, 10),
    ('3D зал 1', 70, 6),
    ('3D зал 2', 60, 6),
    ('3D зал 3', 55, 6),
    ('3D зал 4', 50, 6);

/* Заполнение сидений в зале */
DO $$
DECLARE
    hall RECORD;
    lastSeat integer; /* Номер последнего сидения */
    seatsInRow integer; /* Сколько сидений в ряду */
BEGIN
    RAISE NOTICE 'Fill seats';
    FOR hall IN
        SELECT id, total_seats, total_rows FROM halls
    LOOP
        lastSeat := 0;
        seatsInRow := hall.total_seats / hall.total_rows;
        FOR r in 1..hall.total_rows LOOP
            FOR s in 1..seatsInRow LOOP
                lastSeat := lastSeat + 1;
                insert into seats (hall_id, row, number) values (hall.id, r, lastseat);
            END LOOP;
        END LOOP;
    END LOOP;
END $$;

/* Цены */
DO $$
DECLARE
    start integer := 100;
    step integer := 10;
    count integer := 40;
BEGIN
    RAISE NOTICE 'Fill prices';
    FOR num in 1..count LOOP
        INSERT INTO prices(price) VALUES (start + (step * num));
    END LOOP;
END $$;

/* Заполнение сеансов */
DO $$
DECLARE
    hall RECORD;
    price RECORD;
    film RECORD;
    startDay DATE := '2019-01-01'; /* С какой даты */
    days integer := 180; /* На какое кол-во дней сгенерировать сеансы */
    nextTime integer; /* Время следующего сеанса */
    startTime integer := 32400; /* с 9 часов */
    endTime integer := 82800; /* до 23 часа */
    sessionInterval integer := 900; /* Интервал между сеансами в 15 минут */
BEGIN
    RAISE NOTICE 'Fill sessions';
    FOR d in 0..days LOOP
        FOR hall IN
            SELECT id FROM halls
        LOOP
            nextTime := startTime; /* Начинается с утра */
            LOOP
                SELECT * INTO film FROM films ORDER BY RANDOM() LIMIT 1;
                SELECT * INTO price FROM prices ORDER BY RANDOM() LIMIT 1;
                INSERT INTO sessions (hall_id, film_id, start_time, price_id) VALUES (hall.id, film.id, ((startDay + d) + nextTime * '1 second'::interval) , price.id);

                nextTime := nextTime + film.duration + sessionInterval;
                EXIT WHEN nextTime > endTime;
            END LOOP;
        END LOOP;
    END LOOP;
END $$;

/* Атрибуты - типы данных */
INSERT INTO film_attributes_types(type) VALUES ('timestamp'), ('text'), ('boolean'), ('numeric');

/* Атрибуты - типы атрибутов */
INSERT INTO film_attributes(type_id, name) VALUES
    (4, 'Год'),
    (2, 'Страна'),
    (2, 'Слоган'),
    (2, 'Режиссер'),
    (2, 'Сценарий'),
    (2, 'Продюсер'),
    (2, 'Композитор'),
    (2, 'Монтаж'),
    (2, 'Жанр'),
    (4, 'Сборы в США'),
    (4, 'Сборы в мире'),
    (4, 'Сборы в России'),
    (4, 'Зрители'),
    (1, 'Премьера (мир)'),
    (1, 'Премьера (РФ)'),
    (1, 'Цифровой релиз'),
    (4, 'Возраст'),
    (2, 'Рейтинг MPAA'),
    (1, 'Свойство время 1'),
    (1, 'Свойство время 2'),
    (1, 'Свойство время 3'),
    (2, 'Свойство текст 1'),
    (2, 'Свойство текст 2'),
    (2, 'Свойство текст 3'),
    (2, 'Свойство текст 4'),
    (2, 'Свойство текст 5'),
    (2, 'Свойство текст 6'),
    (3, 'Свойство логический тип 1'),
    (3, 'Свойство логический тип 2'),
    (3, 'Свойство логический тип 3'),
    (4, 'Свойство число 1'),
    (4, 'Свойство число 2'),
    (4, 'Свойство число 3');

/* Атрибуты - данные */
DO $$
DECLARE
    film RECORD;
    attribute RECORD;
BEGIN
    RAISE NOTICE 'Fill film_attributes_values';
    FOR film IN
        SELECT id FROM films
    LOOP
        FOR attribute IN
            SELECT film_attributes.id, film_attributes_types.type FROM film_attributes
                JOIN film_attributes_types ON film_attributes.type_id = film_attributes_types.id
        LOOP
            CASE attribute.type
                WHEN 'timestamp' THEN
                    INSERT INTO film_attributes_values (film_id, attribute_id, value_timestamp) VALUES (film.id, attribute.id, random_timestamp());
                WHEN 'text' THEN
                    INSERT INTO film_attributes_values (film_id, attribute_id, value_text) VALUES (film.id, attribute.id, random_string());
                WHEN 'boolean' THEN
                    INSERT INTO film_attributes_values (film_id, attribute_id, value_boolean) VALUES (film.id, attribute.id, random_boolean());
                WHEN 'numeric' THEN
                    INSERT INTO film_attributes_values (film_id, attribute_id, value_numeric) VALUES (film.id, attribute.id, random_numeric());
                ELSE
                    RAISE NOTICE 'Bad attribute! id %, type %', attribute.id, attribute.type;
            END CASE;
        END LOOP;
    END LOOP;
END $$;

/* Купленные билеты */
DO $$
DECLARE
    session RECORD;
    seat RECORD;
BEGIN
    RAISE NOTICE 'Fill tickets';
    FOR session IN
        SELECT id, hall_id, price_id FROM sessions
    LOOP
        FOR seat IN
            SELECT id FROM seats WHERE hall_id = session.hall_id
        LOOP
            IF (random_numeric(0, 9) < 5) THEN /* ~90% заполняемость зала */
                INSERT INTO tickets (session_id, seat_id, price_id) VALUES (session.id, seat.id, session.price_id);
            END IF;
        END LOOP;
    END LOOP;
END $$;