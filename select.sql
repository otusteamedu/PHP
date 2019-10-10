select seance.price_increase +film.price_basic * count(buy_ticket.id_ticket) as price, film.name
from film 
inner join tickets on film.id=tickets.id_films 
inner join seance on tickets.id_seance=seance.id 
inner join buy_ticket on tickets.id= buy_ticket.id_ticket
group by film.name ,seance.price_increase,film.price_basic having count(film.name)=1 order by price desc