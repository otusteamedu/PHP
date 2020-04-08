insert into films(name, duration) values ('film1', 120), ('film2', 120);

-- create 10 halls
insert into halls(name, num_places)
    select  'hall_' || gs.id, floor(random()* (100) + 200)
    from generate_series(1,2) as gs(id);
--
-- create sessions
insert into sessions(hall_id, time_from, time_to) values
(1, '12:00', '14:00'), (2, '12:00', '14:00'),
(1, '14:00', '16:00'), (2, '14:00', '16:00');
--
-- create offers
insert into offers(session_id, film_id, price) values
(1,1,150), (2,2,200), (3,1,250),(4,2,300);


-- create customers
insert into customers (name, phone)
select 'customer_' || gs.id, '' from generate_series(1,1000) as gs(id);

---- places for hall 1
insert into places (hall_id, num_row, num_col)
select 1, gs.id, 1 from generate_series(1,1000) as gs(id);
---- places for hall 2
insert into places (hall_id, num_row, num_col)
select 2, gs.id, 1 from generate_series(1,1000) as gs(id);
--

-- 1000 tickets for every session (4) during 3 days (12000)--
insert into tickets (customer_id, offer_id, place_id, "date")
select t.customer_id, t.offer_id, t.place_id, '2020-04-01'::date + day_offset as "date"
from generate_series(0,2) as day_offset
    cross join
     (
         select customers.id customer_id,  offers.id offer_id, places.id place_id, session_id
         from
             places
                 join halls on places.hall_id = halls.id
                 join sessions on sessions.hall_id = halls.id
                 join offers on offers.session_id = sessions.id
                 join customers on customers.id = places.num_row
     ) t;


-- add 88000 tickets  during 22 days--
insert into tickets (customer_id, offer_id, place_id, "date")
select t.customer_id, t.offer_id, t.place_id, '2020-04-01'::date + day_offset as "date"
from generate_series(3,24) as day_offset
         cross join
     (
         select customers.id customer_id,  offers.id offer_id, places.id place_id, session_id
         from
             places
                 join halls on places.hall_id = halls.id
                 join sessions on sessions.hall_id = halls.id
                 join offers on offers.session_id = sessions.id
                 join customers on customers.id = places.num_row
     ) t;