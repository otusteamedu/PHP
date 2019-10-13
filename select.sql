SELECT count(tickets.id)*tickets.price as best_selling_movie, film.name as film_name
FROM public.tickets 
inner join seance on tickets.id_seance = seance.id 
inner join film on seance.id_film = film.id 
group by  tickets.price, film.name 
order by best_selling_movie desc;