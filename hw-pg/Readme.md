Запросы

самый прибыльный фильм

```
SELECT f.id AS film_id, f.title,  SUM(s.price)
FROM films AS f
INNER JOIN seances AS s ON s.film_id = f.id
INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY f.id, f.title
ORDER BY SUM(s.price) DESC
LIMIT 10
```

