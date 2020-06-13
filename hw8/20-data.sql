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

CREATE OR REPLACE PROCEDURE public.sp_gen_random()
LANGUAGE plpgsql
AS $$
DECLARE
    max_hall_id INT;
    rnd_hall_id INT;
    max_movie_id INT;
    rnd_movie_id INT;
    rnd_price MONEY;
    max_client_id INT;
    rnd_client_id INT;
    max_session_id INT;
    rnd_session_id INT;
BEGIN

    select max(hall_id) from public.halls into max_hall_id;
    select max(movie_id) from public.movies into max_movie_id;

    FOR i IN 1..100 LOOP

        rnd_hall_id := floor(random() * max_hall_id + 1);
        rnd_movie_id := floor(random() * max_movie_id + 1);
        rnd_price := 10 * floor(random() * 7 + 3);

        insert into public.sessions(hall_id, movie_id, price)
        values (rnd_hall_id, rnd_movie_id, rnd_price);

    END LOOP;

    select max(client_id) from public.clients into max_client_id;
    select max(session_id) from public.sessions into max_session_id;

    FOR i IN 1..1000 LOOP

        rnd_client_id := floor(random() * max_client_id + 1);
        rnd_session_id := floor(random() * max_session_id + 1);

        insert into public.orders(client_id, session_id)
        values (rnd_client_id, rnd_session_id);

    END LOOP;

END;
$$;

CALL public.sp_gen_random();