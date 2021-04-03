---3 Простых запроса
select customer_id, film_schedule_id, place_id, date
from ticket
where date >= '2021-04-02';

select row, col
from place
where hall_id = 1;

select *
from employee
where start_work_date > '2018-07-08';

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
CREATE INDEX idx_ticket_date ON ticket (date);
CREATE INDEX idx_employee_start_work_date ON employee (start_work_date);
