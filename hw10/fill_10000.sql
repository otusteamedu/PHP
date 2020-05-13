truncate table movies cascade;
truncate table sessions cascade;
truncate table basket cascade;
truncate table movie_property_values cascade;


-- 10 фильмов
insert into movies (name) select random_string(10) from generate_series(1, 10);


-- 300 сеансов
insert into sessions (hall_id, movie_id, date, coefficient)
select halls.id, movies.id, random_timestamp('1 year'), random_float(0.8, 2, 1)
from generate_series(1, 10)
   cross join halls
   cross join movies;


-- корзины, 30 000 строк
insert into basket (order_id, session_id, seat_id, price)
select 
    null, 
    sessions.id, 
    seats.id, 
    random_pick(array[300, 500, 800, 1000, 1200, 1500])
from generate_series(1, 1)
   cross join sessions
   cross join seats;


-- удалим 1 000 случайных записей, чтобы была не всегда полная посадка
delete from basket where id in (select id from basket order by random() limit 1000);


-- добавим ещё 2 000 фильмов
insert into movies (name) select random_string(10) from generate_series(1, 2000);


-- проставим всем фильмам оскар=нет
insert into movie_property_values (movie, property, boolean_value)
select 
    movies.id, 
    1, 
    false
from generate_series(1, 1)
cross join movies;


-- 20 случайным фильмам вручим оскар
update movie_property_values set boolean_value = true 
where property = 1 and movie in (select id from movies order by random() limit 20);


-- проставим всем фильмам рейтинг
insert into movie_property_values (movie, property, float_value)
select 
    movies.id, 
    12, 
    random_float(1, 10, 3)
from generate_series(1, 1)
cross join movies;


-- проставим всем фильмам дату начала продажи билетов
insert into movie_property_values (movie, property, date_value)
select 
    movies.id, 
    8, 
    random_timestamp('1 year')
from generate_series(1, 1)
cross join movies;