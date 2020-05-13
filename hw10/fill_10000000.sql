truncate table movies cascade;
truncate table sessions cascade;
truncate table basket cascade;
truncate table movie_property_values cascade;


-- 1 000 фильмов
insert into movies (name) select random_string(10) from generate_series(1, 1000);


-- 60 000 сеансов
insert into sessions (hall_id, movie_id, date, coefficient)
select halls.id, movies.id, random_timestamp('2 years'), random_float(0.8, 2, 1)
from generate_series(1, 20)
   cross join halls
   cross join movies;


-- корзины, 6 000 000 строк
insert into basket (order_id, session_id, seat_id, price)
select 
    null, 
    sessions.id, 
    seats.id, 
    random_pick(array[300, 500, 800, 1000, 1200, 1500])
from generate_series(1, 1)
   cross join sessions
   cross join seats;


-- удалим 50 000 случайных записей, чтобы была не всегда полная посадка
delete from basket where id in (select id from basket order by random() limit 50000);


-- добавим ещё 300 000 фильмов
insert into movies (name) select random_string(10) from generate_series(1, 300000);


-- проставим всем фильмам оскар=нет
insert into movie_property_values (movie, property, boolean_value)
select 
    movies.id, 
    1, 
    false
from generate_series(1, 1)
cross join movies;


-- 2 000 случайным фильмам вручим оскар
update movie_property_values set boolean_value = true 
where property = 1 and movie in (select id from movies order by random() limit 2000);


-- рейтинги
insert into movie_property_values (movie, property, float_value)
select 
    movies.id, 
    12, 
    random_float(1, 10, 4)
from generate_series(1, 1)
cross join movies;

insert into movie_property_values (movie, property, float_value)
select 
    movies.id, 
    13, 
    random_float(1, 100, 1)
from generate_series(1, 1)
cross join movies;


-- премьера, мир
insert into movie_property_values (movie, property, date_value)
select 
    movies.id, 
    5, 
    random_timestamp('100 years')
from generate_series(1, 1)
cross join movies;


-- дата начала рекламы
insert into movie_property_values (movie, property, date_value)
select 
    movies.id, 
    7, 
    random_timestamp('1 year')
from generate_series(1, 1)
cross join movies;


-- дата начала продажи билетов
insert into movie_property_values (movie, property, date_value)
select 
    movies.id, 
    8, 
    random_timestamp('1 year')
from generate_series(1, 1)
cross join movies;


-- сборы, мир
insert into movie_property_values (movie, property, integer_value)
select 
    movies.id, 
    9, 
    random_int(100000, 10000000)
from generate_series(1, 1)
cross join movies;


-- сборы, рф
insert into movie_property_values (movie, property, integer_value)
select 
    movies.id, 
    10, 
    random_int(100000, 1000000)
from generate_series(1, 1)
cross join movies;


-- количество зрителей
insert into movie_property_values (movie, property, integer_value)
select 
    movies.id, 
    11, 
    random_int(100000, 1000000)
from generate_series(1, 1)
cross join movies;


-- проставим всем фильмам рецензии
insert into movie_property_values (movie, property, text_value)
select 
    movies.id, 
    3, 
    random_string(100)
from generate_series(1, 1)
cross join movies;