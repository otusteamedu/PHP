select 
	m.`name`, 
	sum(round(m.price*h.price_coefficient)) as profit 
from ticket t
join `schedule` sc on sc.schedule_id = t.schedule_id
join movie m on m.movie_id = sc.movie_id
join hall h on h.hall_id = sc.hall_id
where t.`status` = 1
group by m.`name`
order by profit desc;