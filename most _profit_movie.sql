select
    s.movie_id,
    (select name from movies where id = s.movie_id) as movie_name,
    sum(t.cost)                                     as profit
from tickets t
     inner join shows s on s.id = t.show_id
where t.paid_at is not null
  and t.canceled_at is null
group by s.movie_id
order by profit desc
limit 1
;


