SELECT 
  f.title, SUM(t.price) AS sales
FROM sessions s
JOIN tickets t ON t.session_id = s.id
JOIN prices p ON prices.id = s.price_id
JOIN films f ON f.id = s.film_id
GROUP BY s.id
ORDER BY sales DESC LIMIT 1