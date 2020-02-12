INSERT INTO halls (name) values ('Большой зал'), ('Средний зал'), ('Малый зал');

INSERT INTO movies (id, name, description) VALUES
    (1, 'Старикам тут не место', 'Обычный работяга обнаруживает в пустыне гору трупов, грузовик, набитый героином, и соблазнительную сумму в два миллиона долларов наличными. Он решает взять деньги себе, и результатом становится волна насилия, которую не может остановить вся полиция Западного Техаса.'),
    (2, 'Комната желаний', 'Влюбленная пара Кэйт и Мэтт переезжает в уединенный особняк. Занимаясь ремонтом старого дома, они обнаруживают замурованную комнату, которая, как выясняется, исполняет любые желания. Миллионы долларов, подлинник Ван Гога, самые роскошные наряды и украшения — что бы супруги ни захотели, моментально материализуется.'),
    (3, 'Железная хватка', 'В этом фильме рассказывается история 14-летней девочки, стареющего судебного пристава Рустера Когберна и ещё одного законника. Вместе они идут по следам убийцы отца девочки, которые ведут во враждебную индейскую территорию.');

DO $$
DECLARE count INT;
BEGIN
    FOR count in 1..50
        LOOP
            IF (count < 30)
            THEN
                INSERT INTO places (hall_id, place_tariff) values (2, 200.00);
                INSERT INTO places(hall_id, place_tariff) values (1, 200.00);
            END IF;
            IF (count < 10)
            THEN
                INSERT INTO places(hall_id, place_tariff) values (3, 100.00);
                INSERT INTO places(hall_id, place_tariff) values (1, 100.00);
            END IF;
            INSERT INTO places(hall_id, place_tariff) values (1, 400.00);
        END LOOP;
END$$;

INSERT INTO sessions (session_tariff, "date", hall_id, movie_id) VALUES
    (100.00, '2020-02-11 03:00:00', 1, 1),
    (150.00, '2020-02-12 02:00:00', 2, 2),
    (200.00, '2020-02-13 01:00:00', 3, 3);

DO $$
DECLARE sessions_places record;
BEGIN
    FOR sessions_places in
        SELECT p.id place_id, p.place_tariff, s.id session_id, s.session_tariff FROM places p
            JOIN sessions s ON s.hall_id = p.hall_id
    LOOP
        INSERT INTO tickets (place_id, session_id, price) VALUES
        (sessions_places.place_id, sessions_places.session_id, sessions_places.session_tariff + sessions_places.place_tariff);
    END LOOP;
END$$;


INSERT INTO movies_attr_type (id, name) VALUES
    (1, 'Рецензии'),
    (2, 'Премия'),
    (3, 'Рейтинги'),
    (4, 'Важные даты'),
    (5, 'Служебные даты'),
    (6, 'Возрастные ограничения');

INSERT INTO movies_attr (id, type_id, name)
VALUES
    (1, 1, 'Клуб любителей кино'),
    (2, 1, 'Анонимные рецензии'),
    (3, 2, 'Оскар'),
    (4, 2, 'Золотая малина'),
    (5, 3, 'Кинопоиск'),
    (6, 3, 'imdb'),
    (7, 4, 'Мировая премьера'),
    (8, 4, 'Цифровой релиз'),
    (9, 5, 'Печать постеров'),
    (10, 5, 'Заказ тематических стаканчиков для попкорна'),
    (11, 5, 'Запуск рекламы'),
    (12, 5, 'Начало продажи билетов'),
    (13, 6, 'В сопровождении взрослых'),
    (14, 6, 'Самостоятельный просмотр');

DO $$
DECLARE movies_record record;
BEGIN
    FOR movies_record in
        SELECT m.id movie_id, ma.id movie_attr_id , ma.type_id movie_attr_type_id FROM movies m, movies_attr ma
    LOOP
        if (movies_record.movie_attr_id = 1 or movies_record.movie_attr_id = 2)
        then
            if (movies_record.movie_id = 1 or movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                    (movies_record.movie_id, movies_record.movie_attr_id, 'Отличный фильм', null, null, null, null),
                    (movies_record.movie_id, movies_record.movie_attr_id, 'Шедевр', null, null, null, null);
            else
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                    (movies_record.movie_id, movies_record.movie_attr_id, 'Ужасная игра актеров', null, null, null, null),
                    (movies_record.movie_id, movies_record.movie_attr_id, 'Плохой видеомонтаж', null, null, null, null);
            end if;
        end if;

        if (movies_record.movie_attr_id = 3)
        then
            if (movies_record.movie_id = 1 or movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                    (movies_record.movie_id, movies_record.movie_attr_id, null, null, true, null, null);
            else
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                    (movies_record.movie_id, movies_record.movie_attr_id, null, null, false, null, null);
            end if;
        end if;

        if (movies_record.movie_attr_id = 3)
        then
            if (movies_record.movie_id = 1 or movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, true, null, null);
            else
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, false, null, null);
            end if;
        end if;

        if (movies_record.movie_attr_id = 4)
        then
            if (movies_record.movie_id = 1 or movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, false, null, null);
            else
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, true, null, null);
            end if;
        end if;

        if (movies_record.movie_attr_id = 5 or movies_record.movie_attr_id = 6)
        then
            if (movies_record.movie_id = 1 or movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, null, 9.2, null);
            else
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, null, 5.1, null);
            end if;
        end if;

        if (movies_record.movie_attr_id = 7)
        then
            if (movies_record.movie_id = 1)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-11 03:00:00', null, null, null);
            end if;
            if (movies_record.movie_id = 2)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2019-04-15 00:00:00', null, null, null);
            end if;
            if (movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-05 00:00:00', null, null, null);
            end if;
        end if;

        if (movies_record.movie_attr_id = 8)
        then
            if (movies_record.movie_id = 1)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-02 03:00:00', null, null, null);
            end if;
            if (movies_record.movie_id = 2)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-12-12 00:00:00', null, null, null);
            end if;
            if (movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-02 00:00:00', null, null, null);
            end if;
        end if;

        if (movies_record.movie_attr_id = 9)
        then
            if (movies_record.movie_id = 1)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, current_date, null, null, null);
            end if;
            if (movies_record.movie_id = 2)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-01 00:00:00', null, null, null);
            end if;
            if (movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-01 00:00:00', null, null, null);
            end if;
        end if;
        if (movies_record.movie_attr_id = 10)
        then
            if (movies_record.movie_id = 1)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-01 03:00:00', null, null, null);
            end if;
            if (movies_record.movie_id = 2)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, current_date, null, null, null);
            end if;
            if (movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, current_date + interval '20 day', null, null, null);
            end if;
        end if;
        if (movies_record.movie_attr_id = 11)
        then
            if (movies_record.movie_id = 1)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-01 03:00:00', null, null, null);
            end if;
            if (movies_record.movie_id = 2)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-01 00:00:00', null, null, null);
            end if;
            if (movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, current_date, null, null, null);
            end if;
        end if;

        if (movies_record.movie_attr_id = 12)
        then
            if (movies_record.movie_id = 1)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-01 03:00:00', null, null, null);
            end if;
            if (movies_record.movie_id = 2)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, current_date + interval '20 day', null, null, null);
            end if;
            if (movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, '2020-02-01 00:00:00', null, null, null);
            end if;
        end if;
        if (movies_record.movie_attr_id = 13)
        then
            if (movies_record.movie_id = 1)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, null, null, 6);
            end if;
            if (movies_record.movie_id = 2)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, null, null, 2);
            end if;
            if (movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, null, null, 12);
            end if;
        end if;
        if (movies_record.movie_attr_id = 13)
        then
            if (movies_record.movie_id = 1)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, null, null, 12);
            end if;
            if (movies_record.movie_id = 2)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, null, null, 10);
            end if;
            if (movies_record.movie_id = 3)
            then
                INSERT INTO movies_attr_value (movie_id, movie_attr_id, value_string, value_date, value_bool, value_float, value_int)
                VALUES
                (movies_record.movie_id, movies_record.movie_attr_id, null, null, null, null, 18);
            end if;
        end if;
    END LOOP;
END$$;

