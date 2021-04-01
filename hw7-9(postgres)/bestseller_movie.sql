select m.id, m.title, m.slogan, sum(ticket_price) as movie_income
from movies m
         left join sessions s on s.movie_id = m.id
         left join tickets t on t.session_id = s.id
         left join prices p on p.ticket_id = t.id
where ticket_price is not null
group by m.id
order by movie_income desc limit 1;
