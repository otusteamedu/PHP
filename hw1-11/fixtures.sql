---customer---
INSERT INTO customer (name, phone, email, login, created_at, updated_at)
SELECT arrays.name[gs.id % ARRAY_LENGTH(arrays.name, 1) + 1],
       arrays.phone[gs.id % ARRAY_LENGTH(arrays.name, 1) + 1],
       'person' || gs.id || '@example.com',
       arrays.login[gs.id % ARRAY_LENGTH(arrays.login, 1) + 1],
       date(now()) + 30  AS created_at,
       date(now()) + 130 AS updated_at
FROM generate_series(1, 10000) AS gs(id)
         CROSS JOIN(
    SELECT ARRAY [
               'Adam','Bill','Bob','Calvin','Donald','Dwight','Frank','Fred','George','Howard',
               'James','John','Jacob','Jack','Martin','Matthew','Max','Michael',
               'Paul','Peter','Phil','Roland','Ronald','Samuel','Steve','Theo','Warren','William',
               'Abigail','Alice','Allison','Amanda','Anne','Barbara','Betty','Carol','Cleo','Donna',
               'Jane','Jennifer','Julie','Martha','Mary','Melissa','Patty','Sarah','Simone','Susan'
               ]                                                      AS name,
           ARRAY [
               'Matthews','Smith','Jones','Davis','Jacobson','Williams','Donaldson','Maxwell','Peterson','Stevens',
               'Franklin','Washington','Jefferson','Adams','Jackson','Johnson','Lincoln','Grant','Fillmore','Harding','Taft',
               'Truman','Nixon','Ford','Carter','Reagan','Bush','Clinton','Hancock'
               ]                                                      AS login,
           ARRAY [
               '+7-953-5558-919','+7-903-5552-762','+7-925-5584-766','+7-909-5552-617',
               '+7-906-5556-586','+7-953-5559-940','+7-905-5556-734','+7-902-5553-891',
               '+7-951-5553-622','+7-952-5556-531','+7-915-5527-029','+7-953-5558-919',
               '+7-903-5552-762','+7-925-5584-766','+7-909-5552-617','+7-953-5558-919',
               '+7-903-5552-762','+7-925-5584-766','+7-909-5552-617','+7-953-5558-919',
               '+7-903-5552-762','+7-925-5584-766','+7-909-5552-617','+7-953-5558-919',
               '+7-903-5552-762','+7-925-5584-766','+7-909-5552-617','+7-953-5558-919',
               '+7-903-5552-762','+7-925-5584-766','+7-909-5552-617','+7-953-5558-919',
               '+7-903-5552-762','+7-925-5584-766','+7-909-5552-617','+7-953-5558-919',
               '+7-903-5552-762','+7-925-5584-766','+7-909-5552-617','+7-953-5558-919',
               '+7-903-5552-762','+7-925-5584-766','+7-909-5552-617','+7-953-5558-919',
               '+7-903-5552-762','+7-925-5584-766','+7-909-5552-617'] as phone
) AS arrays;


---film---
INSERT INTO film (name, year, country, description)
SELECT 'film' || gs.id || 'name',
       '2005',
       'country' || gs.id || 'name',
       'description' || gs.id || 'name'
FROM generate_series(1, 5) AS gs(id);

---hall---
INSERT INTO hall(name, limit_places)
SELECT 'hall_' || gs.id, floor(random() * (50) + 300)
from generate_series(1, 2) AS gs(id);

---place_category---
INSERT INTO place_category (category)
VALUES ('cheep'),
       ('discount'),
       ('expensive');

---film_schedule---
INSERT INTO film_schedule(film_id, start_at, finished_at)
VALUES (1, '10:00', '12:00'),
       (2, '12:00', '14:00'),
       (1, '14:00', '16:00'),
       (2, '18:00', '12:00'),
       (3, '10:00', '12:00'),
       (4, '12:00', '14:00'),
       (3, '10:00', '12:00'),
       (4, '12:00', '14:00'),
       (5, '14:00', '16:00'),
       (5, '18:00', '12:00');

---film_schedule_place_price---
INSERT INTO film_schedule_place_price(film_schedule_id, place_category_id, price)
VALUES (1, 2, 200),
       (2, 1, 100);

---place---
---- Места для зала №1
INSERT INTO place (row, col, hall_id, place_category_id)
select gs.id, 1, 1, floor(random() * 3 + 1)::int
from generate_series(1, 100) as gs(id);

---- Места для зала №2
INSERT INTO place (row, col, hall_id, place_category_id)
select gs.id, 1, 2, floor(random() * 3 + 1)::int
from generate_series(1, 100) as gs(id);

---ticket---
INSERT INTO ticket (place_id, film_schedule_id, customer_id, date)
SELECT t1.place_id, t1.film_schedule_id, t1.customer_id, date(now()) + day_offset AS "date"
FROM generate_series(0, 3) as day_offset
         CROSS JOIN (
    SELECT p.id AS place_id, fspp.film_schedule_id AS film_schedule_id, c.id AS customer_id
    from place p
             LEFT JOIN hall h on h.id = p.hall_id
             LEFT JOIN place_category pc on pc.id = p.place_category_id
             LEFT JOIN film_schedule_place_price fspp on pc.id = fspp.place_category_id
             LEFT JOIN customer c on p.row = c.id
) AS t1;

---order---
INSERT INTO "order"(ticket_id, created_at, updated_at)
SELECT t1.id AS ticket_id,
       date(now()) + 30,
       date(now()) + 130
FROM generate_series(0, 2)
         CROSS JOIN (
    SELECT id
    FROM ticket) AS t1;

---employee---
INSERT INTO employee(name, position, start_work_date)

SELECT arrays.name[gs.id % ARRAY_LENGTH(arrays.name, 1) + 1],
       arrays.position[gs.id % ARRAY_LENGTH(arrays.position, 1) + 1],
       arrays.start_work_date
FROM generate_series(1, 10) AS gs(id)
         CROSS JOIN(
    SELECT ARRAY [
               'Adam','Bill','Bob','Calvin','Donald','Dwight','Frank','Fred','George','Howard',
               'James','John','Jacob','Jack','Martin','Matthew','Max','Michael',
               'Paul','Peter','Phil','Roland','Ronald','Samuel','Steve','Theo','Warren','William',
               'Abigail','Alice','Allison','Amanda','Anne','Barbara','Betty','Carol','Cleo','Donna',
               'Jane','Jennifer','Julie','Martha','Mary','Melissa','Patty','Sarah','Simone','Susan'
               ]                                                                       AS name,
           ARRAY [
               'accountant','cashier','copywriter',
               'engineer','financier',
               'journalist','interpreter','secretary'
               ]                                                                       AS position,
           generate_series(date(now()) - 1000, date(now()) - 100, '6 month'::interval) AS start_work_date
) AS arrays
