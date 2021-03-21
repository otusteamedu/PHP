select movie.name, 
 sum(ticket.cost) as total_sum from movie 
left join schedule on schedule.movie_id = movie.id
left join ticket on ticket.schedule_id = schedule.id 
where ticket.id is not null group by movie.name order by total_sum desc limit 1;