select movies.id, movies.name, sum(sessions.price) as revenue from movies
inner join sessions on sessions.movie_id = movies.id
inner join tickets on tickets.session_id = sessions.id
group by movies.id
order by revenue desc
limit 1
