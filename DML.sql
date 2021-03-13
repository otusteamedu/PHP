SELECT 
  f.title, SUM(t.price) AS sales
FROM tickets t
JOIN films f ON f.id = t.film_id
GROUP BY f.title
ORDER BY sales DESC LIMIT 1