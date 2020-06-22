SELECT mm.*
     , tmp.total
  FROM (
SELECT ss.movie_id
     , SUM(sp.price) AS total
  FROM public.orders_tickets AS ot
 INNER JOIN public.sessions AS ss
    ON ss.session_id = ot.session_id
 INNER JOIN public.halls_seats AS hs
    ON hs.hall_id = ss.hall_id
   AND hs.seat_id = ot.seat_id
 INNER JOIN public.sessions_prices AS sp
    ON sp.session_id = ot.session_id
   AND sp.seat_yd = hs.seat_yd
 GROUP BY ss.movie_id
 ORDER BY total DESC
 LIMIT 1
     ) AS tmp
 INNER JOIN public.movies AS mm
    ON mm.movie_id = tmp.movie_id