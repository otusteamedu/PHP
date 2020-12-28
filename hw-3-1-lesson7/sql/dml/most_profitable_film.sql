select sum(o.price) as amount_money, f.title
from films f
         left join events e ON e.film_id = f.id
         left join orders o on e.id = o.event_id
GROUP BY f.title
HAVING sum(o.price) > 0
ORDER BY amount_money
DESC
LIMIT 3;