select sum(o.price) as amount_money, f.name
from films f
         left join seances s ON s.film_id = f.id
         left join orders o on s.id = o.seance_id
GROUP BY f.name
HAVING sum(o.price) > 0;
