select
    m.id,
    m.name,
    SUM(s.price) as price
from movies m
inner join sessions s on s.movie_id = m.id
inner join tickets t on t.session_id = s.id
group by m.id, m.name
order by price desc
limit 0, 1