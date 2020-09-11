select id, name, revenue from (
    select movies.id, movies.name, sum(tickets.price) as revenue from movies 
    inner join sessions on sessions.movie_id = movies.id
    inner join tickets on tickets.session_id = sessions.id
    group by movies.id
) as data 
order by revenue
limit 1
