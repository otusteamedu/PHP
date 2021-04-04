---3 Простых запроса
select customer_id, film_schedule_id, place_id, date
from ticket
where date >= '2021-04-02';

select *
from place
where place.place_category_id >= 1;

select count(*)
from employee
where start_work_date <= '2018-07-09';

--- 3 сложных запроса
select o.id as order_id, hall.name, min(date), max(date), o.ticket_id
from ticket
         left join place on place.id = ticket.place_id
         left join hall on hall.id = place.hall_id
         left join "order" o on ticket.id = o.ticket_id
group by order_id, hall.name, o.ticket_id
order by order_id desc;

select o.id as order_id, c.id as cus_id, fs.start_at, fs.finished_at
from "order" o
         left join ticket t on t.id = o.ticket_id
         left join film_schedule fs on fs.id = t.film_schedule_id
         left join film f2 on f2.id = fs.film_id
         left join customer c on t.customer_id = c.id;

SELECT film.name, earnings.money
FROM film
         LEFT JOIN (SELECT film_schedule.film_id, SUM(fspp.price) as money
                    FROM ticket
                             LEFT JOIN film_schedule ON film_schedule.id = ticket.film_schedule_id
                             LEFT JOIN place p ON ticket.place_id = p.id
                             LEFT JOIN film_schedule_place_price AS fspp ON film_schedule.id = fspp.film_schedule_id
                    WHERE fspp.price IS NOT NULL
                    GROUP BY film_schedule.film_id) AS earnings
                   ON film.id = earnings.film_id;


--- optimization ----
CREATE INDEX idx_date ON ticket (date);
CREATE INDEX idx_place_category_id ON place USING btree(place_category_id);
CREATE INDEX idx_start_work_date ON employee USING btree(start_work_date);

CREATE INDEX idx_date ON ticket USING btree(date);
CREATE INDEX idx_ticket_id ON "order" USING btree(ticket_id);
CREATE INDEX idx_place_id ON ticket USING btree(place_id);
CREATE INDEX idx_hall_id ON place USING btree(hall_id);
CREATE INDEX idx_name ON hall USING btree(name);

CREATE INDEX idx_ticket_id ON "order" USING btree(ticket_id);
CREATE INDEX idx_film_schedule_id ON ticket USING btree(film_schedule_id);
CREATE INDEX idx_film_id ON film_schedule USING btree(film_id);
CREATE INDEX idx_start_at ON film_schedule USING btree(start_at);
CREATE INDEX idx_finished_at ON film_schedule USING btree(finished_at);
CREATE INDEX idx_customer_id ON ticket USING btree(customer_id);

CREATE INDEX idx_film_id ON film_schedule USING btree(film_id);
CREATE INDEX idx_film_schedule_id ON ticket USING btree(film_schedule_id);
CREATE INDEX idx_place_id ON ticket USING btree(place_id);
