Запросы

10 самых дорогих сеансов
```
SELECT id, film_id, date_start, price
FROM seances
ORDER BY price DESC
LIMIT 10
```

Фильмы, премьера в мире которых уже состоялась
```
SELECT f.title, fav.val_date 
FROM films AS f
INNER JOIN films_attr_values AS fav ON fav.film_id = f.id
WHERE fav.attr_id = 2 AND fav.val_date > NOW()
ORDER BY fav.val_date
```

Сеансы, на которые куплено 500+ билетов
```
WITH stats AS (
    SELECT s.id AS seance_id, COUNT(t.id) AS tickets_count
    FROM seances AS s
    INNER JOIN tickets AS t ON t.seance_id = s.id
    GROUP BY s.id
)
SELECT seance_id, tickets_count
FROM stats
WHERE tickets_count >= 500
ORDER BY tickets_count DESC
```

Самый прибыльный фильм
```
SELECT f.id AS film_id, f.title, SUM(s.price)
FROM films AS f
INNER JOIN seances AS s ON s.film_id = f.id
INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY f.id, f.title
ORDER BY SUM(s.price) DESC
LIMIT 10
```

