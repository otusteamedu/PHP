select sum(basket.price) as total, movies.id as mid, movies.name as mname from basket
    left join sessions on basket.session_id = sessions.id 
    left join movies on sessions.movie_id = movies.id
group by mid
order by total desc
limit 1;