create extension if not exists plpgsql;

delete
from movies_attributes_types;
delete
from movies_attributes;
delete
from movies_attributes_values;
delete
from tickets;
delete
from movies;
delete
from sessions;
delete
from halls;

-- справочник типов аттрибутов фильмов

insert into movies_attributes_types (id, name)
values (1, 'text'),
       (2, 'logic'),
       (3, 'date'),
       (4, 'real'),
       (5, 'number')
on conflict do nothing;
-------------------------------------------------
-- справочник аттрибутов фильмов
insert into movies_attributes (id, name, type_id)
values (1, 'отзыв', 1),
       (2, 'новинка', 2),
       (3, 'бюджет', 5),
       (4, 'рэйтинг', 4),
       (5, 'дата выхода', 3),
       (6, 'жанр', 1)
on conflict do nothing;
-------------------------------------------------

-- возвращает целое, находящееся в интервале от min_val до max_val включительно
create or replace function random_int(min_val integer, max_val integer) returns integer as
$$
begin
    if min_val > max_val then
        return min_val;
    else
        return floor(random() * (max_val - min_val + 1)) + min_val;
    end if;
end;
$$ language plpgsql;

-- возвращает строку длинной base_length (+/- от 0 до dispersion) символов
create or replace function random_string(base_length integer, dispersion integer = 0) returns text as
$$
declare
    needle_str text   := '';
    symbols    text[] := '{A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    length     integer;
begin
    if (dispersion >= base_length) then
        dispersion := 0;
    end if;
    if (random() < 0.5) then
        length := base_length + random_int(0, dispersion);
    else
        length := base_length - random_int(0, dispersion);
    end if;
    for i in 0..length
        loop
            needle_str := needle_str || symbols[random_int(1, array_length(symbols, 1))];
        end loop;
    return needle_str;
end;
$$ language plpgsql;

-- заполнение таблиц тестовыми данными size - порядок кол-ва строк с текстовыми полями
create or replace function filling_test_data(size integer) returns void as
$$
declare
    halls_count_limit  integer := round(log10(size));
    movies_count_limit integer := round(exp(halls_count_limit) ^ 2);
    sessions_limit     integer := 1 + movies_count_limit / halls_count_limit -
                                  movies_count_limit / exp(halls_count_limit);
    days_count_limit   integer := ceil(sessions_limit / 6);
    hall               record;
    movies_id_list     integer[];
    movie_id           integer;
    session_date       date;
    session_time       char(5);

begin

    -- постройка залов 12 рядов 15 мест в ряду
    for i in 1..halls_count_limit
        loop
            insert into halls(title, lines_count, line_seats_count) values (random_string(6, 2), 12, 15);
        end loop;

    -- производство фильмов, по триггеру добавление некоторых сведений
    for i in 1..movies_count_limit
        loop
            insert into movies (title, duration) values (random_string(12, 8), random_int(40, 120));
        end loop;
    movies_id_list := array(select id from movies);

    -- расписание сеансов (6 сеансов в день в каждом зале, каждый фильм будет показан примерно 1 раз)
    for day in -days_count_limit..1
        loop
            session_date := current_date - (day || ' days')::interval;
            for hour in 08..23
                loop
                    if (hour + 1) % 3 = 0 then
                        session_time = hour || ':00';
                        for hall in select id from halls
                            loop
                                -- не все фильмы будут распределены по расписанию сеансов, по триггеру продажа билетов на сеанс
                                movie_id := movies_id_list[random_int(1, array_length(movies_id_list, 1))];
                                insert into sessions (hall_id, movie_id, date, time)
                                values (hall.id, movie_id, session_date, session_time);
                            end loop;
                    end if;
                end loop;
        end loop;

end
$$ language plpgsql;

-- заполнение аттрибутов фильмов
create or replace function add_movie_attributes() returns trigger as
$$
declare
    movie_id integer := new.id;
    rand_val double precision;
begin

    rand_val := random();

    -- добавление от 0 до 3 отзывов к фильму id_attribute=1
    for i in 0..random_int(0, 3)
        loop
            insert into movies_attributes_values(id_attribute, id_movie, as_text)
            values (1, movie_id, random_string(40, 20));
        end loop;

    -- некоторые фильмы отметим как новинки id_attribute=2
    if rand_val < 0.05 then
        insert into movies_attributes_values(id_attribute, id_movie, as_bool)
        values (2, movie_id, true);
    end if;

    -- для некоторых фильмов укажем бюджет id_attribute=3
    rand_val := random();
    if rand_val < 0.6 then
        insert into movies_attributes_values(id_attribute, id_movie, as_int)
        values (3, movie_id, random_int(5000, 1000000));
    end if;

    -- для некоторых фильмов укажем рэйтинг id_attribute=4
    if rand_val > 0.4 then
        insert into movies_attributes_values(id_attribute, id_movie, as_float)
        values (4, movie_id, 10 * random());
    end if;

    -- для некоторых фильмов укажем дату выхода id_attribute=5
    rand_val := random();
    if rand_val < 0.7 then
        insert into movies_attributes_values(id_attribute, id_movie, as_date)
        values (5, movie_id, current_date - (random_int(0, 120) || 'days')::interval);
    end if;

    -- для некоторых фильмов укажем жанр id_attribute=6
    if rand_val > 0.4 then
        insert into movies_attributes_values(id_attribute, id_movie, as_text)
        values (6, movie_id, lower(random_string(6, 3)));
    end if;

    return new;
end;
$$ language plpgsql;

-- продажа билетов на сеанс
create or replace function sell_tickets() returns trigger as
$$
begin
    for line in 1..random_int(0, 6)
        loop
            for seat in 1..random_int(0, 10)
                loop
                    insert
                    into tickets (session_id, seat_number, line_number, price)
                    values (new.id, seat, line, random_int(200, 1000));
                end loop;
        end loop;
    return new;
end;
$$ language plpgsql;

drop trigger if exists fill_movies_attributes_values on movies;
create trigger fill_movies_attributes_values
    after insert
    on movies
    for each row
execute procedure add_movie_attributes();

drop trigger if exists sell_tickets on sessions;
create trigger sell_tickets
    after insert
    on sessions
    for each row
execute procedure sell_tickets();