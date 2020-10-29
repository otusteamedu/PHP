## Фильм, с наибольшей выручкой

Исходный запрос:
````sql
with t_total as (
    select f.name,
           count(t.id)  as "t_tikets",
           sum(t.coast) as "t_sum"
    from film f
             inner join seanse s on s.film = f.id
             inner join ticket t on t.seanse = s.id
    group by f.name
)
select *
from t_total
order by t_sum desc
limit 1;
````

План выполнения:
````sql
QUERY PLAN                                                                                |
------------------------------------------------------------------------------------------|
Limit  (cost=329.22..329.23 rows=1 width=258)                                             |
  CTE t_total                                                                             |
    ->  HashAggregate  (cost=325.47..326.72 rows=100 width=46)                            |
          Group Key: f.name                                                               |
          ->  Hash Join  (cost=32.75..250.47 rows=10000 width=15)                         |
                Hash Cond: (s.film = f.id)                                                |
                ->  Hash Join  (cost=29.50..219.86 rows=10000 width=13)                   |
                      Hash Cond: (t.seanse = s.id)                                        |
                      ->  Seq Scan on ticket t  (cost=0.00..164.00 rows=10000 width=13)   |
                      ->  Hash  (cost=17.00..17.00 rows=1000 width=8)                     |
                            ->  Seq Scan on seanse s  (cost=0.00..17.00 rows=1000 width=8)|
                ->  Hash  (cost=2.00..2.00 rows=100 width=10)                             |
                      ->  Seq Scan on film f  (cost=0.00..2.00 rows=100 width=10)         |
  ->  Sort  (cost=2.50..2.75 rows=100 width=258)                                          |
        Sort Key: t_total.t_sum DESC                                                      |
        ->  CTE Scan on t_total  (cost=0.00..2.00 rows=100 width=258)                     |
````
В данном случае, создание каких-либо индексов не поможет. Возможно можно переписать более эффективно сам запрос, но пока, не представляю как.
