select 
	m.`name`, 
	sc.begin_time, 
	h.`name` as hall_name, 
	t.ticket_id, 
	se.`row` as seat_row, 
	se.num as seat_num,  
	ts.ticket_status, 
	sc.price 
from ticket t
join ticket_status ts on ts.ticket_status_id = t.ticket_status_id
join `schedule` sc on sc.schedule_id = t.schedule_id
join movie m on m.movie_id = sc.movie_id
join hall h on h.hall_id = sc.hall_id
join seat se on se.seat_id = t.seat_id;