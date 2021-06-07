
INSERT INTO films (name, duration)
SELECT 'film' || id, (round(1 + (3 - 1) * random()) ||':'||round(0 + (59 - 0) * random())||':00')::time 
from generate_series(10001,10000000) as id;

INSERT INTO halls (name)
SELECT 'hall' || id
from generate_series(1,5) as id;

INSERT INTO clients (surname, name, patronymic, birthday, phone)
SELECT 'surname' || id, 'name' || id, 'patronymic' || id,
(round(1940 + (2020 - 1940) * random()) ||'-'||round(1 + (12 - 1) * random())||'-'||round(1 + (28 - 1) * random()))::date,
'892'||repeat('0', 8 - LENGTH(id::varchar))
from generate_series(1,10000000) as id;

INSERT INTO 
    sessions (id_hall, id_film, time, base_price, date)
select
    5, t.id_film, generate_series('2021-03-21 10:00'::timestamp,'2021-03-21 23:00:00'::timestamp, t.duration) as time, round(300 + (1000 - 300) * random()), '2021-03-21'
from
(
    SELECT 
        id_film, (SELECT duration FROM films WHERE id = id_film) as duration
    from round(1 + (10000 - 1) * random()) as id_film
) t 
;

INSERT INTO 
    attribute_value (id_film, id_attr, v_varchar, v_date, v_int, v_double, v_boolean)
SELECT
    id, 3,  null, ('2020' ||'-'||round(1 + (12 - 1) * random())||'-'||round(1 + (28 - 1) * random()))::date, null, null, null
from 
generate_series(10001,10000000) as id
;

INSERT INTO 
    tickets (id_client, id_session, id_place, cost)
SELECT
    round(1 + (10000 - 1) * random()) as id_client, t.id_session, t.id_place, t.base_price + (select price_difference from place_types where id = t.id_type)
from 
(
    select sessions.id as id_session, places.id as id_place, sessions.base_price as base_price, places.id_type as id_type
    from sessions
    join places on places.id_hall = sessions.id_hall
) t
limit 10000000
;