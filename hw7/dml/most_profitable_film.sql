select sessions.film_id, films.name, sum(tickets.price) as sales_amount
from tickets
inner join sessions on sessions.id = tickets.session_id
inner join films on sessions.film_id = films.id
group by sessions.film_id, films.name
order by sales_amount desc
fetch first row only;
