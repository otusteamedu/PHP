select movies.title,earnings.money
from movies
         left join (select sessions.movie_id,sum(sessions.price) as money
                    from orders
                             left join sessions
                                       on sessions.id = orders.session_id
                    group by sessions.movie_id) as earnings
                   on movies.id=earnings.movie_id
order by earnings.money desc
limit 1