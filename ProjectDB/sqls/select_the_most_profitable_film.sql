SELECT f.name, COUNT (t.id) as tickets_count_purchase, SUM(t.price) as yield FROM public.films AS f
JOIN public.seances AS s ON f.id = s.film_id
JOIN public.tickets AS t ON s.id = t.seance_id
GROUP BY f.id
ORDER BY yield DESC
LIMIT 1