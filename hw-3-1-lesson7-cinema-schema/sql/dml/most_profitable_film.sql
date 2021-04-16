select sum(e.price) as amount_money, f.title
from films f
 left join events e ON e.film_id = f.id
 left join orders o on e.id = o.event_id
WHERE o.order_status_id = 2
GROUP BY f.title
ORDER BY amount_money
DESC
LIMIT 1;