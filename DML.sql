SELECT s.title, s.price * COUNT(t.id) AS sales
  FROM sessions s
  JOIN tickets t ON t.session_id = s.id
  GROUP BY s.id
  ORDER BY sales DESC LIMIT 1