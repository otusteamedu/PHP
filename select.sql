SELECT count(tickets.id)*seance.price as best_selling_movie, film.name as film_name
FROM public.tickets 
inner join seance on tickets.id_seance = seance.id 
inner join film on seance.id_film = film.id 
group by  seance.price , film.name
having count(film.name)=1 order by best_selling_movie desc;