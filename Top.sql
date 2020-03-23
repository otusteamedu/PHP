SELECT
  f.name,
  s.id_film,
  id_film,
  SUM(t.price) as sum
FROM tickets t
  LEFT JOIN seances s ON s.id = t.id_seance
  LEFT JOIN films f ON f.id = s.id_film
WHERE t.is_paid = true
GROUP BY s.id_film, f.name
ORDER BY sum desc
LIMIT 1