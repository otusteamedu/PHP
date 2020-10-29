-- Функция генерирования случайной строки
Create or replace function random_string(length integer) returns text as
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length loop
            result := result || chars[1+random()*(array_length(chars, 1)-1)];
        end loop;
    return result;
end;
$$ language plpgsql;

-- процедура заполнения всех таблиц данными
-- имеет один параметр: C кол-во создаваемых объектов
-- кол-во кинозалов = С * 0.001
-- кол-во фильмов = C * 0.01
-- кол-во сеансов = С * 0.1
-- кол-во билетов = С
-- кол-во типов аттрибутов = кол-во сеансов
-- кол-во аттрибутов = кол-во фильмов
-- кол-во значений аттрибутов = С
CREATE OR REPLACE FUNCTION public.fill_tables(c integer)
    RETURNS void
    LANGUAGE plpgsql
AS $function$
declare
    t_halls int;
    t_films int;
    t_seanse int;
    i int;
    hall_id int;
    film_id int;
    seanse_id int;
    attr_id int;
    col_n  int;
    row_n  int;
    tcoast  int;
    str text;
begin
    -- очищаем все таблицы
    truncate table attr_values cascade;
    alter sequence attr_values_id_seq restart with 1;

    truncate table attr_types cascade;
    alter sequence attr_types_id_seq restart with 1;

    truncate table attrs cascade;
    alter sequence attrs_id_seq restart with 1;

    truncate table ticket cascade;
    alter sequence ticket_id_seq restart with 1;

    truncate table seanse cascade;
    alter sequence seanse_id_seq restart with 1;

    truncate table film cascade;
    alter sequence film_id_seq restart with 1;

    truncate table hall cascade;
    alter sequence hall_id_seq restart with 1;

    -- заполнение данных: кинозалы
    t_halls := round(c * 0.001);
    if t_halls < 1 then
        t_halls := 1;
    end if;

    insert into hall (name) select 'hall' || generate_series(1, t_halls) as name;

    raise notice 'Создали % кинозалов',t_halls;

-- заполняем фильмы
    t_films := round(c * 0.01);
    if t_films < 1 then
        t_films := 1;
    end if;
    insert into film (name) select 'film' || generate_series(1,t_films) as name;
    raise notice 'Создали % фильмов',t_films;

-- заполняем сеансы
    t_seanse := round(c * 0.1);
    if  t_seanse < 1 then
        t_seanse := 1;
    end if;

    i := 1;
    while i <= t_seanse loop
            hall_id := random()*t_halls+1;
            if hall_id > t_halls then
                hall_id := t_halls;
            end if;

            film_id := random()*t_films+1;
            if film_id > t_films then
                film_id := t_films;
            end if;

            insert into seanse (hall, film, start_show) values (hall_id, film_id, timestamp '2020-11-01 09:00:00' + random() * interval '120 days');
            i := i + 1;
        end loop;
    raise notice 'Создали % сеансов', t_seanse;

-- заполняем билеты
    i := 1;
    while i <= c loop
            seanse_id := random()*t_seanse+1;
            if seanse_id > t_seanse then
                seanse_id := t_seanse;
            end if;

            col_n := random()*20+1;
            row_n := random()*10+1;
            tcoast := row_n*10+col_n*5;

            insert into ticket (seanse, col,"row", coast) values (seanse_id, col_n, row_n, tcoast);
            i := i + 1;
        end loop;
    raise notice 'Создали % билетов', i;

-- заполняем типы атрибутов
    insert into attr_types (attr_type) select 'attr_type_' || generate_series(1, t_halls) as name;

-- заполняем названия атрибутов
    i := 1;
    while i <= t_films loop
            hall_id := random()*t_halls+1;
            if hall_id > t_halls then
                hall_id := t_halls;
            end if;

            insert into attrs (attr_type, attr_name) values (hall_id, 'attr_' || i);

            i := i + 1;
        end loop;

    raise notice 'Создали % названий аттрибутов',i;
-- заполняем значения аттрибутов
    i := 1;
    while i <= c loop
            -- ID фильма
            film_id := random()*t_films+1;
            if film_id > t_films then
                film_id := t_films;
            end if;

            -- ID аттрибута
            attr_id := random()*t_films+1;
            if attr_id > t_halls then
                attr_id := t_films;
            end if;
            str := random_string(15);
            insert into attr_values (film, attr, attr_value) values (film_id, attr_id, str);

            i := i + 1;
        end loop;
    raise notice 'Создали % значений аттрибутов',i;
END;
$function$
;
