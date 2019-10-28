
SELECT name FROM clients where name LIKE '_%' ORDER by name DESC ;


/*

explain analyze SELECT name FROM clients where name LIKE '_%' ORDER by name DESC ;
Sort  (cost=397.69..410.19 rows=5000 width=11) (actual time=7.418..7.711 rows=5000 loops=1)
  Sort Key: name DESC
    Sort Method: quicksort  Memory: 427kB
	  ->  Seq Scan on clients  (cost=0.00..90.50 rows=5000 width=11) (actual time=0.016..0.819 rows=5000 loops=1)
	          Filter: ((name)::text ~~ '_%'::text)
			  Planning Time: 0.073 ms
			  Execution Time: 7.907 ms

*/

SELECT datetime FROM seance where datetime BETWEEN '2019-12-13 07:52:00' AND '2020-01-24 11:41:42';
/*
  explain analyze  SELECT datetime FROM seance where datetime BETWEEN '2019-12-13 07:52:00' AND '2020-01-24 11:41:42';
Seq Scan on seance  (cost=0.00..1.82 rows=55 width=8) (actual time=0.015..0.022 rows=55 loops=1)
  Filter: ((datetime >= '2019-10-27 07:52:00'::timestamp without time zone) AND (datetime <= '2020-05-24 11:41:42'::timestamp without time zone))
  Planning Time: 0.072 ms
  Execution Time: 0.038 ms


*/

explain analyze SELECT sum(price_tickets) FROM tickets WHERE price_tickets >350 ;
/*
explain analyze SELECT sum(price_tickets) FROM tickets WHERE price_tickets >350 ;
Aggregate  (cost=208.65..208.66 rows=1 width=32) (actual time=2.444..2.445 rows=1 loops=1)
  ->  Seq Scan on tickets  (cost=0.00..189.00 rows=7860 width=5) (actual time=0.013..1.619 rows=7851 loops=1)
          Filter: (price_tickets > '350'::numeric)
		          Rows Removed by Filter: 2149
				  Planning Time: 0.072 ms
				  Execution Time: 2.464 ms
				  

*/
CREATE INDEX idx_clients_name ON clients (name);
/*
explain analyze SELECT name FROM clients where name LIKE '_%' ORDER by name DESC ;
Index Only Scan Backward using idx_clients_name on clients  (cost=0.28..287.74 rows=5000 width=11) (actual time=0.047..2.725 rows=5000 loops=1)
  Filter: ((name)::text ~~ '_%'::text)
    Heap Fetches: 5000
	Planning Time: 0.195 ms
	Execution Time: 2.909 ms
	/* Удалось уменьшить время выполнения на 5.000 ms */
*/
CREATE INDEX idx_seance_datetime ON seance(datetime);
/*
 explain analyze  SELECT datetime FROM seance where datetime BETWEEN '2019-12-13 07:52:00' AND '2020-01-24 11:41:42';
Seq Scan on seance  (cost=0.00..1.82 rows=55 width=8) (actual time=0.013..0.019 rows=55 loops=1)
  Filter: ((datetime >= '2019-10-27 07:52:00'::timestamp without time zone) AND (datetime <= '2020-05-24 11:41:42'::timestamp without time zone))
  Planning Time: 0.268 ms
  Execution Time: 0.036 ms
  /* время выполнения на осталось таким же */

*/

CREATE INDEX idx_price_tickets ON tickets(price_tickets);
/*
explain analyze SELECT sum(price_tickets) FROM tickets WHERE price_tickets >350 ;
Aggregate  (cost=208.65..208.66 rows=1 width=32) (actual time=2.516..2.517 rows=1 loops=1)
  ->  Seq Scan on tickets  (cost=0.00..189.00 rows=7860 width=5) (actual time=0.020..1.692 rows=7851 loops=1)
          Filter: (price_tickets > '350'::numeric)
		          Rows Removed by Filter: 2149
				  Planning Time: 0.140 ms
				  Execution Time: 2.545 ms
				  /* время выполнения увеличилось на 0,100 */
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
"Hash Full Join  (cost=7.00..8.75 rows=24 width=33) (actual time=0.103..0.124 rows=30 loops=1)"
"  Hash Cond: ((film.film_name)::text = (film_1.film_name)::text)"
"  ->  Hash Join  (cost=2.70..4.14 rows=20 width=22) (actual time=0.036..0.048 rows=20 loops=1)"
"        Hash Cond: (attributes_value.id_attributes = attributes.id)"
"        ->  Hash Join  (cost=1.25..2.62 rows=20 width=15) (actual time=0.013..0.021 rows=20 loops=1)"
"              Hash Cond: (attributes_value.id_film = film.id)"
"              ->  Seq Scan on attributes_value  (cost=0.00..1.30 rows=20 width=8) (actual time=0.002..0.007 rows=20 loops=1)"
"                    Filter: (date_val >= CURRENT_DATE)"
"              ->  Hash  (cost=1.11..1.11 rows=11 width=15) (actual time=0.006..0.006 rows=11 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on film  (cost=0.00..1.11 rows=11 width=15) (actual time=0.002..0.003 rows=11 loops=1)"
"        ->  Hash  (cost=1.20..1.20 rows=20 width=15) (actual time=0.008..0.008 rows=20 loops=1)"
"              Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"              ->  Seq Scan on attributes  (cost=0.00..1.20 rows=20 width=15) (actual time=0.003..0.005 rows=20 loops=1)"
"  ->  Hash  (cost=4.14..4.14 rows=13 width=22) (actual time=0.063..0.063 rows=12 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"        ->  Hash Join  (cost=2.70..4.14 rows=13 width=22) (actual time=0.048..0.060 rows=12 loops=1)"
"              Hash Cond: (attributes_value_1.id_attributes = attributes_1.id)"
"              ->  Hash Join  (cost=1.25..2.64 rows=13 width=15) (actual time=0.017..0.026 rows=12 loops=1)"
"                    Hash Cond: (attributes_value_1.id_film = film_1.id)"
"                    ->  Seq Scan on attributes_value attributes_value_1  (cost=0.00..1.35 rows=13 width=8) (actual time=0.008..0.014 rows=12 loops=1)"
"                          Filter: (date_val >= (CURRENT_DATE + '20 days'::interval))"
"                          Rows Removed by Filter: 8"
"                    ->  Hash  (cost=1.11..1.11 rows=11 width=15) (actual time=0.005..0.005 rows=11 loops=1)"
"                          Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                          ->  Seq Scan on film film_1  (cost=0.00..1.11 rows=11 width=15) (actual time=0.002..0.003 rows=11 loops=1)"
"              ->  Hash  (cost=1.20..1.20 rows=20 width=15) (actual time=0.016..0.016 rows=20 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on attributes attributes_1  (cost=0.00..1.20 rows=20 width=15) (actual time=0.009..0.011 rows=20 loops=1)"
"Planning Time: 0.490 ms"
"Execution Time: 0.166 ms"
*/

/*
"Hash Full Join  (cost=7.00..8.75 rows=24 width=33) (actual time=0.074..0.095 rows=30 loops=1)"
"  Hash Cond: ((film.film_name)::text = (film_1.film_name)::text)"
"  ->  Hash Join  (cost=2.70..4.14 rows=20 width=22) (actual time=0.021..0.032 rows=20 loops=1)"
"        Hash Cond: (attributes_value.id_attributes = attributes.id)"
"        ->  Hash Join  (cost=1.25..2.62 rows=20 width=15) (actual time=0.011..0.019 rows=20 loops=1)"
"              Hash Cond: (attributes_value.id_film = film.id)"
"              ->  Seq Scan on attributes_value  (cost=0.00..1.30 rows=20 width=8) (actual time=0.002..0.007 rows=20 loops=1)"
"                    Filter: (date_val >= CURRENT_DATE)"
"              ->  Hash  (cost=1.11..1.11 rows=11 width=15) (actual time=0.005..0.005 rows=11 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on film  (cost=0.00..1.11 rows=11 width=15) (actual time=0.002..0.003 rows=11 loops=1)"
"        ->  Hash  (cost=1.20..1.20 rows=20 width=15) (actual time=0.008..0.008 rows=20 loops=1)"
"              Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"              ->  Seq Scan on attributes  (cost=0.00..1.20 rows=20 width=15) (actual time=0.002..0.004 rows=20 loops=1)"
"  ->  Hash  (cost=4.14..4.14 rows=13 width=22) (actual time=0.049..0.049 rows=12 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"        ->  Hash Join  (cost=2.70..4.14 rows=13 width=22) (actual time=0.034..0.045 rows=12 loops=1)"
"              Hash Cond: (attributes_value_1.id_attributes = attributes_1.id)"
"              ->  Hash Join  (cost=1.25..2.64 rows=13 width=15) (actual time=0.016..0.024 rows=12 loops=1)"
"                    Hash Cond: (attributes_value_1.id_film = film_1.id)"
"                    ->  Seq Scan on attributes_value attributes_value_1  (cost=0.00..1.35 rows=13 width=8) (actual time=0.007..0.012 rows=12 loops=1)"
"                          Filter: (date_val >= (CURRENT_DATE + '20 days'::interval))"
"                          Rows Removed by Filter: 8"
"                    ->  Hash  (cost=1.11..1.11 rows=11 width=15) (actual time=0.005..0.005 rows=11 loops=1)"
"                          Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                          ->  Seq Scan on film film_1  (cost=0.00..1.11 rows=11 width=15) (actual time=0.002..0.003 rows=11 loops=1)"
"              ->  Hash  (cost=1.20..1.20 rows=20 width=15) (actual time=0.015..0.015 rows=20 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on attributes attributes_1  (cost=0.00..1.20 rows=20 width=15) (actual time=0.006..0.010 rows=20 loops=1)"
"Planning Time: 1.084 ms"
"Execution Time: 0.140 ms"
/* время выполнения увеличилось на несколько  ms */


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
"Hash Join  (cost=3.92..5.34 rows=20 width=66) (actual time=0.059..0.078 rows=20 loops=1)"
"  Hash Cond: (attributes.id_type = attributes_types.id)"
"  ->  Hash Join  (cost=2.70..4.04 rows=20 width=59) (actual time=0.033..0.046 rows=20 loops=1)"
"        Hash Cond: (attributes_value.id_attributes = attributes.id)"
"        ->  Hash Join  (cost=1.25..2.52 rows=20 width=48) (actual time=0.018..0.027 rows=20 loops=1)"
"              Hash Cond: (attributes_value.id_film = film.id)"
"              ->  Seq Scan on attributes_value  (cost=0.00..1.20 rows=20 width=41) (actual time=0.004..0.007 rows=20 loops=1)"
"              ->  Hash  (cost=1.11..1.11 rows=11 width=15) (actual time=0.008..0.008 rows=11 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on film  (cost=0.00..1.11 rows=11 width=15) (actual time=0.004..0.005 rows=11 loops=1)"
"        ->  Hash  (cost=1.20..1.20 rows=20 width=19) (actual time=0.010..0.010 rows=20 loops=1)"
"              Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"              ->  Seq Scan on attributes  (cost=0.00..1.20 rows=20 width=19) (actual time=0.004..0.006 rows=20 loops=1)"
"  ->  Hash  (cost=1.10..1.10 rows=10 width=15) (actual time=0.020..0.020 rows=10 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"        ->  Seq Scan on attributes_types  (cost=0.00..1.10 rows=10 width=15) (actual time=0.014..0.016 rows=10 loops=1)"
"Planning Time: 0.576 ms"
"Execution Time: 0.133 ms"


*/
/*
"Hash Join  (cost=3.92..5.34 rows=20 width=66) (actual time=0.096..0.110 rows=20 loops=1)"
"  Hash Cond: (attributes.id_type = attributes_types.id)"
"  ->  Hash Join  (cost=2.70..4.04 rows=20 width=59) (actual time=0.079..0.089 rows=20 loops=1)"
"        Hash Cond: (attributes_value.id_attributes = attributes.id)"
"        ->  Hash Join  (cost=1.25..2.52 rows=20 width=48) (actual time=0.066..0.073 rows=20 loops=1)"
"              Hash Cond: (attributes_value.id_film = film.id)"
"              ->  Seq Scan on attributes_value  (cost=0.00..1.20 rows=20 width=41) (actual time=0.003..0.004 rows=20 loops=1)"
"              ->  Hash  (cost=1.11..1.11 rows=11 width=15) (actual time=0.013..0.013 rows=11 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on film  (cost=0.00..1.11 rows=11 width=15) (actual time=0.009..0.010 rows=11 loops=1)"
"        ->  Hash  (cost=1.20..1.20 rows=20 width=19) (actual time=0.009..0.009 rows=20 loops=1)"
"              Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"              ->  Seq Scan on attributes  (cost=0.00..1.20 rows=20 width=19) (actual time=0.003..0.005 rows=20 loops=1)"
"  ->  Hash  (cost=1.10..1.10 rows=10 width=15) (actual time=0.012..0.012 rows=10 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"        ->  Seq Scan on attributes_types  (cost=0.00..1.10 rows=10 width=15) (actual time=0.007..0.009 rows=10 loops=1)"
"Planning Time: 0.409 ms"
"Execution Time: 0.147 ms"

/* время выполнения увеличилось на несколько  ms */
*/

SELECT count(tickets.id)*tickets.price_tickets as best_selling_movie, film.film_name as film_name
FROM public.tickets 
inner join seance on tickets.id_seance = seance.id 
inner join film on seance.id_film = film.id 
group by   film_name , price_tickets 
having count(tickets.id)=1  
order by best_selling_movie desc;
/*
"Sort  (cost=429.74..429.83 rows=39 width=59) (actual time=19.030..19.152 rows=2441 loops=1)"
"  Sort Key: (((count(tickets.id))::numeric * tickets.price_tickets)) DESC"
"  Sort Method: quicksort  Memory: 287kB"
"  ->  HashAggregate  (cost=332.12..428.70 rows=39 width=59) (actual time=16.422..17.933 rows=2441 loops=1)"
"        Group Key: film.film_name, tickets.price_tickets"
"        Filter: (count(tickets.id) = 1)"
"        Rows Removed by Filter: 2771"
"        ->  Hash Join  (cost=3.49..232.12 rows=10000 width=20) (actual time=0.046..6.565 rows=10000 loops=1)"
"              Hash Cond: (seance.id_film = film.id)"
"              ->  Hash Join  (cost=2.24..194.51 rows=10000 width=13) (actual time=0.026..3.679 rows=10000 loops=1)"
"                    Hash Cond: (tickets.id_seance = seance.id)"
"                    ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=13) (actual time=0.006..1.109 rows=10000 loops=1)"
"                    ->  Hash  (cost=1.55..1.55 rows=55 width=8) (actual time=0.016..0.016 rows=55 loops=1)"
"                          Buckets: 1024  Batches: 1  Memory Usage: 11kB"
"                          ->  Seq Scan on seance  (cost=0.00..1.55 rows=55 width=8) (actual time=0.003..0.008 rows=55 loops=1)"
"              ->  Hash  (cost=1.11..1.11 rows=11 width=15) (actual time=0.014..0.014 rows=11 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on film  (cost=0.00..1.11 rows=11 width=15) (actual time=0.009..0.011 rows=11 loops=1)"
"Planning Time: 0.344 ms"
"Execution Time: 19.434 ms"

*/

/*
"Sort  (cost=429.74..429.83 rows=39 width=59) (actual time=11.356..11.469 rows=2441 loops=1)"
"  Sort Key: (((count(tickets.id))::numeric * tickets.price_tickets)) DESC"
"  Sort Method: quicksort  Memory: 287kB"
"  ->  HashAggregate  (cost=332.12..428.70 rows=39 width=59) (actual time=9.079..10.476 rows=2441 loops=1)"
"        Group Key: film.film_name, tickets.price_tickets"
"        Filter: (count(tickets.id) = 1)"
"        Rows Removed by Filter: 2771"
"        ->  Hash Join  (cost=3.49..232.12 rows=10000 width=20) (actual time=0.044..5.407 rows=10000 loops=1)"
"              Hash Cond: (seance.id_film = film.id)"
"              ->  Hash Join  (cost=2.24..194.51 rows=10000 width=13) (actual time=0.026..3.627 rows=10000 loops=1)"
"                    Hash Cond: (tickets.id_seance = seance.id)"
"                    ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=13) (actual time=0.006..1.087 rows=10000 loops=1)"
"                    ->  Hash  (cost=1.55..1.55 rows=55 width=8) (actual time=0.015..0.016 rows=55 loops=1)"
"                          Buckets: 1024  Batches: 1  Memory Usage: 11kB"
"                          ->  Seq Scan on seance  (cost=0.00..1.55 rows=55 width=8) (actual time=0.003..0.009 rows=55 loops=1)"
"              ->  Hash  (cost=1.11..1.11 rows=11 width=15) (actual time=0.014..0.014 rows=11 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on film  (cost=0.00..1.11 rows=11 width=15) (actual time=0.008..0.010 rows=11 loops=1)"
"Planning Time: 0.786 ms"
"Execution Time: 11.706 ms"

*/
/* Удалось уменьшить время выполнения на 8.000 ms */


CREATE INDEX idx_id_seance ON tickets(id_seance);
CREATE INDEX idx_id_film ON  seance(id_film );
CREATE INDEX idx_tickets ON tickets(id);

CREATE INDEX idx_film_name ON film(film_name);
CREATE INDEX idx_attributes ON attributes(id);
CREATE INDEX idx_date ON attributes_value(date_val);

CREATE INDEX idx_filmId ON film(id);
CREATE INDEX idx_attributes_value_Id_attributes ON  attributes_value(id_attributes);
CREATE INDEX idx_attributes_id_type ON  attributes(id_type);



DROP INDEX idx_filmId ;
DROP INDEX idx_attributes_value_Id_attributes ;
DROP INDEX idx_attributes_id_type ;

DROP INDEX idx_clients_name;
DROP INDEX idx_seance_datetime;
DROP INDEX idx_price_tickets;

DROP INDEX idx_film_name ;
DROP INDEX idx_attributes;
DROP INDEX idx_date ;

DROP INDEX idx_id_seance;
DROP INDEX idx_id_film ;
DROP INDEX idx_tickets ;