/**
 * Самый собираемый фильм в данной сети кинотеатров
 */
select m2.id, m2."name", sum(o.total) as total
from movie m2
     inner join "session" s on s.movie_id = m2.id
     inner join "order" o on o.session_id = s.id
group by m2.id
order by total desc
limit 1