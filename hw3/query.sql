SELECT f.title
FROM tickets t
JOIN shows s ON t.show_id = s.id_show
JOIN films f ON s.film_id = f.id_film
GROUP BY f.id_film
ORDER BY sum(s.price) DESC
LIMIT 1;
