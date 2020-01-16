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
Sort  (cost=31237.27..31262.33 rows=10022 width=51) (actual time=1289.339..1289.948 rows=7235 loops=1)
  Sort Key: (sum(prices.price))
  Sort Method: quicksort  Memory: 758kB
  ->  Finalize HashAggregate  (cost=30445.99..30571.26 rows=10022 width=51) (actual time=1280.020..1284.309 rows=7235 loops=1)
        Group Key: films.name
        ->  Gather  (cost=28115.87..30245.55 rows=20044 width=51) (actual time=1248.404..1256.265 rows=14690 loops=1)
              Workers Planned: 2
              Workers Launched: 2
              ->  Partial HashAggregate  (cost=27115.87..27241.15 rows=10022 width=51) (actual time=1240.546..1245.325 rows=4897 loops=3)
                    Group Key: films.name
                    ->  Hash Join  (cost=717.88..21954.36 rows=688202 width=31) (actual time=26.487..918.967 rows=550561 loops=3)
                          Hash Cond: (tickets.price_id = prices.id)
                          ->  Hash Join  (cost=669.63..20095.07 rows=688202 width=19) (actual time=26.355..701.187 rows=550561 loops=3)
                                Hash Cond: (sessions.film_id = films.id)
                                ->  Hash Join  (cost=380.13..17998.28 rows=688202 width=12) (actual time=10.401..470.823 rows=550561 loops=3)
                                      Hash Cond: (tickets.session_id = sessions.id)
                                      ->  Parallel Seq Scan on tickets  (cost=0.00..15811.02 rows=688202 width=12) (actual time=0.126..199.236 rows=550561 loops=3)
                                      ->  Hash  (cost=221.17..221.17 rows=12717 width=8) (actual time=10.140..10.140 rows=12717 loops=3)
                                            Buckets: 16384  Batches: 1  Memory Usage: 625kB
                                            ->  Seq Scan on sessions  (cost=0.00..221.17 rows=12717 width=8) (actual time=0.029..7.008 rows=12717 loops=3)
                                ->  Hash  (cost=164.22..164.22 rows=10022 width=15) (actual time=15.825..15.825 rows=10022 loops=3)
                                      Buckets: 16384  Batches: 1  Memory Usage: 599kB
                                      ->  Seq Scan on films  (cost=0.00..164.22 rows=10022 width=15) (actual time=0.027..8.796 rows=10022 loops=3)
                          ->  Hash  (cost=27.00..27.00 rows=1700 width=20) (actual time=0.059..0.059 rows=40 loops=3)
                                Buckets: 2048  Batches: 1  Memory Usage: 18kB
                                ->  Seq Scan on prices  (cost=0.00..27.00 rows=1700 width=20) (actual time=0.026..0.034 rows=40 loops=3)
Planning Time: 1.702 ms
Execution Time: 1291.986 ms
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
Sort  (cost=31070.42..31096.71 rows=10514 width=44) (actual time=922.588..922.596 rows=121 loops=1)
  Sort Key: (date(sessions.start_time))
  Sort Method: quicksort  Memory: 34kB
  ->  Finalize HashAggregate  (cost=30210.38..30368.09 rows=10514 width=44) (actual time=922.303..922.432 rows=121 loops=1)
        Group Key: (date(sessions.start_time))
        ->  Gather  (cost=27739.59..30000.10 rows=21028 width=44) (actual time=921.656..922.077 rows=343 loops=1)
              Workers Planned: 2
              Workers Launched: 2
              ->  Partial HashAggregate  (cost=26739.59..26897.30 rows=10514 width=44) (actual time=911.047..911.203 rows=114 loops=3)
                    Group Key: date(sessions.start_time)
                    ->  Hash Join  (cost=428.38..21578.07 rows=688202 width=24) (actual time=13.827..678.954 rows=550561 loops=3)
                          Hash Cond: (tickets.price_id = prices.id)
                          ->  Hash Join  (cost=380.13..17998.28 rows=688202 width=16) (actual time=13.656..432.337 rows=550561 loops=3)
                                Hash Cond: (tickets.session_id = sessions.id)
                                ->  Parallel Seq Scan on tickets  (cost=0.00..15811.02 rows=688202 width=12) (actual time=0.070..184.454 rows=550561 loops=3)
                                ->  Hash  (cost=221.17..221.17 rows=12717 width=12) (actual time=13.382..13.383 rows=12717 loops=3)
                                      Buckets: 16384  Batches: 1  Memory Usage: 675kB
                                      ->  Seq Scan on sessions  (cost=0.00..221.17 rows=12717 width=12) (actual time=0.025..2.748 rows=12717 loops=3)
                          ->  Hash  (cost=27.00..27.00 rows=1700 width=20) (actual time=0.067..0.067 rows=40 loops=3)
                                Buckets: 2048  Batches: 1  Memory Usage: 18kB
                                ->  Seq Scan on prices  (cost=0.00..27.00 rows=1700 width=20) (actual time=0.028..0.034 rows=40 loops=3)
Planning Time: 2.203 ms
Execution Time: 924.549 ms
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
Merge Join  (cost=27954.65..28539.54 rows=12717 width=75) (actual time=647.044..658.655 rows=12717 loops=1)
  Merge Cond: (films.id = sessions.film_id)
  ->  Index Scan using films_pk on films  (cost=0.29..337.62 rows=10022 width=15) (actual time=0.029..3.904 rows=10022 loops=1)
  ->  Sort  (cost=27954.36..27986.15 rows=12717 width=58) (actual time=647.001..648.989 rows=12717 loops=1)
        Sort Key: sessions.film_id
        Sort Method: quicksort  Memory: 1946kB
        ->  Hash Join  (cost=26268.43..27087.41 rows=12717 width=58) (actual time=619.373..640.351 rows=12717 loops=1)
              Hash Cond: (sessions.hall_id = halls.id)
              ->  Merge Join  (cost=26231.43..27016.91 rows=12717 width=28) (actual time=619.219..636.146 rows=12717 loops=1)
                    Merge Cond: (sessions_1.id = sessions.id)
                    ->  Sort  (cost=26231.15..26262.94 rows=12717 width=12) (actual time=619.166..621.363 rows=12717 loops=1)
                          Sort Key: sessions_1.id
                          Sort Method: quicksort  Memory: 981kB
                          ->  Finalize HashAggregate  (cost=25237.03..25364.20 rows=12717 width=12) (actual time=612.252..614.469 rows=12717 loops=1)
                                Group Key: sessions_1.id
                                ->  Gather  (cost=22439.29..25109.86 rows=25434 width=12) (actual time=594.702..603.614 rows=20184 loops=1)
                                      Workers Planned: 2
                                      Workers Launched: 2
                                      ->  Partial HashAggregate  (cost=21439.29..21566.46 rows=12717 width=12) (actual time=580.329..582.096 rows=6728 loops=3)
                                            Group Key: sessions_1.id
                                            ->  Hash Join  (cost=380.13..17998.28 rows=688202 width=8) (actual time=13.937..403.560 rows=550561 loops=3)
                                                  Hash Cond: (tickets.session_id = sessions_1.id)
                                                  ->  Parallel Seq Scan on tickets  (cost=0.00..15811.02 rows=688202 width=8) (actual time=0.100..180.051 rows=550561 loops=3)
                                                  ->  Hash  (cost=221.17..221.17 rows=12717 width=4) (actual time=13.427..13.428 rows=12717 loops=3)
                                                        Buckets: 16384  Batches: 1  Memory Usage: 576kB
                                                        ->  Seq Scan on sessions sessions_1  (cost=0.00..221.17 rows=12717 width=4) (actual time=0.047..6.569 rows=12717 loops=3)
                    ->  Index Scan using sessions_pk on sessions  (cost=0.29..436.04 rows=12717 width=20) (actual time=0.045..9.277 rows=12717 loops=1)
              ->  Hash  (cost=22.00..22.00 rows=1200 width=38) (actual time=0.104..0.104 rows=14 loops=1)
                    Buckets: 2048  Batches: 1  Memory Usage: 17kB
                    ->  Seq Scan on halls  (cost=0.00..22.00 rows=1200 width=38) (actual time=0.064..0.068 rows=14 loops=1)
Planning Time: 2.235 ms
Execution Time: 661.756 ms
```



### Фильмы с продолжительностью 120 минут (2 часа) и больше
```
SELECT * FROM films WHERE duration >= 120*60
```

Explain Analyze:
```
Seq Scan on films  (cost=0.00..189.28 rows=2995 width=19) (actual time=0.034..2.937 rows=2995 loops=1)
  Filter: (duration >= 7200)
  Rows Removed by Filter: 7027
Planning Time: 0.676 ms
Execution Time: 3.261 ms
```

После добавления индекса  
`CREATE INDEX "films_duration" ON "films" ("duration");`

```
Bitmap Heap Scan on films  (cost=59.50..160.93 rows=2995 width=19) (actual time=0.380..0.945 rows=2995 loops=1)
  Recheck Cond: (duration >= 7200)
  Heap Blocks: exact=64
  ->  Bitmap Index Scan on films_duration  (cost=0.00..58.75 rows=2995 width=0) (actual time=0.343..0.343 rows=2995 loops=1)
        Index Cond: (duration >= 7200)
Planning Time: 0.498 ms
Execution Time: 1.114 ms
```

### Фильмы с возрастным рейтингом 21+
```
SELECT *
FROM "film_attributes_values"
WHERE "attribute_id" = '17' AND "value_numeric" >= '21'
```
Explain Analyze без индекса
```
Gather  (cost=1000.00..6230.87 rows=2307 width=36) (actual time=1.235..75.143 rows=7901 loops=1)
  Workers Planned: 1
  Workers Launched: 1
  ->  Parallel Seq Scan on film_attributes_values  (cost=0.00..5000.17 rows=1357 width=36) (actual time=0.072..67.475 rows=3950 loops=2)
        Filter: ((value_numeric >= '21'::numeric) AND (attribute_id = 17))
        Rows Removed by Filter: 161412
Planning Time: 0.781 ms
Execution Time: 75.746 ms
```

С использованием индекса  
`CREATE INDEX "film_attributes_values_value_numeric" ON "film_attributes_values" ("value_numeric");`
```
Bitmap Heap Scan on film_attributes_values  (cost=1337.61..4500.82 rows=2307 width=36) (actual time=13.930..33.682 rows=7901 loops=1)
  Recheck Cond: (value_numeric >= '21'::numeric)
  Filter: (attribute_id = 17)
  Rows Removed by Filter: 63637
  Heap Blocks: exact=2082
  ->  Bitmap Index Scan on film_attributes_values_value_numeric  (cost=0.00..1337.03 rows=72081 width=0) (actual time=13.565..13.565 rows=71538 loops=1)
        Index Cond: (value_numeric >= '21'::numeric)
Planning Time: 1.519 ms
Execution Time: 34.335 ms
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
Nested Loop  (cost=1000.28..18555.22 rows=140 width=40) (actual time=3.296..157.330 rows=227 loops=1)
  ->  Index Scan using sessions_pk on sessions  (cost=0.29..8.30 rows=1 width=24) (actual time=0.064..0.069 rows=1 loops=1)
        Index Cond: (id = 20)
  ->  Gather  (cost=1000.00..18545.52 rows=140 width=16) (actual time=3.225..159.738 rows=227 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Parallel Seq Scan on tickets  (cost=0.00..17531.52 rows=58 width=16) (actual time=97.376..148.687 rows=76 loops=3)
              Filter: (session_id = 20)
              Rows Removed by Filter: 550486
Planning Time: 1.035 ms
Execution Time: 159.981 ms
```

С использованием индекса на tickets.session_id
`CREATE INDEX "tickets_session_id" ON "tickets" ("session_id");`
```
Nested Loop  (cost=0.71..20.58 rows=140 width=40) (actual time=0.234..0.339 rows=227 loops=1)
  ->  Index Scan using sessions_pk on sessions  (cost=0.29..8.30 rows=1 width=24) (actual time=0.051..0.051 rows=1 loops=1)
        Index Cond: (id = 20)
  ->  Index Scan using tickets_session_id on tickets  (cost=0.43..10.88 rows=140 width=16) (actual time=0.178..0.240 rows=227 loops=1)
        Index Cond: (session_id = 20)
Planning Time: 0.989 ms
Execution Time: 0.419 ms
```

