select m.id, m.title, sum(s.price) as price
from booking b
         left join schedule s on b.id_schedule = s.id
         left join movie m on s.id_movie = m.id
group by m.id
order by price desc
limit 1;