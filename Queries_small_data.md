### 1. Статистика по каждому фильму - сумма и количество проданных билетов
```
SELECT
   films.name,
   count(tickets.id),
   sum(prices.price) as sum
FROM films
  JOIN sessions ON sessions.film_id = films.id
  JOIN tickets ON tickets.session_id = sessions.id
  JOIN prices ON prices.id = tickets.price_id
GROUP BY films.name
ORDER BY sum
```
Explain Analyze
```
Sort  (cost=5865.34..5865.84 rows=200 width=72) (actual time=161.678..161.685 rows=122 loops=1)
  Sort Key: (sum(prices.price))
  Sort Method: quicksort  Memory: 34kB
  ->  Finalize GroupAggregate  (cost=5830.20..5857.70 rows=200 width=72) (actual time=161.107..161.501 rows=122 loops=1)
        Group Key: films.name
        ->  Gather Merge  (cost=5830.20..5853.20 rows=200 width=72) (actual time=161.088..162.897 rows=244 loops=1)
              Workers Planned: 1
              Workers Launched: 1
              ->  Sort  (cost=4830.19..4830.69 rows=200 width=72) (actual time=156.339..156.351 rows=122 loops=2)
                    Sort Key: films.name
                    Sort Method: quicksort  Memory: 42kB
                    Worker 0:  Sort Method: quicksort  Memory: 42kB
                    ->  Partial HashAggregate  (cost=4820.05..4822.55 rows=200 width=72) (actual time=156.034..156.111 rows=122 loops=2)
                          Group Key: films.name
                          ->  Hash Join  (cost=198.56..3817.78 rows=133635 width=52) (actual time=1.869..116.858 rows=113540 loops=2)
                                Hash Cond: (tickets.price_id = prices.id)
                                ->  Hash Join  (cost=150.31..3417.86 rows=133635 width=40) (actual time=1.729..87.472 rows=113540 loops=2)
                                      Hash Cond: (sessions.film_id = films.id)
                                      ->  Hash Join  (cost=113.31..3028.84 rows=133635 width=12) (actual time=1.596..56.106 rows=113540 loops=2)
                                            Hash Cond: (tickets.session_id = sessions.id)
                                            ->  Parallel Seq Scan on tickets  (cost=0.00..2564.35 rows=133635 width=12) (actual time=0.012..21.938 rows=113540 loops=2)
                                            ->  Hash  (cost=64.25..64.25 rows=3925 width=8) (actual time=1.513..1.514 rows=3298 loops=2)
                                                  Buckets: 4096  Batches: 1  Memory Usage: 161kB
                                                  ->  Seq Scan on sessions  (cost=0.00..64.25 rows=3925 width=8) (actual time=0.018..0.660 rows=3298 loops=2)
                                      ->  Hash  (cost=22.00..22.00 rows=1200 width=36) (actual time=0.090..0.090 rows=122 loops=2)
                                            Buckets: 2048  Batches: 1  Memory Usage: 23kB
                                            ->  Seq Scan on films  (cost=0.00..22.00 rows=1200 width=36) (actual time=0.026..0.042 rows=122 loops=2)
                                ->  Hash  (cost=27.00..27.00 rows=1700 width=20) (actual time=0.062..0.062 rows=40 loops=2)
                                      Buckets: 2048  Batches: 1  Memory Usage: 18kB
                                      ->  Seq Scan on prices  (cost=0.00..27.00 rows=1700 width=20) (actual time=0.027..0.034 rows=40 loops=2)
Planning Time: 1.475 ms
Execution Time: 163.876 ms
```

### 2. Статистика проданных билетов по дням
```
SELECT 
  date(sessions.start_time) as day,
  count(tickets.id) as tickets_count,
  sum(prices.price) as total_sum
FROM sessions
  JOIN tickets ON tickets.session_id = sessions.id
  JOIN prices ON prices.id = tickets.price_id
GROUP BY day
ORDER BY day
```
Explain analyze:
```
Sort  (cost=2573.21..2575.49 rows=909 width=44) (actual time=86.176..86.177 rows=11 loops=1)
  Sort Key: (date(sessions.start_time))
  Sort Method: quicksort  Memory: 25kB
  ->  HashAggregate  (cost=2514.91..2528.55 rows=909 width=44) (actual time=86.064..86.074 rows=11 loops=1)
        Group Key: date(sessions.start_time)
        ->  Hash Join  (cost=83.10..1920.40 rows=79268 width=24) (actual time=1.158..59.333 rows=79268 loops=1)
              Hash Cond: (tickets.price_id = prices.id)
              ->  Hash Join  (cost=34.85..1465.38 rows=79268 width=16) (actual time=0.998..36.009 rows=79268 loops=1)
                    Hash Cond: (tickets.session_id = sessions.id)
                    ->  Seq Scan on tickets  (cost=0.00..1221.68 rows=79268 width=12) (actual time=0.020..13.643 rows=79268 loops=1)
                    ->  Hash  (cost=20.49..20.49 rows=1149 width=12) (actual time=0.923..0.924 rows=1149 loops=1)
                          Buckets: 2048  Batches: 1  Memory Usage: 66kB
                          ->  Seq Scan on sessions  (cost=0.00..20.49 rows=1149 width=12) (actual time=0.030..0.454 rows=1149 loops=1)
              ->  Hash  (cost=27.00..27.00 rows=1700 width=20) (actual time=0.067..0.067 rows=40 loops=1)
                    Buckets: 2048  Batches: 1  Memory Usage: 18kB
                    ->  Seq Scan on prices  (cost=0.00..27.00 rows=1700 width=20) (actual time=0.013..0.032 rows=40 loops=1)
Planning Time: 1.679 ms
Execution Time: 86.602 ms
```

### 3. Статистика проданных и свободных мест по сеансам
```
SELECT
  sessions.id as session_id,
  halls.name as hall_name,
  films.name as film_name,
  sessions.start_time,
  (halls.total_seats - tickets.tickets_count) as empty_seats,
  tickets.tickets_count as sold_seats
FROM
(
    SELECT 
      sessions.id as session_id,
      count(tickets.id) as tickets_count
    FROM sessions
      JOIN tickets ON tickets.session_id = sessions.id
    GROUP BY sessions.id
    ORDER BY sessions.id
) as tickets
  JOIN sessions ON sessions.id = tickets.session_id
  JOIN halls ON sessions.hall_id = halls.id
  JOIN films ON sessions.film_id = films.id
ORDER BY films.id
```
Explain Analyze:
```
Sort  (cost=2125.19..2128.06 rows=1149 width=96) (actual time=54.085..54.159 rows=1149 loops=1)
  Sort Key: films.id
  Sort Method: quicksort  Memory: 218kB
  ->  Hash Join  (cost=2034.34..2066.78 rows=1149 width=96) (actual time=51.923..53.157 rows=1149 loops=1)
        Hash Cond: (sessions.film_id = films.id)
        ->  Hash Join  (cost=1997.34..2023.88 rows=1149 width=58) (actual time=51.813..52.711 rows=1149 loops=1)
              Hash Cond: (sessions.hall_id = halls.id)
              ->  Hash Join  (cost=1960.34..1983.86 rows=1149 width=28) (actual time=51.709..52.293 rows=1149 loops=1)
                    Hash Cond: (sessions.id = tickets.session_id)
                    ->  Seq Scan on sessions  (cost=0.00..20.49 rows=1149 width=20) (actual time=0.012..0.200 rows=1149 loops=1)
                    ->  Hash  (cost=1945.98..1945.98 rows=1149 width=12) (actual time=51.641..51.641 rows=1149 loops=1)
                          Buckets: 2048  Batches: 1  Memory Usage: 66kB
                          ->  Subquery Scan on tickets  (cost=1931.61..1945.98 rows=1149 width=12) (actual time=51.045..51.306 rows=1149 loops=1)
                                ->  Sort  (cost=1931.61..1934.49 rows=1149 width=12) (actual time=51.042..51.137 rows=1149 loops=1)
                                      Sort Key: sessions_1.id
                                      Sort Method: quicksort  Memory: 102kB
                                      ->  HashAggregate  (cost=1861.72..1873.21 rows=1149 width=12) (actual time=50.265..50.513 rows=1149 loops=1)
                                            Group Key: sessions_1.id
                                            ->  Hash Join  (cost=34.85..1465.38 rows=79268 width=8) (actual time=0.654..34.284 rows=79268 loops=1)
                                                  Hash Cond: (tickets_1.session_id = sessions_1.id)
                                                  ->  Seq Scan on tickets tickets_1  (cost=0.00..1221.68 rows=79268 width=8) (actual time=0.013..13.613 rows=79268 loops=1)
                                                  ->  Hash  (cost=20.49..20.49 rows=1149 width=4) (actual time=0.564..0.565 rows=1149 loops=1)
                                                        Buckets: 2048  Batches: 1  Memory Usage: 57kB
                                                        ->  Seq Scan on sessions sessions_1  (cost=0.00..20.49 rows=1149 width=4) (actual time=0.010..0.278 rows=1149 loops=1)
              ->  Hash  (cost=22.00..22.00 rows=1200 width=38) (actual time=0.041..0.041 rows=14 loops=1)
                    Buckets: 2048  Batches: 1  Memory Usage: 17kB
                    ->  Seq Scan on halls  (cost=0.00..22.00 rows=1200 width=38) (actual time=0.015..0.018 rows=14 loops=1)
        ->  Hash  (cost=22.00..22.00 rows=1200 width=36) (actual time=0.053..0.053 rows=22 loops=1)
              Buckets: 2048  Batches: 1  Memory Usage: 18kB
              ->  Seq Scan on films  (cost=0.00..22.00 rows=1200 width=36) (actual time=0.018..0.022 rows=22 loops=1)
Planning Time: 2.062 ms
Execution Time: 54.867 ms
```


### Фильмы с продолжительностью 120 минут (2 часа) и больше
``` SELECT * FROM films WHERE duration >= 120*60 ```

Explain Analyze:
```
Seq Scan on films  (cost=0.00..25.00 rows=400 width=40) (actual time=0.039..0.042 rows=6 loops=1)
  Filter: (duration >= 7200)
  Rows Removed by Filter: 16
Planning Time: 0.350 ms
Execution Time: 0.072 ms
```

После добавления индекса  
`CREATE INDEX "films_duration" ON "films" ("duration");`

```
Seq Scan on films  (cost=0.00..1.27 rows=7 width=40) (actual time=0.050..0.053 rows=6 loops=1)
  Filter: (duration >= 7200)
  Rows Removed by Filter: 16
Planning Time: 0.887 ms
Execution Time: 0.064 ms
```
Поскольку данных мало - индекс не использовался


### Фильмы с возрастным рейтингом 21+
```
SELECT *
FROM "film_attributes_values"
WHERE "attribute_id" = '17' AND "value_numeric" >= '21'
```
Explain Analyze без индекса
```
Seq Scan on film_attributes_values  (cost=0.00..15.89 rows=5 width=36) (actual time=0.053..0.238 rows=18 loops=1)
  Filter: ((value_numeric >= '21'::numeric) AND (attribute_id = 17))
  Rows Removed by Filter: 708
Planning Time: 1.762 ms
Execution Time: 0.267 ms
```

С использованием индекса  
`CREATE INDEX "film_attributes_values_value_numeric" ON "film_attributes_values" ("value_numeric");`
```
Bitmap Heap Scan on film_attributes_values  (cost=5.45..12.79 rows=5 width=36) (actual time=0.252..0.387 rows=18 loops=1)
  Recheck Cond: (value_numeric >= '21'::numeric)
  Filter: (attribute_id = 17)
  Rows Removed by Filter: 137
  Heap Blocks: exact=5
  ->  Bitmap Index Scan on film_attributes_values_value_numeric  (cost=0.00..5.45 rows=156 width=0) (actual time=0.201..0.201 rows=155 loops=1)
        Index Cond: (value_numeric >= '21'::numeric)
Planning Time: 2.103 ms
Execution Time: 0.521 ms
```


### Билеты на сеанс №20
```
SELECT
  * 
FROM tickets
  JOIN sessions ON sessions.id = tickets.session_id
WHERE sessions.id = 20
```
Explain Analyze
```
Nested Loop  (cost=0.28..1428.76 rows=62 width=40) (actual time=0.496..13.882 rows=109 loops=1)
  ->  Index Scan using sessions_pk on sessions  (cost=0.28..8.29 rows=1 width=24) (actual time=0.077..0.082 rows=1 loops=1)
        Index Cond: (id = 20)
  ->  Seq Scan on tickets  (cost=0.00..1419.85 rows=62 width=16) (actual time=0.413..13.773 rows=109 loops=1)
        Filter: (session_id = 20)
        Rows Removed by Filter: 79159
Planning Time: 0.899 ms
Execution Time: 13.982 ms
```

С использованием индекса на tickets.session_id  
`CREATE INDEX "tickets_session_id" ON "tickets" ("session_id");`
```
Nested Loop  (cost=0.70..18.42 rows=62 width=40) (actual time=0.267..0.341 rows=109 loops=1)
  ->  Index Scan using sessions_pk on sessions  (cost=0.28..8.29 rows=1 width=24) (actual time=0.090..0.091 rows=1 loops=1)
        Index Cond: (id = 20)
  ->  Index Scan using tickets_session_id on tickets  (cost=0.42..9.50 rows=62 width=16) (actual time=0.170..0.212 rows=109 loops=1)
        Index Cond: (session_id = 20)
Planning Time: 1.509 ms
Execution Time: 0.438 ms
```