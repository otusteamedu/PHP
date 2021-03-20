select movie.name, 
 sum(schedule.cost_base*seat.cost_factor) as total_sum from movie 
left join schedule on schedule.movie_id = movie.id
left join ticket on ticket.schedule_id = schedule.id 
left join room_schema on room_schema.id = ticket.room_schema_id 
left join seat on seat.id = room_schema.seat_id 
where ticket.id is not null group by movie.name order by total_sum desc limit 1