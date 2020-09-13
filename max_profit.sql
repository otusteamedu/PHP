select count(t.id) * hm.cost as sum_cost, movie.title, movie.id
from movie
join hall_movie hm on movie.id = hm.movie_id
join tickets t on hm.id = t.hall_movie_id
group by movie.id,movie.title, hm.cost
order by sum_cost desc