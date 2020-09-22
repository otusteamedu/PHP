Список запросов представлен в файле `queries.sql`.

Таблица с таймингами выполнения запросов [ссылка](https://docs.google.com/spreadsheets/d/1WeVZSpVsHIhkTO9BmsOvcDzTH5K_ayj6icbYglV7-7w)

## Планы запросов и оптимизация их выполнения

### 1. Выбрать все билеты купленные вчера
#### Исходный план для 10К:
```
Seq Scan on tickets  (cost=0.00..293.04 rows=55 width=27)
  Filter: ((created_at)::date = (CURRENT_DATE - 1))
```
```
Seq Scan on tickets  (cost=0.00..274.00 rows=50 width=27) (actual time=2.249..2.250 rows=0 loops=1)
 Filter: ((created_at)::date = (CURRENT_DATE - 1))
 Rows Removed by Filter: 10000
Planning Time: 0.065 ms
Execution Time: 2.261 ms
```

#### Исходный план для 10M:
```
Gather  (cost=1000.00..156387.73 rows=47999 width=27)
  Workers Planned: 2
  ->  Parallel Seq Scan on tickets  (cost=0.00..150587.83 rows=20000 width=27)
        Filter: ((created_at)::date = (CURRENT_DATE - 1))
```
```
Gather  (cost=1000.00..156387.73 rows=47999 width=27) (actual time=0.779..641.491 rows=2337 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on tickets  (cost=0.00..150587.83 rows=20000 width=27) (actual time=0.366..633.369 rows=779 loops=3)
        Filter: ((created_at)::date = (CURRENT_DATE - 1))
        Rows Removed by Filter: 3199221
Planning Time: 0.046 ms
Execution Time: 641.657 ms
```

#### Оптимизация
Добавлен функциональный индекс на `tickets.created_at`
```sql
create index tickets_created_at_date_index on tickets ((created_at::date));
```

#### План после оптимизации
```
Bitmap Heap Scan on tickets  (cost=900.44..68591.95 rows=48000 width=27) (actual time=0.762..2.491 rows=2337 loops=1)
  Recheck Cond: ((created_at)::date = (CURRENT_DATE - 1))
  Heap Blocks: exact=2298
  ->  Bitmap Index Scan on tickets_created_at_date_index  (cost=0.00..888.44 rows=48000 width=0) (actual time=0.460..0.460 rows=2337 loops=1)
        Index Cond: ((created_at)::date = (CURRENT_DATE - 1))
Planning Time: 0.088 ms
Execution Time: 2.672 ms
```


### 2. Выбрать все сеансы, базовая стоимость которых равна 700 единицам за 2019 год 
#### Исходный план для 10К:
```
Seq Scan on sessions  (cost=0.00..2.75 rows=1 width=23)
"  Filter: ((price = '700'::numeric) AND (date_part('year'::text, starts_at) = '2019'::double precision))"
```
```
Seq Scan on sessions  (cost=0.00..2.75 rows=1 width=23) (actual time=0.022..0.024 rows=1 loops=1)
"  Filter: ((price = '700'::numeric) AND (date_part('year'::text, starts_at) = '2019'::double precision))"
 Rows Removed by Filter: 99
Planning Time: 0.051 ms
Execution Time: 0.048 ms
```

#### Исходный план для 10M:
```
Seq Scan on sessions  (cost=0.00..398.00 rows=8 width=23)
"  Filter: ((price = '700'::numeric) AND (date_part('year'::text, starts_at) = '2019'::double precision))"
```
```
Seq Scan on sessions  (cost=0.00..398.00 rows=8 width=23) (actual time=0.044..2.455 rows=144 loops=1)
"  Filter: ((price = '700'::numeric) AND (date_part('year'::text, starts_at) = '2019'::double precision))"
  Rows Removed by Filter: 15856
Planning Time: 0.049 ms
Execution Time: 2.473 ms
```

#### Оптимизация
Добавлен составной индекс.
```sql
create index sessions_price_and_starts_at_year_index on sessions (price, (extract(year from starts_at)));
```

#### План после оптимизации
```
Bitmap Heap Scan on sessions  (cost=4.37..30.26 rows=8 width=23) (actual time=0.038..0.110 rows=144 loops=1)
"  Recheck Cond: ((price = '700'::numeric) AND (date_part('year'::text, starts_at) = '2019'::double precision))"
  Heap Blocks: exact=84
  ->  Bitmap Index Scan on sessions_price_and_starts_at_year_index  (cost=0.00..4.37 rows=8 width=0) (actual time=0.028..0.028 rows=144 loops=1)
"        Index Cond: ((price = '700'::numeric) AND (date_part('year'::text, starts_at) = '2019'::double precision))"
Planning Time: 0.063 ms
Execution Time: 0.133 ms
```


### 3. Дата продажи первого билета
#### Исходный план для 10К:
```
Limit  (cost=224.00..224.00 rows=1 width=27)
 ->  Sort  (cost=224.00..249.00 rows=10000 width=27)
       Sort Key: created_at
       ->  Seq Scan on tickets  (cost=0.00..174.00 rows=10000 width=27)
```

```
Limit  (cost=224.00..224.00 rows=1 width=27) (actual time=3.581..3.582 rows=1 loops=1)
 ->  Sort  (cost=224.00..249.00 rows=10000 width=27) (actual time=3.581..3.581 rows=1 loops=1)
       Sort Key: created_at
       Sort Method: top-N heapsort  Memory: 25kB
       ->  Seq Scan on tickets  (cost=0.00..174.00 rows=10000 width=27) (actual time=0.009..1.630 rows=10000 loops=1)
Planning Time: 0.043 ms
Execution Time: 3.595 ms
```
#### Исходный план для 10M:
```
Limit  (cost=131588.14..131588.26 rows=1 width=27)
  ->  Gather Merge  (cost=131588.14..1064972.87 rows=7999882 width=27)
        Workers Planned: 2
        ->  Sort  (cost=130588.12..140587.97 rows=3999941 width=27)
              Sort Key: created_at
              ->  Parallel Seq Scan on tickets  (cost=0.00..110588.41 rows=3999941 width=27)
```
```
Limit  (cost=131588.14..131588.26 rows=1 width=27) (actual time=984.627..991.491 rows=1 loops=1)
  ->  Gather Merge  (cost=131588.14..1064972.87 rows=7999882 width=27) (actual time=984.626..991.489 rows=1 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Sort  (cost=130588.12..140587.97 rows=3999941 width=27) (actual time=981.610..981.611 rows=1 loops=3)
              Sort Key: created_at
              Sort Method: top-N heapsort  Memory: 25kB
              Worker 0:  Sort Method: top-N heapsort  Memory: 25kB
              Worker 1:  Sort Method: top-N heapsort  Memory: 25kB
              ->  Parallel Seq Scan on tickets  (cost=0.00..110588.41 rows=3999941 width=27) (actual time=0.053..475.369 rows=3200000 loops=3)
Planning Time: 0.077 ms
Execution Time: 991.520 ms
```

#### Оптимизация
Индекс на `tickets.created_at`
```sql
create index tickets_created_at_index on tickets (created_at);
```

#### План после оптимизации
```
Limit  (cost=0.43..0.49 rows=1 width=27) (actual time=0.014..0.015 rows=1 loops=1)
  ->  Index Scan using tickets_created_at_index on tickets  (cost=0.43..531651.65 rows=9600000 width=27) (actual time=0.013..0.013 rows=1 loops=1)
Planning Time: 0.060 ms
Execution Time: 0.026 ms
```


### 4. Средняя стоимость билета на первом ряду
#### Исходный план для 10К:
```
Aggregate  (cost=264.60..264.61 rows=1 width=8)
  ->  Hash Join  (cost=46.85..263.35 rows=500 width=5)
        Hash Cond: (tickets.seat_id = seats.id)
        ->  Seq Scan on tickets  (cost=0.00..174.00 rows=10000 width=7)
        ->  Hash  (cost=46.47..46.47 rows=30 width=2)
              ->  Merge Join  (cost=36.84..46.47 rows=30 width=2)
                    Merge Cond: (rows.id = seats.row_id)
                    ->  Index Scan using rows_pkey on rows  (cost=0.15..63.16 rows=120 width=2)
                          Filter: (number = 1)
                    ->  Sort  (cost=36.69..38.19 rows=600 width=4)
                          Sort Key: seats.row_id
                          ->  Seq Scan on seats  (cost=0.00..9.00 rows=600 width=4)
```
```
Aggregate  (cost=264.60..264.61 rows=1 width=8) (actual time=2.847..2.848 rows=1 loops=1)
  ->  Hash Join  (cost=46.85..263.35 rows=500 width=5) (actual time=0.336..2.801 rows=539 loops=1)
        Hash Cond: (tickets.seat_id = seats.id)
        ->  Seq Scan on tickets  (cost=0.00..174.00 rows=10000 width=7) (actual time=0.009..1.488 rows=10000 loops=1)
        ->  Hash  (cost=46.47..46.47 rows=30 width=2) (actual time=0.257..0.258 rows=30 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Merge Join  (cost=36.84..46.47 rows=30 width=2) (actual time=0.240..0.252 rows=30 loops=1)
                    Merge Cond: (rows.id = seats.row_id)
                    ->  Index Scan using rows_pkey on rows  (cost=0.15..63.16 rows=120 width=2) (actual time=0.004..0.008 rows=1 loops=1)
                          Filter: (number = 1)
                          Rows Removed by Filter: 19
                    ->  Sort  (cost=36.69..38.19 rows=600 width=4) (actual time=0.234..0.236 rows=31 loops=1)
                          Sort Key: seats.row_id
                          Sort Method: quicksort  Memory: 53kB
                          ->  Seq Scan on seats  (cost=0.00..9.00 rows=600 width=4) (actual time=0.007..0.081 rows=600 loops=1)
Planning Time: 0.287 ms
Execution Time: 2.906 ms
```

#### Исходный план для 10M:
```
Finalize Aggregate  (cost=129198.83..129198.84 rows=1 width=8)
  ->  Gather  (cost=129198.61..129198.82 rows=2 width=8)
        Workers Planned: 2
        ->  Partial Aggregate  (cost=128198.61..128198.62 rows=1 width=8)
              ->  Hash Join  (cost=110.46..127698.62 rows=199997 width=5)
                    Hash Cond: (tickets.seat_id = seats.id)
                    ->  Parallel Seq Scan on tickets  (cost=0.00..110588.41 rows=3999941 width=7)
                    ->  Hash  (cost=106.71..106.71 rows=300 width=2)
                          ->  Hash Join  (cost=3.62..106.71 rows=300 width=2)
                                Hash Cond: (seats.row_id = rows.id)
                                ->  Seq Scan on seats  (cost=0.00..87.00 rows=6000 width=4)
                                ->  Hash  (cost=3.50..3.50 rows=10 width=2)
                                      ->  Seq Scan on rows  (cost=0.00..3.50 rows=10 width=2)
                                            Filter: (number = 1)
```
```
Finalize Aggregate  (cost=129198.83..129198.84 rows=1 width=8) (actual time=706.653..711.649 rows=1 loops=1)
  ->  Gather  (cost=129198.61..129198.82 rows=2 width=8) (actual time=706.544..711.640 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=128198.61..128198.62 rows=1 width=8) (actual time=703.310..703.312 rows=1 loops=3)
              ->  Hash Join  (cost=110.46..127698.62 rows=199997 width=5) (actual time=2.132..691.642 rows=159633 loops=3)
                    Hash Cond: (tickets.seat_id = seats.id)
                    ->  Parallel Seq Scan on tickets  (cost=0.00..110588.41 rows=3999941 width=7) (actual time=0.191..424.955 rows=3200000 loops=3)
                    ->  Hash  (cost=106.71..106.71 rows=300 width=2) (actual time=1.821..1.823 rows=300 loops=3)
                          Buckets: 1024  Batches: 1  Memory Usage: 18kB
                          ->  Hash Join  (cost=3.62..106.71 rows=300 width=2) (actual time=0.395..1.773 rows=300 loops=3)
                                Hash Cond: (seats.row_id = rows.id)
                                ->  Seq Scan on seats  (cost=0.00..87.00 rows=6000 width=4) (actual time=0.029..0.706 rows=6000 loops=3)
                                ->  Hash  (cost=3.50..3.50 rows=10 width=2) (actual time=0.045..0.045 rows=10 loops=3)
                                      Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                      ->  Seq Scan on rows  (cost=0.00..3.50 rows=10 width=2) (actual time=0.024..0.037 rows=10 loops=3)
                                            Filter: (number = 1)
                                            Rows Removed by Filter: 190
Planning Time: 0.204 ms
Execution Time: 711.684 ms
```

#### Оптимизация
Соединения всех таблиц производится через внешние ключи, установка индекса на rows.number выигрыша не дает, так как в таблице много одинаковых значений, планировщик считает, что быстрее будет пройти по всей таблице, она не большая: 
```
Finalize Aggregate  (cost=129199.68..129199.69 rows=1 width=32) (actual time=689.661..693.705 rows=1 loops=1)
  ->  Gather  (cost=129199.46..129199.67 rows=2 width=32) (actual time=689.556..693.695 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=128199.46..128199.47 rows=1 width=32) (actual time=686.502..686.504 rows=1 loops=3)
              ->  Hash Join  (cost=110.46..127699.46 rows=200000 width=5) (actual time=1.585..668.861 rows=159633 loops=3)
                    Hash Cond: (tickets.seat_id = seats.id)
                    ->  Parallel Seq Scan on tickets  (cost=0.00..110589.00 rows=4000000 width=7) (actual time=0.032..409.174 rows=3200000 loops=3)
                    ->  Hash  (cost=106.71..106.71 rows=300 width=2) (actual time=1.451..1.452 rows=300 loops=3)
                          Buckets: 1024  Batches: 1  Memory Usage: 18kB
                          ->  Hash Join  (cost=3.62..106.71 rows=300 width=2) (actual time=0.076..1.404 rows=300 loops=3)
                                Hash Cond: (seats.row_id = rows.id)
                                ->  Seq Scan on seats  (cost=0.00..87.00 rows=6000 width=4) (actual time=0.025..0.670 rows=6000 loops=3)
                                ->  Hash  (cost=3.50..3.50 rows=10 width=2) (actual time=0.040..0.041 rows=10 loops=3)
                                      Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                      ->  Seq Scan on rows  (cost=0.00..3.50 rows=10 width=2) (actual time=0.020..0.033 rows=10 loops=3)
                                            Filter: (number = 1)
                                            Rows Removed by Filter: 190
Planning Time: 0.217 ms
Execution Time: 693.738 ms
```

Была произведена попытка денормализовать таблицу tickets, добавить в нее внешний ключ row_id, скорость выполнения запроса уменьшилась в пределах погрешности:
```
Finalize Aggregate  (cost=260866.88..260866.89 rows=1 width=32) (actual time=799.618..803.678 rows=1 loops=1)
  ->  Gather  (cost=260866.66..260866.87 rows=2 width=32) (actual time=799.513..803.668 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=259866.66..259866.67 rows=1 width=32) (actual time=796.161..796.162 rows=1 loops=3)
              ->  Hash Join  (cost=3.62..258800.00 rows=426664 width=5) (actual time=78.314..778.303 rows=159633 loops=3)
                    Hash Cond: (tickets.row_id = rows.id)
                    ->  Parallel Seq Scan on tickets  (cost=0.00..235921.84 rows=8533284 width=7) (actual time=78.114..527.572 rows=3200000 loops=3)
                    ->  Hash  (cost=3.50..3.50 rows=10 width=2) (actual time=0.055..0.056 rows=10 loops=3)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Seq Scan on rows  (cost=0.00..3.50 rows=10 width=2) (actual time=0.031..0.044 rows=10 loops=3)
                                Filter: (number = 1)
                                Rows Removed by Filter: 190
Planning Time: 0.110 ms
Execution Time: 663.710 ms
```

Такое минимальное изменение обосновано тем, что прохождение по самым большим таблицам осталось последовательным


### 5. Посчитать наибольшую и наименьшую прибыль сеанса
#### Исходный план для 10К:
```
Aggregate  (cost=351.86..351.87 rows=1 width=64)
  ->  GroupAggregate  (cost=350.41..351.27 rows=39 width=36)
        Group Key: tickets.session_id
        ->  Sort  (cost=350.41..350.54 rows=50 width=9)
              Sort Key: tickets.session_id
              ->  Seq Scan on tickets  (cost=0.00..349.00 rows=50 width=9)
"                    Filter: (((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))"
```
```
Aggregate  (cost=351.86..351.87 rows=1 width=64) (actual time=4.849..4.850 rows=1 loops=1)
  ->  GroupAggregate  (cost=350.41..351.27 rows=39 width=36) (actual time=4.829..4.843 rows=18 loops=1)
        Group Key: tickets.session_id
        ->  Sort  (cost=350.41..350.54 rows=50 width=9) (actual time=4.822..4.824 rows=19 loops=1)
              Sort Key: tickets.session_id
              Sort Method: quicksort  Memory: 25kB
              ->  Seq Scan on tickets  (cost=0.00..349.00 rows=50 width=9) (actual time=0.052..4.813 rows=19 loops=1)
"                    Filter: (((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))"
                    Rows Removed by Filter: 9981
Planning Time: 0.075 ms
Execution Time: 4.889 ms
```

#### Исходный план для 10M:
```
Aggregate  (cost=187039.16..187039.17 rows=1 width=64)
  ->  Finalize GroupAggregate  (cost=183016.18..186835.92 rows=13549 width=36)
        Group Key: tickets.session_id
        ->  Gather Merge  (cost=183016.18..186463.32 rows=27098 width=36)
              Workers Planned: 2
              ->  Partial GroupAggregate  (cost=182016.16..182335.52 rows=13549 width=36)
                    Group Key: tickets.session_id
                    ->  Sort  (cost=182016.16..182066.16 rows=20000 width=9)
                          Sort Key: tickets.session_id
                          ->  Parallel Seq Scan on tickets  (cost=0.00..180587.38 rows=20000 width=9)
"                                Filter: (((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))"
```
```
Aggregate  (cost=187039.16..187039.17 rows=1 width=64) (actual time=1317.204..1319.630 rows=1 loops=1)
  ->  Finalize GroupAggregate  (cost=183016.18..186835.92 rows=13549 width=36) (actual time=1299.707..1318.341 rows=11158 loops=1)
        Group Key: tickets.session_id
        ->  Gather Merge  (cost=183016.18..186463.32 rows=27098 width=36) (actual time=1299.697..1308.550 rows=15655 loops=1)
              Workers Planned: 2
              Workers Launched: 2
              ->  Partial GroupAggregate  (cost=182016.16..182335.52 rows=13549 width=36) (actual time=1296.549..1300.599 rows=5218 loops=3)
                    Group Key: tickets.session_id
                    ->  Sort  (cost=182016.16..182066.16 rows=20000 width=9) (actual time=1296.530..1296.981 rows=6379 loops=3)
                          Sort Key: tickets.session_id
                          Sort Method: quicksort  Memory: 491kB
                          Worker 0:  Sort Method: quicksort  Memory: 492kB
                          Worker 1:  Sort Method: quicksort  Memory: 492kB
                          ->  Parallel Seq Scan on tickets  (cost=0.00..180587.38 rows=20000 width=9) (actual time=0.286..1294.713 rows=6379 loops=3)
"                                Filter: (((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))"
                                Rows Removed by Filter: 3193621
Planning Time: 0.084 ms
Execution Time: 1319.670 ms
```

#### Оптимизация
Добавлен функциональный индекс на `tickets.created_at`
```sql
create index tickets_created_at_date_index on tickets ((created_at::date));
```

#### План после оптимизации
```
Aggregate  (cost=64254.12..64254.13 rows=1 width=64) (actual time=79.714..79.715 rows=1 loops=1)
  ->  HashAggregate  (cost=63987.87..64108.89 rows=9682 width=36) (actual time=74.951..78.320 rows=11158 loops=1)
        Group Key: tickets.session_id
        ->  Bitmap Heap Scan on tickets  (cost=781.96..63870.05 rows=23563 width=9) (actual time=6.207..66.870 rows=19137 loops=1)
"              Recheck Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE))"
              Heap Blocks: exact=17085
              ->  Bitmap Index Scan on tickets_created_at_date_index  (cost=0.00..776.07 rows=23563 width=0) (actual time=3.526..3.527 rows=19143 loops=1)
"                    Index Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE))"
Planning Time: 0.115 ms
Execution Time: 79.780 ms
```


### 6. Фильм с наибольшими сборами за последние 7 дней
#### Исходный план для 10К:
```
Limit  (cost=360.64..360.64 rows=1 width=69)
  ->  Sort  (cost=360.64..360.76 rows=50 width=69)
        Sort Key: (sum(tickets.cost)) DESC
        ->  GroupAggregate  (cost=359.39..360.39 rows=50 width=69)
              Group Key: movies.id
              ->  Sort  (cost=359.39..359.51 rows=50 width=42)
                    Sort Key: movies.id
                    ->  Hash Left Join  (cost=8.29..357.98 rows=50 width=42)
                          Hash Cond: (tickets.session_id = sessions.id)
                          ->  Seq Scan on tickets  (cost=0.00..349.00 rows=50 width=9)
"                                Filter: (((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))"
                          ->  Hash  (cost=7.04..7.04 rows=100 width=41)
                                ->  Merge Right Join  (cost=5.47..7.04 rows=100 width=41)
                                      Merge Cond: (movies.id = sessions.movie_id)
                                      ->  Index Scan using movies_pkey on movies  (cost=0.15..27.30 rows=410 width=37)
                                      ->  Sort  (cost=5.32..5.57 rows=100 width=8)
                                            Sort Key: sessions.movie_id
                                            ->  Seq Scan on sessions  (cost=0.00..2.00 rows=100 width=8)
```
```
Limit  (cost=360.64..360.64 rows=1 width=69) (actual time=4.034..4.036 rows=1 loops=1)
  ->  Sort  (cost=360.64..360.76 rows=50 width=69) (actual time=4.033..4.035 rows=1 loops=1)
        Sort Key: (sum(tickets.cost)) DESC
        Sort Method: quicksort  Memory: 25kB
        ->  GroupAggregate  (cost=359.39..360.39 rows=50 width=69) (actual time=4.031..4.032 rows=1 loops=1)
              Group Key: movies.id
              ->  Sort  (cost=359.39..359.51 rows=50 width=42) (actual time=4.020..4.023 rows=19 loops=1)
                    Sort Key: movies.id
                    Sort Method: quicksort  Memory: 26kB
                    ->  Hash Left Join  (cost=8.29..357.98 rows=50 width=42) (actual time=0.123..4.016 rows=19 loops=1)
                          Hash Cond: (tickets.session_id = sessions.id)
                          ->  Seq Scan on tickets  (cost=0.00..349.00 rows=50 width=9) (actual time=0.043..3.928 rows=19 loops=1)
"                                Filter: (((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))"
                                Rows Removed by Filter: 9981
                          ->  Hash  (cost=7.04..7.04 rows=100 width=41) (actual time=0.067..0.068 rows=100 loops=1)
                                Buckets: 1024  Batches: 1  Memory Usage: 16kB
                                ->  Merge Right Join  (cost=5.47..7.04 rows=100 width=41) (actual time=0.030..0.051 rows=100 loops=1)
                                      Merge Cond: (movies.id = sessions.movie_id)
                                      ->  Index Scan using movies_pkey on movies  (cost=0.15..27.30 rows=410 width=37) (actual time=0.002..0.003 rows=1 loops=1)
                                      ->  Sort  (cost=5.32..5.57 rows=100 width=8) (actual time=0.026..0.033 rows=100 loops=1)
                                            Sort Key: sessions.movie_id
                                            Sort Method: quicksort  Memory: 29kB
                                            ->  Seq Scan on sessions  (cost=0.00..2.00 rows=100 width=8) (actual time=0.004..0.014 rows=100 loops=1)
Planning Time: 0.711 ms
Execution Time: 4.068 ms
```

#### Исходный план для 10M:
```
Limit  (cost=183784.25..183784.25 rows=1 width=69)
  ->  Sort  (cost=183784.25..183784.50 rows=100 width=69)
        Sort Key: (sum(tickets.cost)) DESC
        ->  Finalize GroupAggregate  (cost=183606.67..183783.75 rows=100 width=69)
              Group Key: movies.id
              ->  Gather Merge  (cost=183606.67..183781.00 rows=200 width=69)
                    Workers Planned: 2
                    ->  Partial GroupAggregate  (cost=182606.64..182757.89 rows=100 width=69)
                          Group Key: movies.id
                          ->  Sort  (cost=182606.64..182656.64 rows=20000 width=42)
                                Sort Key: movies.id
                                ->  Hash Left Join  (cost=483.25..181177.87 rows=20000 width=42)
                                      Hash Cond: (sessions.movie_id = movies.id)
                                      ->  Hash Left Join  (cost=478.00..181117.90 rows=20000 width=9)
                                            Hash Cond: (tickets.session_id = sessions.id)
                                            ->  Parallel Seq Scan on tickets  (cost=0.00..180587.38 rows=20000 width=9)
"                                                  Filter: (((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))"
                                            ->  Hash  (cost=278.00..278.00 rows=16000 width=8)
                                                  ->  Seq Scan on sessions  (cost=0.00..278.00 rows=16000 width=8)
                                      ->  Hash  (cost=4.00..4.00 rows=100 width=37)
                                            ->  Seq Scan on movies  (cost=0.00..4.00 rows=100 width=37)
```
```
Limit  (cost=183784.25..183784.25 rows=1 width=69) (actual time=1294.365..1298.922 rows=1 loops=1)
  ->  Sort  (cost=183784.25..183784.50 rows=100 width=69) (actual time=1294.364..1298.920 rows=1 loops=1)
        Sort Key: (sum(tickets.cost)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=183606.67..183783.75 rows=100 width=69) (actual time=1292.776..1298.887 rows=100 loops=1)
              Group Key: movies.id
              ->  Gather Merge  (cost=183606.67..183781.00 rows=200 width=69) (actual time=1292.749..1298.723 rows=300 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=182606.64..182757.89 rows=100 width=69) (actual time=1288.813..1290.158 rows=100 loops=3)
                          Group Key: movies.id
                          ->  Sort  (cost=182606.64..182656.64 rows=20000 width=42) (actual time=1288.783..1289.188 rows=6379 loops=3)
                                Sort Key: movies.id
                                Sort Method: quicksort  Memory: 693kB
                                Worker 0:  Sort Method: quicksort  Memory: 691kB
                                Worker 1:  Sort Method: quicksort  Memory: 688kB
                                ->  Hash Left Join  (cost=483.25..181177.87 rows=20000 width=42) (actual time=5.591..1284.865 rows=6379 loops=3)
                                      Hash Cond: (sessions.movie_id = movies.id)
                                      ->  Hash Left Join  (cost=478.00..181117.90 rows=20000 width=9) (actual time=5.511..1283.063 rows=6379 loops=3)
                                            Hash Cond: (tickets.session_id = sessions.id)
                                            ->  Parallel Seq Scan on tickets  (cost=0.00..180587.38 rows=20000 width=9) (actual time=0.361..1275.068 rows=6379 loops=3)
"                                                  Filter: (((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))"
                                                  Rows Removed by Filter: 3193621
                                            ->  Hash  (cost=278.00..278.00 rows=16000 width=8) (actual time=5.069..5.069 rows=16000 loops=3)
                                                  Buckets: 16384  Batches: 1  Memory Usage: 753kB
                                                  ->  Seq Scan on sessions  (cost=0.00..278.00 rows=16000 width=8) (actual time=0.022..2.481 rows=16000 loops=3)
                                      ->  Hash  (cost=4.00..4.00 rows=100 width=37) (actual time=0.066..0.066 rows=100 loops=3)
                                            Buckets: 1024  Batches: 1  Memory Usage: 15kB
                                            ->  Seq Scan on movies  (cost=0.00..4.00 rows=100 width=37) (actual time=0.026..0.044 rows=100 loops=3)
Planning Time: 0.224 ms
Execution Time: 1299.092 ms
```

#### Оптимизация
Добавлен функциональный индекс на `tickets.created_at`
```sql
create index tickets_created_at_date_index on tickets ((created_at::date));
```

#### План после оптимизации
```
Limit  (cost=64599.21..64599.21 rows=1 width=69) (actual time=83.452..83.455 rows=1 loops=1)
  ->  Sort  (cost=64599.21..64599.46 rows=100 width=69) (actual time=83.451..83.454 rows=1 loops=1)
        Sort Key: (sum(tickets.cost)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  HashAggregate  (cost=64597.46..64598.71 rows=100 width=69) (actual time=83.393..83.426 rows=100 loops=1)
              Group Key: movies.id
              ->  Hash Left Join  (cost=1265.21..64479.64 rows=23563 width=42) (actual time=11.915..77.264 rows=19137 loops=1)
                    Hash Cond: (sessions.movie_id = movies.id)
                    ->  Hash Left Join  (cost=1259.96..64409.92 rows=23563 width=9) (actual time=11.865..72.085 rows=19137 loops=1)
                          Hash Cond: (tickets.session_id = sessions.id)
                          ->  Bitmap Heap Scan on tickets  (cost=781.96..63870.05 rows=23563 width=9) (actual time=7.077..60.342 rows=19137 loops=1)
"                                Recheck Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE))"
                                Heap Blocks: exact=17085
                                ->  Bitmap Index Scan on tickets_created_at_date_index  (cost=0.00..776.07 rows=23563 width=0) (actual time=4.388..4.388 rows=19143 loops=1)
"                                      Index Cond: (((created_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((created_at)::date <= CURRENT_DATE))"
                          ->  Hash  (cost=278.00..278.00 rows=16000 width=8) (actual time=4.761..4.762 rows=16000 loops=1)
                                Buckets: 16384  Batches: 1  Memory Usage: 753kB
                                ->  Seq Scan on sessions  (cost=0.00..278.00 rows=16000 width=8) (actual time=0.010..2.292 rows=16000 loops=1)
                    ->  Hash  (cost=4.00..4.00 rows=100 width=37) (actual time=0.044..0.045 rows=100 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 15kB
                          ->  Seq Scan on movies  (cost=0.00..4.00 rows=100 width=37) (actual time=0.005..0.021 rows=100 loops=1)
Planning Time: 0.248 ms
Execution Time: 84.346 ms
```

## Отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

```sql
select pg_namespace.nspname || '.' || pg_class.relname as relation,
    case pg_class.relkind 
        when 'r' then 'table' 
        when 'i' then 'index' 
        else pg_class.relkind::text 
    end as type,
    case pg_class.relkind 
        when 'r' then pg_size_pretty(pg_relation_size(pg_class.oid))
        else null 
    end as size,
    case pg_class.relkind 
        when 'r' then pg_size_pretty(pg_indexes_size(pg_class.oid))
        when 'i' then pg_size_pretty(pg_total_relation_size(pg_class.oid))
        else null 
    end as index_size,
    case pg_class.relkind 
        when 'r' then pg_size_pretty(pg_total_relation_size(pg_class.oid))
        else null 
    end as total_size
from pg_class
left join pg_namespace on (pg_namespace.oid = pg_class.relnamespace)
where 
    pg_namespace.nspname not in ('pg_catalog', 'information_schema')
    and pg_class.relkind in ('i', 'r')
order by pg_relation_size(pg_class.oid) desc
limit 15;
```

[Результат выполнения](https://docs.google.com/spreadsheets/d/1WeVZSpVsHIhkTO9BmsOvcDzTH5K_ayj6icbYglV7-7w#gid=439821985)


## Отсортированные списки (по 5 значений) самых часто и редко используемых индексов

Часто используемые индексы
```sql
select indexrelname from pg_stat_user_indexes order by idx_tup_read desc limit 5;
```
[Результат выполнения]()

Редко используемые индексы
```sql
select indexrelname from pg_stat_user_indexes order by idx_tup_read limit 5;
```

[Результат выполнения]()
