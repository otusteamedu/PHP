select mm.*
     , tmp.total
  from (
select ss.movie_id
     , SUM(ss.price) as total
  from public.orders as oo
 inner join public.sessions as ss
    on ss.session_id = oo.session_id
 group by ss.movie_id
 order by total desc
 limit 1
     ) as tmp
 inner join public.movies as mm
    on mm.movie_id = tmp.movie_id