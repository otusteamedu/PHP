select
	f.name,
	sum(t.price) as income
from public.client_ticket as ct
join ticket as t on t.id = ct.ticket_id
join session as s on s.id = t.session_id
join film as f on f.id = s.film_id
group by f.name
order by income desc
limit 1;