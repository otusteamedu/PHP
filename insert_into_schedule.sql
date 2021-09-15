-- До 100К
insert into schedule(movie_id, hall_id, start_time, price_id)
select
    distinct on (h.id, gs.n)
    m.id,
    h.id,
    gs.n,
    random_between(1,3)
from movies m,
     halls h,
     generate_series(1609940835, 1609965835) as gs(n);

insert into tickets(schedule_id, moviegoer_id, seat_id, number, status)
select distinct on (sh.id, mg.id, s.id)
    sh.id, mg.id , s.id, ROW_NUMBER() OVER () AS number, 1
from schedule sh,
     moviegoers mg, seats s limit 100000;