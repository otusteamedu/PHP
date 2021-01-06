-- до 10К
insert into schedule(movie_id, hall_id, start_time, moviegoer_type_id, price)
select 
    distinct on (h.id, gs.n) 
        m.id,
        h.id,
        gs.n,
        mt.id,
        random_between(500, 2000)
from movies m,
     halls h,
     movigoer_types mt,
     generate_series(1609927083, 1609929583) as gs(n); -- generate_series использован еще и как время. 
     
    -- Между 1 и 2 аргументом разница в 2500, так как там по 4 выводит. В итоге 10К записей

-- До 100К
insert into schedule(movie_id, hall_id, start_time, moviegoer_type_id, price)
select 
    distinct on (h.id, gs.n) 
        m.id,
        h.id,
        gs.n,
        mt.id,
        random_between(500, 2000)
from movies m,
     halls h,
     movigoer_types mt,
     generate_series(1609940835, 1609965835) as gs(n); 