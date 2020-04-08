---- simple query ----
select customer_id, offer_id, place_id, "date" from tickets where "date" > '2020-04-01' and "date" < '2020-04-07';

select num_row, num_col from places where hall_id = 1;

select hall_id, count(*) as "places" from places group by hall_id;

---- hard query ----
select halls.name, min("date"), max("date") from tickets
left join places on places.id = tickets.place_id
left join halls on halls.id = places.hall_id
group by halls.id;


select films.id, films.name, sum(price) as total from tickets
left join offers on offers.id = tickets.offer_id
left join films on films.id = offers.film_id
group by films.id, films.name order by total;

select tickets.date, count(*) as "tickets", sum(price) from tickets
left join offers on offers.id = tickets.offer_id group by tickets.date;
