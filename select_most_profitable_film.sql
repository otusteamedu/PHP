-- Заспрос на получение самого прибыльного фильма
select film.name, sum(price)
from ticket
         left join session on ticket.session_id = session.id
         left join film on film.id = session.film_id
group by film.name
order by sum(price) desc
limit 1