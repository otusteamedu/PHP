INSERT INTO `cinema`.`seat`
(`hall_id`,`num`,`row`)
-- FILL HALL_ID 1
select * 
from (select 1 as hall_id) h 
join (select 1 as num union select 2 union select 3 union select 4 union select 5 union select 6) n
join (select 1 as row union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8) r;
union
-- FILL HALL_ID 2
select * 
from (select 2 as hall_id) h 
join (select 1 as num union select 2 union select 3 union select 4 union select 5 union select 6 union select 7  union select 8) n
join (select 1 as row union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9  union select 10  union select 11  union select 12) r;
union
-- FILL HALL_ID 3
select * 
from (select 3 as hall_id) h 
join (select 1 as num union select 2 union select 3 union select 4 union select 5 union select 6 union select 7  union select 8  union select 9   union select 10) n
join (select 1 as row union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9 union select 10 union select 11 union select 12 union select 13 union select 14 union select 15 union select 16 union select 17 union select 18 union select 19 union select 20) r;
union
-- FILL HALL_ID 4
select * 
from (select 4 as hall_id) h 
join (select 1 as num union select 2 union select 3 union select 4 union select 5) n
join (select 1 as row union select 2 union select 3 union select 4) r;