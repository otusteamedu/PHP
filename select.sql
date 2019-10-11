SELECT count(tickets.id_films)*price.price, film.name
FROM public.tickets 
inner join film on tickets.id_films = film.id 
inner join price on tickets.id_price = price.id 
group by tickets.id_films , price.price, film.name
having count(film.name)=1 order by price desc;