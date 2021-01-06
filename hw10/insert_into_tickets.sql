-- До 100К, так как в schedule 10К и moviegoers 10;
insert into tickets(schedule_id, moviegoer_id, number)
    select distinct on (sh.id, mg.id)
           sh.id, mg.id , substr(md5(random()::text), 0, 5) || '-' || random_between(1,1000000)
from schedule sh,
    moviegoers mg;