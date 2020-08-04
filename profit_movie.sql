select m.id, m.title, sum(spp.price) as price
from booking b
         left join schedule s on b.id_schedule = s.id
         left join movie m on s.id_movie = m.id
         left join places p2 on p2.id = b.id_place
         left join schedule_place_price spp on spp.id_schedule = s.id AND p2.id_place_category = spp.id_place_category
group by m.id
order by price desc
limit 1;