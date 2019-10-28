SELECT name FROM clients where name LIKE '_%' ORDER by name DESC ;

/*
"Sort  (cost=64823.83..66073.70 rows=499950 width=11) (actual time=1215.178..1580.365 rows=500000 loops=1)"
"  Sort Key: name DESC"
"  Sort Method: external merge  Disk: 10304kB"
"  ->  Seq Scan on clients  (cost=0.00..8953.00 rows=499950 width=11) (actual time=0.036..99.734 rows=500000 loops=1)"
"        Filter: ((name)::text ~~ '_%'::text)"
"Planning Time: 0.494 ms"
"Execution Time: 1601.848 ms"

*/

CREATE INDEX idx_clients_name ON clients (name);
/*
"Index Only Scan Backward using idx_clients_name on clients  (cost=0.42..27274.42 rows=499950 width=11) (actual time=0.073..473.578 rows=500000 loops=1)"
"  Filter: ((name)::text ~~ '_%'::text)"
"  Heap Fetches: 500000"
"Planning Time: 0.333 ms"
"Execution Time: 495.832 ms"
/* время выполнения уменьшилось на 1100 ms */
*/


SELECT datetime FROM seance where datetime BETWEEN '2019-10-13 07:52:00' AND '2020-03-24 11:41:42';

/*
"Seq Scan on seance  (cost=0.00..13.25 rows=550 width=8) (actual time=0.015..0.090 rows=550 loops=1)"
"  Filter: ((datetime >= '2019-10-13 07:52:00'::timestamp without time zone) AND (datetime <= '2020-03-24 11:41:42'::timestamp without time zone))"
"Planning Time: 0.059 ms"
"Execution Time: 0.121 ms"


*/

CREATE INDEX idx_seance_datetime ON seance(datetime);
/*

explain analyze SELECT datetime FROM seance where datetime BETWEEN '2019-10-13 07:52:00' AND '2020-03-24 11:41:42';

"Seq Scan on seance  (cost=0.00..13.25 rows=550 width=8) (actual time=0.010..0.080 rows=550 loops=1)"
"  Filter: ((datetime >= '2019-10-13 07:52:00'::timestamp without time zone) AND (datetime <= '2020-03-24 11:41:42'::timestamp without time zone))"
"Planning Time: 0.181 ms"
"Execution Time: 0.110 ms"
/* время выполнения не изменилось */
*/

explain analyze SELECT sum(price_tickets) FROM tickets WHERE price_tickets >350 ;

/*
"Finalize Aggregate  (cost=124934.74..124934.75 rows=1 width=32) (actual time=4633.230..4633.230 rows=1 loops=1)"
"  ->  Gather  (cost=124934.52..124934.73 rows=2 width=32) (actual time=4632.955..5071.810 rows=3 loops=1)"
"        Workers Planned: 2"
"        Workers Launched: 2"
"        ->  Partial Aggregate  (cost=123934.52..123934.53 rows=1 width=32) (actual time=4496.433..4496.433 rows=1 loops=3)"
"              ->  Parallel Seq Scan on tickets  (cost=0.00..115778.93 rows=3262235 width=5) (actual time=26.920..3575.843 rows=2614824 loops=3)"
"                    Filter: (price_tickets > '350'::numeric)"
"                    Rows Removed by Filter: 718510"
"Planning Time: 6.693 ms"
"JIT:"
"  Functions: 17"
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 30.802 ms, Inlining 0.000 ms, Optimization 1.137 ms, Emission 75.551 ms, Total 107.490 ms"
"Execution Time: 5329.455 ms"


*/




CREATE INDEX idx_price_tickets ON tickets(price_tickets);
/*
"Finalize Aggregate  (cost=124934.05..124934.06 rows=1 width=32) (actual time=3133.380..3133.380 rows=1 loops=1)"
"  ->  Gather  (cost=124933.83..124934.04 rows=2 width=32) (actual time=3131.187..3142.072 rows=3 loops=1)"
"        Workers Planned: 2"
"        Workers Launched: 2"
"        ->  Partial Aggregate  (cost=123933.83..123933.84 rows=1 width=32) (actual time=3038.073..3038.073 rows=1 loops=3)"
"              ->  Parallel Seq Scan on tickets  (cost=0.00..115778.33 rows=3262198 width=5) (actual time=17.286..2194.105 rows=2614824 loops=3)"
"                    Filter: (price_tickets > '350'::numeric)"
"                    Rows Removed by Filter: 718510"
"Planning Time: 0.107 ms"
"JIT:"
"  Functions: 17"
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 8.247 ms, Inlining 0.000 ms, Optimization 7.230 ms, Emission 42.889 ms, Total 58.366 ms"
"Execution Time: 3142.935 ms"
/* время выполнения уменьшилось на  5000 ms */
*/


select
now_date.film_name, 
now_date.attr_name as now_act_task ,
forward_date.attr_name as interval_days_20_act_task 
from (select film_name, date_val , attr_name  from attributes_value
	  join film on film.id=attributes_value.id_film
	  join attributes on attributes_value.id_attributes=attributes.id
	  where attributes_value.date_val>= current_date) as now_date
	  full outer join (
	  select film_name, date_val , attr_name from attributes_value
	  join film on film.id=attributes_value.id_film
		   join attributes on attributes_value.id_attributes=attributes.id
	  where attributes_value.date_val>= current_date+interval '20 days') as forward_date   
	  on  now_date.film_name=forward_date.film_name
/*

"Hash Full Join  (cost=142.65..430.47 rows=22482 width=33) (actual time=0.347..0.371 rows=28 loops=1)"
"  Hash Cond: ((film.film_name)::text = (film_1.film_name)::text)"
"  ->  Hash Join  (cost=50.67..83.17 rows=1109 width=22) (actual time=0.052..0.066 rows=20 loops=1)"
"        Hash Cond: (attributes_value.id_attributes = attributes.id)"
"        ->  Hash Join  (cost=1.74..31.33 rows=1109 width=15) (actual time=0.032..0.042 rows=20 loops=1)"
"              Hash Cond: (attributes_value.id_film = film.id)"
"              ->  Seq Scan on attributes_value  (cost=0.00..26.65 rows=1109 width=8) (actual time=0.004..0.009 rows=20 loops=1)"
"                    Filter: (date_val >= CURRENT_DATE)"
"              ->  Hash  (cost=1.33..1.33 rows=33 width=15) (actual time=0.014..0.014 rows=33 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"                    ->  Seq Scan on film  (cost=0.00..1.33 rows=33 width=15) (actual time=0.003..0.007 rows=33 loops=1)"
"        ->  Hash  (cost=27.30..27.30 rows=1730 width=15) (actual time=0.010..0.010 rows=20 loops=1)"
"              Buckets: 2048  Batches: 1  Memory Usage: 17kB"
"              ->  Seq Scan on attributes  (cost=0.00..27.30 rows=1730 width=15) (actual time=0.003..0.005 rows=20 loops=1)"
"  ->  Hash  (cost=83.62..83.62 rows=669 width=22) (actual time=0.269..0.270 rows=20 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"        ->  Hash Join  (cost=50.67..83.62 rows=669 width=22) (actual time=0.240..0.260 rows=20 loops=1)"
"              Hash Cond: (attributes_value_1.id_attributes = attributes_1.id)"
"              ->  Hash Join  (cost=1.74..32.93 rows=669 width=15) (actual time=0.208..0.224 rows=20 loops=1)"
"                    Hash Cond: (attributes_value_1.id_film = film_1.id)"
"                    ->  Seq Scan on attributes_value attributes_value_1  (cost=0.00..29.43 rows=669 width=8) (actual time=0.167..0.176 rows=20 loops=1)"
"                          Filter: (date_val >= (CURRENT_DATE + '20 days'::interval))"
"                    ->  Hash  (cost=1.33..1.33 rows=33 width=15) (actual time=0.020..0.020 rows=33 loops=1)"
"                          Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"                          ->  Seq Scan on film film_1  (cost=0.00..1.33 rows=33 width=15) (actual time=0.009..0.012 rows=33 loops=1)"
"              ->  Hash  (cost=27.30..27.30 rows=1730 width=15) (actual time=0.019..0.019 rows=20 loops=1)"
"                    Buckets: 2048  Batches: 1  Memory Usage: 17kB"
"                    ->  Seq Scan on attributes attributes_1  (cost=0.00..27.30 rows=1730 width=15) (actual time=0.005..0.007 rows=20 loops=1)"
"Planning Time: 14.934 ms"
"Execution Time: 0.468 ms"



*/

/*
"Hash Full Join  (cost=7.98..9.56 rows=20 width=33) (actual time=0.108..0.131 rows=28 loops=1)"
"  Hash Cond: ((film.film_name)::text = (film_1.film_name)::text)"
"  ->  Hash Join  (cost=3.19..4.62 rows=20 width=22) (actual time=0.032..0.045 rows=20 loops=1)"
"        Hash Cond: (attributes_value.id_attributes = attributes.id)"
"        ->  Hash Join  (cost=1.74..3.11 rows=20 width=15) (actual time=0.018..0.028 rows=20 loops=1)"
"              Hash Cond: (attributes_value.id_film = film.id)"
"              ->  Seq Scan on attributes_value  (cost=0.00..1.30 rows=20 width=8) (actual time=0.003..0.008 rows=20 loops=1)"
"                    Filter: (date_val >= CURRENT_DATE)"
"              ->  Hash  (cost=1.33..1.33 rows=33 width=15) (actual time=0.012..0.012 rows=33 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"                    ->  Seq Scan on film  (cost=0.00..1.33 rows=33 width=15) (actual time=0.003..0.007 rows=33 loops=1)"
"        ->  Hash  (cost=1.20..1.20 rows=20 width=15) (actual time=0.009..0.009 rows=20 loops=1)"
"              Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"              ->  Seq Scan on attributes  (cost=0.00..1.20 rows=20 width=15) (actual time=0.002..0.005 rows=20 loops=1)"
"  ->  Hash  (cost=4.62..4.62 rows=13 width=22) (actual time=0.070..0.070 rows=20 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"        ->  Hash Join  (cost=3.19..4.62 rows=13 width=22) (actual time=0.047..0.063 rows=20 loops=1)"
"              Hash Cond: (attributes_value_1.id_attributes = attributes_1.id)"
"              ->  Hash Join  (cost=1.74..3.13 rows=13 width=15) (actual time=0.023..0.034 rows=20 loops=1)"
"                    Hash Cond: (attributes_value_1.id_film = film_1.id)"
"                    ->  Seq Scan on attributes_value attributes_value_1  (cost=0.00..1.35 rows=13 width=8) (actual time=0.007..0.013 rows=20 loops=1)"
"                          Filter: (date_val >= (CURRENT_DATE + '20 days'::interval))"
"                    ->  Hash  (cost=1.33..1.33 rows=33 width=15) (actual time=0.010..0.010 rows=33 loops=1)"
"                          Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"                          ->  Seq Scan on film film_1  (cost=0.00..1.33 rows=33 width=15) (actual time=0.003..0.005 rows=33 loops=1)"
"              ->  Hash  (cost=1.20..1.20 rows=20 width=15) (actual time=0.019..0.019 rows=20 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on attributes attributes_1  (cost=0.00..1.20 rows=20 width=15) (actual time=0.010..0.012 rows=20 loops=1)"
"Planning Time: 0.644 ms"
"Execution Time: 0.184 ms"
/* время выполнения уменьшилось на  0.450 ms */
*/


select
film.film_name,
attributes_types.type_name,
attributes_value.text_val,
attributes_value.boolean_val ,
attributes_value.date_val ,
attributes_value.realis_number_val ,
attributes_value.float_number_val,
attributes.attr_name
from film
inner join attributes_value
on film.id=attributes_value.id_film
inner join attributes
on attributes_value.id_attributes=attributes.id
inner join attributes_types
on attributes.id_type=attributes_types.id




/*
"Hash Join  (cost=103.19..133.08 rows=1110 width=66) (actual time=0.066..0.082 rows=20 loops=1)"
"  Hash Cond: (attributes.id_type = attributes_types.id)"
"  ->  Hash Join  (cost=50.67..77.63 rows=1110 width=59) (actual time=0.044..0.056 rows=20 loops=1)"
"        Hash Cond: (attributes_value.id_attributes = attributes.id)"
"        ->  Hash Join  (cost=1.74..25.78 rows=1110 width=48) (actual time=0.019..0.027 rows=20 loops=1)"
"              Hash Cond: (attributes_value.id_film = film.id)"
"              ->  Seq Scan on attributes_value  (cost=0.00..21.10 rows=1110 width=41) (actual time=0.004..0.005 rows=20 loops=1)"
"              ->  Hash  (cost=1.33..1.33 rows=33 width=15) (actual time=0.010..0.010 rows=33 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"                    ->  Seq Scan on film  (cost=0.00..1.33 rows=33 width=15) (actual time=0.003..0.006 rows=33 loops=1)"
"        ->  Hash  (cost=27.30..27.30 rows=1730 width=19) (actual time=0.010..0.010 rows=20 loops=1)"
"              Buckets: 2048  Batches: 1  Memory Usage: 18kB"
"              ->  Seq Scan on attributes  (cost=0.00..27.30 rows=1730 width=19) (actual time=0.003..0.005 rows=20 loops=1)"
"  ->  Hash  (cost=28.90..28.90 rows=1890 width=15) (actual time=0.015..0.015 rows=10 loops=1)"
"        Buckets: 2048  Batches: 1  Memory Usage: 17kB"
"        ->  Seq Scan on attributes_types  (cost=0.00..28.90 rows=1890 width=15) (actual time=0.010..0.011 rows=10 loops=1)"
"Planning Time: 0.961 ms"
"Execution Time: 0.124 ms"

*/

/*
"Hash Join  (cost=4.64..50.69 rows=20 width=66) (actual time=0.058..0.072 rows=20 loops=1)"
"  Hash Cond: (attributes_value.id_film = film.id)"
"  ->  Hash Join  (cost=2.90..48.89 rows=20 width=59) (actual time=0.033..0.043 rows=20 loops=1)"
"        Hash Cond: (attributes.id = attributes_value.id_attributes)"
"        ->  Hash Join  (cost=1.45..47.09 rows=20 width=26) (actual time=0.018..0.023 rows=20 loops=1)"
"              Hash Cond: (attributes_types.id = attributes.id_type)"
"              ->  Seq Scan on attributes_types  (cost=0.00..28.90 rows=1890 width=15) (actual time=0.002..0.003 rows=10 loops=1)"
"              ->  Hash  (cost=1.20..1.20 rows=20 width=19) (actual time=0.011..0.011 rows=20 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"                    ->  Seq Scan on attributes  (cost=0.00..1.20 rows=20 width=19) (actual time=0.003..0.006 rows=20 loops=1)"
"        ->  Hash  (cost=1.20..1.20 rows=20 width=41) (actual time=0.012..0.012 rows=20 loops=1)"
"              Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"              ->  Seq Scan on attributes_value  (cost=0.00..1.20 rows=20 width=41) (actual time=0.004..0.007 rows=20 loops=1)"
"  ->  Hash  (cost=1.33..1.33 rows=33 width=15) (actual time=0.020..0.020 rows=33 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"        ->  Seq Scan on film  (cost=0.00..1.33 rows=33 width=15) (actual time=0.009..0.012 rows=33 loops=1)"
"Planning Time: 0.397 ms"
"Execution Time: 0.113 ms"
/* время выполнения осталось такимже */

*/

explain analyze SELECT count(tickets.id)*tickets.price_tickets as best_selling_movie, film.film_name as film_name
FROM public.tickets 
inner join seance on tickets.id_seance = seance.id 
inner join film on seance.id_film = film.id 
group by   film_name , price_tickets 
having count(tickets.id)=1  
order by best_selling_movie desc;

/*
"Sort  (cost=166609.06..166609.35 rows=116 width=59) (actual time=12996.440..12996.440 rows=0 loops=1)"
"  Sort Key: (((count(tickets.id))::numeric * tickets.price_tickets)) DESC"
"  Sort Method: quicksort  Memory: 25kB"
"  ->  Finalize HashAggregate  (cost=166315.34..166605.08 rows=116 width=59) (actual time=12996.430..12996.430 rows=0 loops=1)"
"        Group Key: film.film_name, tickets.price_tickets"
"        Filter: (count(tickets.id) = 1)"
"        Rows Removed by Filter: 23133"
"        ->  Gather  (cost=160994.75..165852.68 rows=46266 width=24) (actual time=12908.695..12957.096 rows=69399 loops=1)"
"              Workers Planned: 2"
"              Workers Launched: 2"
"              ->  Partial HashAggregate  (cost=159994.75..160226.08 rows=23133 width=24) (actual time=12771.748..12778.399 rows=23133 loops=3)"
"                    Group Key: film.film_name, tickets.price_tickets"
"                    ->  Hash Join  (cost=19.12..128744.74 rows=4166667 width=20) (actual time=73.031..7001.619 rows=3333333 loops=3)"
"                          Hash Cond: (seance.id_film = film.id)"
"                          ->  Hash Join  (cost=17.38..116400.83 rows=4166667 width=13) (actual time=1.527..4630.975 rows=3333333 loops=3)"
"                                Hash Cond: (tickets.id_seance = seance.id)"
"                                ->  Parallel Seq Scan on tickets  (cost=0.00..105361.67 rows=4166667 width=13) (actual time=0.039..1502.749 rows=3333333 loops=3)"
"                                ->  Hash  (cost=10.50..10.50 rows=550 width=8) (actual time=1.474..1.474 rows=550 loops=3)"
"                                      Buckets: 1024  Batches: 1  Memory Usage: 30kB"
"                                      ->  Seq Scan on seance  (cost=0.00..10.50 rows=550 width=8) (actual time=0.022..1.409 rows=550 loops=3)"
"                          ->  Hash  (cost=1.33..1.33 rows=33 width=15) (actual time=71.438..71.438 rows=33 loops=3)"
"                                Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"                                ->  Seq Scan on film  (cost=0.00..1.33 rows=33 width=15) (actual time=71.409..71.417 rows=33 loops=3)"
"Planning Time: 16.025 ms"
"JIT:"
"  Functions: 78"
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 39.272 ms, Inlining 0.000 ms, Optimization 2.185 ms, Emission 205.427 ms, Total 246.885 ms"
"Execution Time: 12999.965 ms"




*/
/*
"Sort  (cost=166609.06..166609.35 rows=116 width=59) (actual time=13094.209..13094.209 rows=0 loops=1)"
"  Sort Key: (((count(tickets.id))::numeric * tickets.price_tickets)) DESC"
"  Sort Method: quicksort  Memory: 25kB"
"  ->  Finalize HashAggregate  (cost=166315.34..166605.08 rows=116 width=59) (actual time=13094.202..13094.202 rows=0 loops=1)"
"        Group Key: film.film_name, tickets.price_tickets"
"        Filter: (count(tickets.id) = 1)"
"        Rows Removed by Filter: 23133"
"        ->  Gather  (cost=160994.75..165852.68 rows=46266 width=24) (actual time=13006.558..13053.792 rows=69399 loops=1)"
"              Workers Planned: 2"
"              Workers Launched: 2"
"              ->  Partial HashAggregate  (cost=159994.75..160226.08 rows=23133 width=24) (actual time=12889.700..12895.758 rows=23133 loops=3)"
"                    Group Key: film.film_name, tickets.price_tickets"
"                    ->  Hash Join  (cost=19.12..128744.74 rows=4166667 width=20) (actual time=75.945..7033.539 rows=3333333 loops=3)"
"                          Hash Cond: (seance.id_film = film.id)"
"                          ->  Hash Join  (cost=17.38..116400.83 rows=4166667 width=13) (actual time=0.467..4683.198 rows=3333333 loops=3)"
"                                Hash Cond: (tickets.id_seance = seance.id)"
"                                ->  Parallel Seq Scan on tickets  (cost=0.00..105361.67 rows=4166667 width=13) (actual time=0.307..1532.317 rows=3333333 loops=3)"
"                                ->  Hash  (cost=10.50..10.50 rows=550 width=8) (actual time=0.148..0.148 rows=550 loops=3)"
"                                      Buckets: 1024  Batches: 1  Memory Usage: 30kB"
"                                      ->  Seq Scan on seance  (cost=0.00..10.50 rows=550 width=8) (actual time=0.021..0.085 rows=550 loops=3)"
"                          ->  Hash  (cost=1.33..1.33 rows=33 width=15) (actual time=75.443..75.443 rows=33 loops=3)"
"                                Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"                                ->  Seq Scan on film  (cost=0.00..1.33 rows=33 width=15) (actual time=75.415..75.423 rows=33 loops=3)"
"Planning Time: 0.490 ms"
"JIT:"
"  Functions: 78"
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 13.414 ms, Inlining 0.000 ms, Optimization 2.598 ms, Emission 219.458 ms, Total 235.469 ms"
"Execution Time: 13097.259 ms"
/* время выполнения осталось такимже */
*/


CREATE INDEX idx_id_seance ON tickets(id_seance);
CREATE INDEX idx_id_film ON  seance(id_film );
CREATE INDEX idx_tickets ON tickets(id);




CREATE INDEX idx_film_name ON film(film_name);
CREATE INDEX idx_attributes ON attributes(id);
CREATE INDEX idx_date ON attributes_value(date_val);



CREATE INDEX idx_filmId ON film(id);
CREATE INDEX idx_attributes_value_Id_attributes ON  attributes_value(id_attributes);
CREATE INDEX idx_attributes_id_type ON  attributes(id_type);