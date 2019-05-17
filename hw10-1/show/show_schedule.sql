select sc.begin_time, m.`name`, sc.price, h.`name` 
from `schedule` sc
join movie m on m.movie_id = sc.movie_id
join hall h on h.hall_id = sc.hall_id
order by sc.begin_time;