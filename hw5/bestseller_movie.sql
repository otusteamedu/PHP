select m.id,
       m.title,
       (select sum(price) from tickets t where t.session_id = s.id group by t.session_id) as session_income
from movies m
         left join session_to_movie_pivot s_m_p on s_m_p.movie_id = m.id
         left join sessions s on s.id = s_m_p.session_id
order by session_income desc limit 1;