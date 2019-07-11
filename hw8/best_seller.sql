SELECT 
   m.title as movie, 
   SUM(le.amount) AS total 
FROM
   ledger_entry AS le
JOIN 
   session AS s
ON
  le.session_id = s.id
JOIN 
  movie as m
ON
 s.movie_id = m.id
GROUP BY 
   m.title
ORDER BY
   total DESC
LIMIT 1;