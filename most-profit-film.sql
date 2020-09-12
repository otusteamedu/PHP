SELECT name, SUM(s.price)
FROM films as f
         INNER JOIN sessions s on f.id = s.film_id
         INNER JOIN tickets t on s.id = t.sessions_id
WHERE t.sold = true
group by f.id
order by SUM(s.price) desc
limit 1;