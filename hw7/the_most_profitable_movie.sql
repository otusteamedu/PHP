select count(movie_id) as counter,name from movies
    left join schedule s on movies.id = s.movie_id
    left join tickets t on s.id = t.schedule_id
    where t.id is not null
    group by movie_id,name order by counter desc
