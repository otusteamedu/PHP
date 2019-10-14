SELECT count(tickets.id)*cashier.price as best_selling_movie, film.name as film_name
FROM public.tickets 
inner join cashier on tickets.id = cashier.id_ticket
inner join seance on tickets.id_seance = seance.id 
inner join film on seance.id_film = film.id 
group by  cashier.price , film.name
order by best_selling_movie desc;