SELECT f.title
FROM tickets t
JOIN shows s ON t.show_id = s.id
JOIN films f ON s.film_id = f.id
GROUP BY f.id
ORDER BY sum(t.price) DESC
LIMIT 1;
