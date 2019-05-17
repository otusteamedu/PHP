select 
	m.`name`, 
	sum(sc.price) as profit 
from ticket t
join ticket_status ts on ts.ticket_status_id = t.ticket_status_id
join `schedule` sc on sc.schedule_id = t.schedule_id
join movie m on m.movie_id = sc.movie_id
where ts.ticket_status = 'sold'
group by m.`name`
order by profit desc;