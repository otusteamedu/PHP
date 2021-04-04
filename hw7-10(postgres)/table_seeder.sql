Alter table tickets disable trigger all;
Alter table sessions disable trigger all;
Alter table movies disable trigger all;
Alter table halls disable trigger all;
Alter table hall_seats disable trigger all;
Alter table cinemas disable trigger all;
Alter table movie_attribute_types disable trigger all;
Alter table movie_attribute_values disable trigger all;
Alter table movie_attributes disable trigger all;

INSERT INTO otus.cinemas (title) VALUES
('Родина');

INSERT INTO otus.halls (cinema_id,"number",title) VALUES
(1,1,'Первый зал'),
(1,2,'Второй зал'),
(1,3,'Третий зал'),
(1,4,'Четвёртый зал'),
(1,5,'Пятый зал'),
(1,6,'Шестой зал'),
(1,7,'Седьмой зал'),
(1,8,'Восьмой зал'),
(1,9,'Девятый зал'),
(1,10,'Десятый зал');

INSERT INTO otus.employees (last_name, first_name , middle_name, "position") values
('Иванов', 'Иван', 'Иванович', 'директор'),
('Петров', 'Пётр', 'Петрович', 'кассир'),
('Семёнов', 'Семён', 'Семёнович', 'кассир'),
('Ивашина', 'Татьяна', 'Леонидовна', 'кассир'),
('Колмогорова', 'Елена', 'Юрьевна', 'кассир')
;

INSERT INTO otus.movies (title, slogan, base_price) VALUES
('17 мгновений весны', 'Шедевру не нужно это жалкое изобретение нынешнего маркетинга!', 100),
('Иван Васильевич меняет профессию', 'Аналогично!', 200),
('Третий фильм', 'Слоган третьего фильма', 300),
('Четвёртый фильм', 'Слоган четвёртого фильма', 400),
('Пятый фильм', 'Слоган пятого фильма', 500),
('Шестой фильм', 'Слоган шестого фильма', 600),
('Седьмой фильм', 'Слоган седьмого фильма', 700),
('Восьмой фильм', 'Слоган восьмого фильма', 800),
('Девятый фильм', 'Слоган девятого фильма', 900),
('Десятый фильм', 'Слоган десятого фильма', 1000);

DROP FUNCTION if exists get_ids(table_name varchar);
Create or replace function get_ids(table_name varchar) returns table (id int[]) as
$$
declare
begin
    return query EXECUTE format('SELECT array_agg(id) FROM %s', table_name);
end;
$$ language plpgsql;

-- seed table hall_seats
drop function if exists hall_seats_table_seeder (records_number int);

create or replace function hall_seats_table_seeder (records_number int) returns void as
$$
declare
    table_name varchar := 'hall_seats';
    parent_table_name varchar := 'halls';
    ids int[] := get_ids(parent_table_name);
    id int;
    counter int := 0;
    row_id int;
    seat_id int;
begin
    loop
        counter := counter + 1;
        IF counter > records_number THEN
            EXIT;  -- выход из цикла
        END IF;
        row_id := floor(counter / 100) + 1;
        seat_id := floor(counter % 100) + 1;
        id := ids [floor(random() * array_length(ids, 1) + 1)] ;
        execute format('INSERT INTO %s (hall_id, "row_number", seat_number, seat_price_modificator) VALUES
	       (%s, %s, %s, %s)', table_name, id, row_id, seat_id, random() * 10);
    END LOOP;
end;
$$ language plpgsql;

select hall_seats_table_seeder(10000);

drop function if exists sessions_table_seeder (records_number int);

create or replace function sessions_table_seeder (records_number int) returns void as
$$
declare
    table_name varchar := 'sessions';
    parent_table_name_halls varchar := 'halls';
    parent_table_name_movies varchar := 'movies';
    hall_ids int[] := get_ids(parent_table_name_halls);
    movies_ids int[] := get_ids(parent_table_name_movies);
    hall_id int;
    movie_id int;
    counter int := 0;
begin
    loop
        counter := counter + 1;
        IF counter > records_number THEN
            EXIT;
        END IF;

        hall_id := hall_ids [floor(random() * array_length(hall_ids, 1) + 1)];
        movie_id := movies_ids [floor(random() * array_length(movies_ids, 1) + 1)] ;
        execute format(E'INSERT INTO %s (hall_id, movie_id, title, start_time, end_time, session_price_modificator) VALUES
	       (%s, %s, \'Имя сессии\', \'%s\', \'%s\', %s)', table_name, hall_id, movie_id, NOW(), NOW() + interval '2' hour , random() * 10);
    END LOOP;
end;
$$ language plpgsql;

select sessions_table_seeder(10000);

drop function if exists tickets_table_seeder (records_number int);

create or replace function tickets_table_seeder (records_number int) returns void as
$$
declare
    table_name varchar := 'tickets';
    parent_table_name_sessions varchar := 'sessions';
    parent_table_name_hall_seats varchar := 'hall_seats';
    hall_seats_ids int[] := get_ids(parent_table_name_hall_seats);
    session_ids int[] := get_ids(parent_table_name_sessions);
    hall_seat_id int;
    session_id int;
    counter int := 0;
    statuses text[] := array['reserved', 'available', 'sold', 'refund'];
begin
    loop
        counter := counter + 1;
        IF counter > records_number THEN
            EXIT;
        END IF;
        session_id := session_ids [floor(random() * array_length(session_ids, 1) + 1)] ;
        hall_seat_id := hall_seats_ids [floor(random() * array_length(hall_seats_ids, 1) + 1)];
        --   status := array [random()*(4) + 1];
        execute format(E'INSERT INTO %s (session_id, hall_seat_id, status) VALUES
	       (%s, %s, \'%s\')', table_name, session_id, hall_seat_id, statuses[floor(random()*4 + 1)]);  --  statuses[random()*(4) + 1]
    END LOOP;
end;
$$ language plpgsql;

select tickets_table_seeder(10000);

INSERT INTO otus.movie_attribute_types ("type", "name") values
('bool', 'Премии'),
('int', 'Длительность фильма, с'),
('float', 'Рейтинги'),
('date', 'Важные даты'),
('date', 'Служебные задачи'),
('text', 'Рецензии критиков'),
('text', 'Отзыв киноакадемии');

INSERT INTO otus.movie_attributes ("name") values
('Оскар'),
('Ника'),
('Длительность фильма, с'),
('Рейтинг на кинопоиск'),
('Рейтинг на imdb'),
('Мировая премьера'),
('Премьера в РФ'),
('Начало продажи билетов'),
('Начало запуска рекламы'),
('Рецензия кинокритика №1'),
('Рецензия кинокритика №2'),
('Рецензия кинокритика №3'),
('Отзыв киноакадемии №1'),
('Отзыв киноакадемии №2');

drop function if exists movie_attribute_values_table_seeder (records_number int);

create or replace function movie_attribute_values_table_seeder (records_number int) returns void as
$$
declare
    table_name varchar := 'movie_attribute_values';
    movie_ids int[] := get_ids('movies');
    attribute_type_ids int[] := get_ids('movie_attribute_types');
    attribute_ids int[] := get_ids('movie_attributes');
    movie_id int;
    attribute_type_id int;
    attribute_id int;
    counter int := 0;
    value_boolean bool;
    value_int int;
    value_float float;
    value_date date;
    value_text varchar;
    random_date date;
begin
    loop
        counter := counter + 1;
        IF counter > records_number THEN
            EXIT;
        END IF;
        movie_id := movie_ids [floor(random() * array_length(movie_ids, 1) + 1)];
        attribute_type_id := attribute_type_ids [floor(random() * array_length(attribute_type_ids, 1) + 1)];
        --     attribute_id := attribute_ids [floor(random() * array_length(attribute_ids, 1) + 1)];
        random_date := (array[current_date, date(CURRENT_DATE + '20 days'::interval day)]) [cast( random() * 10 as int) % 2 + 1];
        case attribute_type_id
            when 1 then
                value_boolean := true; value_int := null; value_float := null; value_date := null; value_text := null;
                attribute_id := (array[1,2]) [floor(random() * array_length(array[1,2], 1) + 1)];
            when 2 then
                value_boolean := false; value_int := floor(random()*100); value_float := null; value_date := null; value_text := null;
                attribute_id := 3;
            when 3 then
                value_boolean := false; value_int := null; value_float := random()*100; value_date := null; value_text := null;
                attribute_id := (array[4,5]) [floor(random() * array_length(array[4,5], 1) + 1)];
            when 4, 5 then
                value_boolean := false; value_int := null; value_float := null; value_date := random_date; value_text := null;
                attribute_id := (array[6,7,8,9]) [floor(random() * array_length(array[6,7,8,9], 1) + 1)];
            when 6, 7 then
                value_boolean := false; value_int := null; value_float := null; value_date := null; value_text := md5(random()::text);
                attribute_id := (array[10,11,12,13,14]) [floor(random() * array_length(array[10,11,12,13,14], 1) + 1)];
            else
                value_boolean := false; value_int := null; value_float := null; value_date := null; value_text := null;
            end case;

        execute format(E'INSERT INTO %s (movie_id, attribute_type_id, attribute_id, value_boolean, value_int, value_float, value_date, value_text) VALUES
	       (%s, %s, %s, \'%s\', %L, %L, %L, \'%s\')', table_name, movie_id, attribute_type_id, attribute_id, value_boolean, value_int, value_float, value_date, value_text);

    END LOOP;
end;
$$ language plpgsql;

select movie_attribute_values_table_seeder(10000);

drop function if exists orders_table_seeder (records_number int);

create or replace function orders_table_seeder (records_number int) returns void as
$$
declare
    table_name varchar := 'orders';
    ticket_ids int[] := get_ids('tickets');
    employee_ids int[] := get_ids('employees');
    ticket_id int;
    employee_id int;
    counter int := 0;
begin
    loop
        counter := counter + 1;
        IF counter > records_number THEN
            EXIT;
        END IF;
        ticket_id := ticket_ids [floor(random() * array_length(ticket_ids, 1) + 1)] ;
        employee_id := employee_ids [floor(random() * array_length(employee_ids, 1) + 1)];

        execute format(E'INSERT INTO %s (ticket_id, employee_id) VALUES
	       (%s, %s)', table_name, ticket_id, employee_id);
    END LOOP;
end;
$$ language plpgsql;

select orders_table_seeder(10000);

Alter table tickets enable trigger all;
Alter table sessions enable trigger all;
Alter table movies enable trigger all;
Alter table halls enable trigger all;
Alter table hall_seats enable trigger all;
Alter table cinemas enable trigger all;
Alter table movie_attribute_types enable trigger all;
Alter table movie_attribute_values enable trigger all;
Alter table movie_attributes enable trigger all;


