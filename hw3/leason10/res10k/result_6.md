## Наиболее посещаемый зал

Исходный запрос:
````sql
with t1 as (
    select hall.name        as "hall",
           count(ticket.id) as "ticket_count"
    from hall
             inner join seanse on seanse.hall = hall.id
             inner join ticket on ticket.seanse = seanse.id
    group by hall.name
)

select *
from t1
order by ticket_count desc
limit 1;
````

План выполнения:
````sql
QUERY PLAN                                                                              |
----------------------------------------------------------------------------------------|
Limit  (cost=325.47..325.48 rows=1 width=126)                                           |
  CTE t1                                                                                |
    ->  HashAggregate  (cost=318.47..320.47 rows=200 width=126)                         |
          Group Key: hall.name                                                          |
          ->  Hash Join  (cost=51.65..268.47 rows=10000 width=122)                      |
                Hash Cond: (seanse.hall = hall.id)                                      |
                ->  Hash Join  (cost=29.50..219.86 rows=10000 width=8)                  |
                      Hash Cond: (ticket.seanse = seanse.id)                            |
                      ->  Seq Scan on ticket  (cost=0.00..164.00 rows=10000 width=8)    |
                      ->  Hash  (cost=17.00..17.00 rows=1000 width=8)                   |
                            ->  Seq Scan on seanse  (cost=0.00..17.00 rows=1000 width=8)|
                ->  Hash  (cost=15.40..15.40 rows=540 width=122)                        |
                      ->  Seq Scan on hall  (cost=0.00..15.40 rows=540 width=122)       |
  ->  Sort  (cost=5.00..5.50 rows=200 width=126)                                        |
        Sort Key: t1.ticket_count DESC                                                  |
        ->  CTE Scan on t1  (cost=0.00..4.00 rows=200 width=126)                        |
````
