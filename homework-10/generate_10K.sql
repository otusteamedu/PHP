-- Clear database
truncate seat_types, ticket_discounts, movies, halls, rows, seats, sessions, tickets, attribute_movie_values, attribute_types, attributes restart identity cascade;


-- Fill seat_types table
insert into seat_types (name)
select
    md5(random()::text)
from generate_series(1, 3);


-- Fill seat_types table
insert into ticket_discounts (type_id, discount)
select
    i,
    0.6 + i * 0.2
from generate_series(1, 3) s(i);


-- Fill movies table
insert into movies (name, description)
select
    md5(random()::text),
    md5(random()::text) || md5(random()::text) || md5(random()::text) || md5(random()::text)
;


-- Fill halls table
insert into halls (name)
select md5(random()::text);


-- Fill rows table
insert into rows (hall_id, number)
select
        ceil((i-1)/20)+1,
        i
from generate_series(1, 20) s(i);


-- Fill seats table
insert into seats (row_id, type_id, number)
select
        ceil((i-1)/30)+1,
        ceil((i-1)%3)+1,
        ceil((i-1)%30)+1
from generate_series(1, 20*30) s(i);


-- Fill sessions table
insert into sessions (hall_id, movie_id, price, starts_at)
select
    1,
    1,
    ceil(random()*10)*100,
    to_timestamp(ceil(random()*347155200)+1262304000)
from generate_series(1, 100) s(i);


-- Fill tickets table
insert into tickets (session_id, seat_id, cost, created_at)
select
        ceil((i-1)/100)+1,
        ceil(random()*600),
        ceil(random()*10)*100,
        to_timestamp(ceil(random()*347155200)+1262304000)
from generate_series(1, 10000) s(i);


-- Fill attribute_types table
insert into attribute_types (name) values ('Text'), ('String'), ('Integer'), ('Money'), ('Float'), ('Date'), ('Boolean');


-- Fill attributes table
insert into attributes (type_id, name)
select
    ceil(random()*7),
    md5(random()::text)
from generate_series(1, 100);


-- Fill attribute_movie_values table
-- text value
insert into attribute_movie_values (movie_id, attribute_id, text_value)
select
    1,
    1,
    repeat(md5(random()::text), ceil(random()*1000)::int)
from generate_series(1, 100);

-- string value
insert into attribute_movie_values (movie_id, attribute_id, string_value)
select
    1,
    2,
    md5(random()::text)
from generate_series(1, 100);

-- integer value
insert into attribute_movie_values (movie_id, attribute_id, integer_value)
select
    1,
    3,
    ceil(random()*1000000)
from generate_series(1, 100);


-- money value
insert into attribute_movie_values (movie_id, attribute_id, money_value)
select
    1,
    4,
    round((random()*1000000)::numeric, 4)
from generate_series(1, 100);

-- text value
insert into attribute_movie_values (movie_id, attribute_id, float_value)
select
    1,
    5,
    random()*1000000
from generate_series(1, 100);

-- text value
insert into attribute_movie_values (movie_id, attribute_id, date_value)
select
    1,
    6,
    to_timestamp(ceil(random()*347155200)+1262304000)
from generate_series(1, 100);

-- text value
insert into attribute_movie_values (movie_id, attribute_id, boolean_value)
select
    1,
    7,
    random()::int::boolean
from generate_series(1, 100);


