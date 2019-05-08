select 
	m.`name`, 
	sc.begin_time, 
	h.`name` as hall_name, 
	t.ticket_id, 
	se.`row` as seat_row, 
	se.num as seat_num,  
	t.`status` as is_busy, 
	round(m.price*h.price_coefficient) as price 
from ticket t
join `schedule` sc on sc.schedule_id = t.schedule_id
join movie m on m.movie_id = sc.movie_id
join hall h on h.hall_id = sc.hall_id
join seat se on se.seat_id = t.seat_id;