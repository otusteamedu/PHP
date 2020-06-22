INSERT INTO public.halls(hall)
VALUES ('зал 1')
     , ('зал 2')
     , ('зал 3')
     , ('зал 4')
     , ('зал 5')
     , ('зал 6')
     , ('зал 7')
     , ('зал 8')
     , ('зал 9');

INSERT INTO public.seats(seat)
VALUES ('обычное')
     , ('vip')
     , ('табуретка в проходе');

INSERT INTO public.movies(movie)
VALUES ('ДРУГОЙ МИР: ЧУЖОЙ ПРОТИВ ХИЩНИКА')
     , ('НЕУДЕРЖИМЫЕ: ПРОБУЖДЕНИЕ')
     , ('РОБОКОП: ПРОДАЖНОСТЬ НЕБЕС')
     , ('ЛЕГКАЯ КРОВЬ')
     , ('ПРЕДРАССВЕТНЫЕ ЛЮДИ')
     , ('ЧЕТВЕРТЫЙ ДОЗОР')
     , ('ТЕМНЫЙ ЭЛЕМЕНТ')
     , ('РЕМБО 5: ОБИТАЕМЫЕ ДЕНЬГИ')
     , ('КРЕПКИЙ ТАРИФ')
     , ('ЧЕЛОВЕК-ПАУК: БЕСКОНЕЧНЫЙ ЧЕРЕП')
     , ('БЕТМЕН: ОПЕРАЦИЯ Ы')
     , ('НЕВЕРОЯТНЫЙ КВАРТАЛ')
     , ('ГАРРИ ПОТТЕР: ОПЛОТ ИДИОТИЗМА');

INSERT INTO public.clients(fio)
VALUES ('Рыбаков Руслан Игоревич')
     , ('Корнилов Василий Вячеславович')
     , ('Романов Исаак Аркадьевич')
     , ('Тихонов Богдан Мэлсович')
     , ('Анисимов Дональд Данилович')
     , ('Никитин Велор Станиславович')
     , ('Лебедев Владимир Николаевич')
     , ('Рогов Бенедикт Егорович')
     , ('Сорокин Антон Авксентьевич')
     , ('Харитонов Абрам Вениаминович');

CREATE OR REPLACE PROCEDURE public.sp_gen_RANDOM()
LANGUAGE plpgsql
AS $$
DECLARE
    max_hall_id   INTEGER;
    max_seat_yd   INTEGER;
    max_movie_id  INTEGER;
    max_client_id INTEGER;
    max_order_id  INTEGER;
    cnt_tickets   INTEGER;
BEGIN

    SELECT MAX(hall_id) FROM public.halls INTO max_hall_id;
    SELECT MAX(seat_yd) FROM public.seats INTO max_seat_yd;

    FOR i IN 1..max_hall_id LOOP

        INSERT INTO public.halls_seats(hall_id, seat_id, seat_yd)
        SELECT i
             , seat_id
             , floor(RANDOM() * max_seat_yd + 1)
          FROM generate_series(1, 50) AS seat_id;

    END LOOP;

    SELECT MAX(movie_id) FROM public.movies INTO max_movie_id;

    INSERT INTO public.sessions(hall_id, movie_id, start_time)
    SELECT FLOOR(RANDOM() * max_hall_id + 1)
         , FLOOR(RANDOM() * max_movie_id + 1)
         , CURRENT_TIMESTAMP + shift * INTERVAL '1 HOUR'
      FROM generate_series(1, 100) AS shift;

    INSERT INTO public.sessions_prices(session_id, seat_yd, price)
    SELECT s1.session_id
         , s2.seat_yd
         , 10 * FLOOR(RANDOM() * 7 + 3)::INT::MONEY
      FROM public.sessions AS s1
     CROSS JOIN public.seats AS s2;

    SELECT MAX(client_id) FROM public.clients INTO max_client_id;

    INSERT INTO public.orders(client_id)
    SELECT FLOOR(RANDOM() * max_client_id + 1)
      FROM generate_series(1, 1000);

    SELECT MAX(order_id) FROM public.orders INTO max_order_id;

    FOR i IN 1..max_order_id LOOP

        cnt_tickets := FLOOR(RANDOM() * 3 + 1);

        FOR j IN 1..cnt_tickets LOOP

            INSERT INTO public.orders_tickets(order_id, ticket_id, session_id, seat_id)
            SELECT i
                 , j
                 , session_id
                 , seat_id
              FROM public.unoccupied_seats
             WHERE RANDOM() < 0.01
             LIMIT 1;

        END LOOP;

    END LOOP;

END;
$$;

CALL public.sp_gen_RANDOM();