## Запросы

10 самых дорогих сеансов
```
SELECT id, film_id, date_start, price
FROM seances
ORDER BY price DESC
LIMIT 10;
```

Фильмы, получившие Золотой глобус
```
SELECT f.id, f.title
FROM films AS f
INNER JOIN films_attr_values AS fav ON fav.film_id = f.id
WHERE fav.attr_id = 6 AND fav.val_bool;
```

Фильмы, премьера в мире которых ещё не состоялась
```
SELECT f.title, fav.val_date 
FROM films AS f
INNER JOIN films_attr_values AS fav ON fav.film_id = f.id
WHERE fav.attr_id = 2 AND fav.val_date > NOW()
ORDER BY fav.val_date;
```

Сеансы, на которые куплено 500+ билетов
```
WITH stats AS (
    SELECT s.id AS seance_id, COUNT(t.id) AS tickets_count
    FROM seances AS s
    INNER JOIN tickets AS t ON t.seance_id = s.id
    GROUP BY s.id
)
SELECT seance_id, tickets_count
FROM stats
WHERE tickets_count >= 500
ORDER BY tickets_count DESC;
```

Самый прибыльный фильм
```
SELECT f.id AS film_id, f.title, SUM(s.price)
FROM films AS f
INNER JOIN seances AS s ON s.film_id = f.id
INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY f.id, f.title
ORDER BY SUM(s.price) DESC
LIMIT 10;
```

Посещаемость залов за диапазон дат
```
SELECT h.id AS hall_id, h.title, COUNT(t.id) AS tickets_count
FROM tickets AS t
INNER JOIN seances AS s ON t.seance_id = s.id
INNER JOIN halls AS h ON s.hall_id = h.id
WHERE s.date_start BETWEEN '2021-01-01' AND '2021-01-07'
GROUP BY h.id, h.title
ORDER BY COUNT(t.id) DESC;
```

## Анализ на 10 000 фильмов

##### 10 самых дорогих сеансов
```
EXPLAIN SELECT id, film_id, date_start, price
FROM seances
ORDER BY price DESC
LIMIT 10;

"Limit  (cost=39.61..39.63 rows=10 width=21)"
"  ->  Sort  (cost=39.61..42.11 rows=1000 width=21)"
"        Sort Key: price DESC"
"        ->  Seq Scan on seances  (cost=0.00..18.00 rows=1000 width=21)"
```

добавим индекс на price

```
CREATE INDEX i_seances_price ON seances USING btree(price);
```

получаем значительное ускорение

```
"Limit  (cost=0.28..0.94 rows=10 width=21)"
"  ->  Index Scan Backward using i_seances_price on seances  (cost=0.28..67.27 rows=1000 width=21)"
```

##### Фильмы, получившие Золотой глобус
```
EXPLAIN SELECT f.id, f.title
FROM films AS f
INNER JOIN films_attr_values AS fav ON fav.film_id = f.id
WHERE fav.attr_id = 6 AND fav.val_bool;

"Hash Join  (cost=1945.38..2155.64 rows=990 width=20)"
"  Hash Cond: (f.id = fav.film_id)"
"  ->  Seq Scan on films f  (cost=0.00..184.00 rows=10000 width=20)"
"  ->  Hash  (cost=1933.00..1933.00 rows=990 width=4)"
"        ->  Seq Scan on films_attr_values fav  (cost=0.00..1933.00 rows=990 width=4)"
"              Filter: (val_bool AND (attr_id = 6))"
```

добавим индексы на fav.film_id, fav.attr_id, fav.val_bool

```
CREATE INDEX i_fav_film_id ON films_attr_values USING btree(film_id);
CREATE INDEX i_fav_attr_id ON films_attr_values USING btree(attr_id);
CREATE INDEX i_fav_val_bool ON films_attr_values USING btree(val_bool);
```

получаем прирост скорости в 2 раза

```
"Hash Join  (cost=927.25..1137.52 rows=990 width=20)"
"  Hash Cond: (f.id = fav.film_id)"
"  ->  Seq Scan on films f  (cost=0.00..184.00 rows=10000 width=20)"
"  ->  Hash  (cost=914.88..914.88 rows=990 width=4)"
"        ->  Bitmap Heap Scan on films_attr_values fav  (cost=109.79..914.88 rows=990 width=4)"
"              Filter: (val_bool AND (attr_id = 6))"
"              ->  Bitmap Index Scan on i_fav_val_bool  (cost=0.00..109.55 rows=9767 width=0)"
"                    Index Cond: (val_bool = true)"
```

пробуем добавить составной индекс на 2 поля

```
CREATE INDEX i_fav_has_golden_globus 
ON films_attr_values 
USING btree(attr_id, val_bool)
WHERE val_bool AND attr_id = 6;
```

получаем небольшое ускорение

```
"Hash Join  (cost=755.61..965.87 rows=990 width=20)"
"  Hash Cond: (f.id = fav.film_id)"
"  ->  Seq Scan on films f  (cost=0.00..184.00 rows=10000 width=20)"
"  ->  Hash  (cost=743.23..743.23 rows=990 width=4)"
"        ->  Bitmap Heap Scan on films_attr_values fav  (cost=13.48..743.23 rows=990 width=4)"
"              Recheck Cond: (val_bool AND (attr_id = 6))"
"              ->  Bitmap Index Scan on i_fav_has_golden_globus  (cost=0.00..13.23 rows=990 width=0)"
```

##### Фильмы, премьера в мире которых еще не состоялась
```
EXPLAIN SELECT f.title, fav.val_date 
FROM films AS f
INNER JOIN films_attr_values AS fav ON fav.film_id = f.id
WHERE fav.attr_id = 2 AND fav.val_date > NOW()
ORDER BY fav.val_date;

"Sort  (cost=1356.00..1362.53 rows=2613 width=20)"
"  Sort Key: fav.val_date"
"  ->  Hash Join  (cost=997.43..1207.69 rows=2613 width=20)"
"        Hash Cond: (f.id = fav.film_id)"
"        ->  Seq Scan on films f  (cost=0.00..184.00 rows=10000 width=20)"
"        ->  Hash  (cost=964.77..964.77 rows=2613 width=8)"
"              ->  Bitmap Heap Scan on films_attr_values fav  (cost=110.39..964.77 rows=2613 width=8)"
"                    Recheck Cond: (attr_id = 2)"
"                    Filter: (val_date > now())"
"                    ->  Bitmap Index Scan on i_fav_attr_id  (cost=0.00..109.74 rows=9793 width=0)"
"                          Index Cond: (attr_id = 2)"
```
часть индексов уже есть, добавим индекс на val_date
```
CREATE INDEX i_fav_val_date ON films_attr_values USING btree(val_date);
```
прироста в скорости нет, возможно на большем количестве записей такой индекс поможет
```
"Sort  (cost=1356.00..1362.53 rows=2613 width=20)"
"  Sort Key: fav.val_date"
"  ->  Hash Join  (cost=997.43..1207.69 rows=2613 width=20)"
"        Hash Cond: (f.id = fav.film_id)"
"        ->  Seq Scan on films f  (cost=0.00..184.00 rows=10000 width=20)"
"        ->  Hash  (cost=964.77..964.77 rows=2613 width=8)"
"              ->  Bitmap Heap Scan on films_attr_values fav  (cost=110.39..964.77 rows=2613 width=8)"
"                    Recheck Cond: (attr_id = 2)"
"                    Filter: (val_date > now())"
"                    ->  Bitmap Index Scan on i_fav_attr_id  (cost=0.00..109.74 rows=9793 width=0)"
"                          Index Cond: (attr_id = 2)"
```

##### Сеансы, на которые куплено 500+ билетов
```
EXPLAIN WITH stats AS (
    SELECT s.id AS seance_id, COUNT(t.id) AS tickets_count
    FROM seances AS s
    INNER JOIN tickets AS t ON t.seance_id = s.id
    GROUP BY s.id
)
SELECT seance_id, tickets_count
FROM stats
WHERE tickets_count >= 500
ORDER BY tickets_count DESC;

"Sort  (cost=7947.13..7947.96 rows=333 width=12)"
"  Sort Key: (count(t.id)) DESC"
"  ->  Finalize GroupAggregate  (cost=7794.85..7929.85 rows=333 width=12)"
"        Group Key: s.id"
"        Filter: (count(t.id) >= 500)"
"        ->  Gather Merge  (cost=7794.85..7909.85 rows=1000 width=12)"
"              Workers Planned: 1"
"              ->  Sort  (cost=6794.84..6797.34 rows=1000 width=12)"
"                    Sort Key: s.id"
"                    ->  Partial HashAggregate  (cost=6735.01..6745.01 rows=1000 width=12)"
"                          Group Key: s.id"
"                          ->  Hash Join  (cost=30.50..5485.44 rows=249914 width=8)"
"                                Hash Cond: (t.seance_id = s.id)"
"                                ->  Parallel Seq Scan on tickets t  (cost=0.00..4796.14 rows=249914 width=8)"
"                                ->  Hash  (cost=18.00..18.00 rows=1000 width=4)"
"                                      ->  Seq Scan on seances s  (cost=0.00..18.00 rows=1000 width=4)"
```
добавим индекс на t.seance_id
```
CREATE INDEX i_tickets_seance_id ON tickets USING btree(seance_id);

"Sort  (cost=7947.13..7947.96 rows=333 width=12)"
"  Sort Key: (count(t.id)) DESC"
"  ->  Finalize GroupAggregate  (cost=7794.85..7929.85 rows=333 width=12)"
"        Group Key: s.id"
"        Filter: (count(t.id) >= 500)"
"        ->  Gather Merge  (cost=7794.85..7909.85 rows=1000 width=12)"
"              Workers Planned: 1"
"              ->  Sort  (cost=6794.84..6797.34 rows=1000 width=12)"
"                    Sort Key: s.id"
"                    ->  Partial HashAggregate  (cost=6735.01..6745.01 rows=1000 width=12)"
"                          Group Key: s.id"
"                          ->  Hash Join  (cost=30.50..5485.44 rows=249914 width=8)"
"                                Hash Cond: (t.seance_id = s.id)"
"                                ->  Parallel Seq Scan on tickets t  (cost=0.00..4796.14 rows=249914 width=8)"
"                                ->  Hash  (cost=18.00..18.00 rows=1000 width=4)"
"                                      ->  Seq Scan on seances s  (cost=0.00..18.00 rows=1000 width=4)"
```
прироста нет

##### Самый прибыльный фильм
```
EXPLAIN SELECT f.id AS film_id, f.title, SUM(s.price)
FROM films AS f
INNER JOIN seances AS s ON s.film_id = f.id
INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY f.id, f.title
ORDER BY SUM(s.price) DESC
LIMIT 10;

"Limit  (cost=10241.41..10241.43 rows=10 width=52)"
"  ->  Sort  (cost=10241.41..10266.41 rows=10000 width=52)"
"        Sort Key: (sum(s.price)) DESC"
"        ->  Finalize HashAggregate  (cost=9900.31..10025.31 rows=10000 width=52)"
"              Group Key: f.id"
"              ->  Gather  (cost=8700.31..9825.31 rows=10000 width=52)"
"                    Workers Planned: 1"
"                    ->  Partial HashAggregate  (cost=7700.31..7825.31 rows=10000 width=52)"
"                          Group Key: f.id"
"                          ->  Hash Join  (cost=339.50..6450.74 rows=249914 width=25)"
"                                Hash Cond: (s.film_id = f.id)"
"                                ->  Hash Join  (cost=30.50..5485.44 rows=249914 width=9)"
"                                      Hash Cond: (t.seance_id = s.id)"
"                                      ->  Parallel Seq Scan on tickets t  (cost=0.00..4796.14 rows=249914 width=4)"
"                                      ->  Hash  (cost=18.00..18.00 rows=1000 width=13)"
"                                            ->  Seq Scan on seances s  (cost=0.00..18.00 rows=1000 width=13)"
"                                ->  Hash  (cost=184.00..184.00 rows=10000 width=20)"
"                                      ->  Seq Scan on films f  (cost=0.00..184.00 rows=10000 width=20)"
```
добавим индекс на film_id
```
CREATE INDEX i_seances_film_id ON seances USING btree(film_id);
```
прироста в скорости нет

##### Посещаемость залов за диапазон дат
```
EXPLAIN SELECT h.id AS hall_id, h.title, COUNT(t.id) AS tickets_count
FROM tickets AS t
INNER JOIN seances AS s ON t.seance_id = s.id
INNER JOIN halls AS h ON s.hall_id = h.id
WHERE s.date_start BETWEEN '2021-01-01' AND '2021-01-07'
GROUP BY h.id, h.title
ORDER BY COUNT(t.id) DESC;

"Sort  (cost=1993.30..1994.68 rows=550 width=128)"
"  Sort Key: (count(t.id)) DESC"
"  ->  HashAggregate  (cost=1962.77..1968.27 rows=550 width=128)"
"        Group Key: h.id"
"        ->  Nested Loop  (cost=22.80..1824.70 rows=27615 width=124)"
"              ->  Hash Join  (cost=22.38..45.55 rows=65 width=124)"
"                    Hash Cond: (s.hall_id = h.id)"
"                    ->  Seq Scan on seances s  (cost=0.00..23.00 rows=65 width=8)"
"                          Filter: ((date_start >= '2021-01-01 00:00:00'::timestamp without time zone) AND (date_start <= '2021-01-07 00:00:00'::timestamp without time zone))"
"                    ->  Hash  (cost=15.50..15.50 rows=550 width=120)"
"                          ->  Seq Scan on halls h  (cost=0.00..15.50 rows=550 width=120)"
"              ->  Index Scan using i_tickets_seance_id on tickets t  (cost=0.42..23.12 rows=425 width=8)"
"                    Index Cond: (seance_id = s.id)"
```
добавим индексы
```
CREATE INDEX i_seances_hall_id ON seances USING btree(hall_id);
CREATE INDEX i_seances_date_start ON seances USING btree(date_start);
```
получаем незначительный прирост за счет индекса по date_start
```
"Sort  (cost=1984.22..1985.60 rows=550 width=128)"
"  Sort Key: (count(t.id)) DESC"
"  ->  HashAggregate  (cost=1953.69..1959.19 rows=550 width=128)"
"        Group Key: h.id"
"        ->  Nested Loop  (cost=27.74..1815.61 rows=27615 width=124)"
"              ->  Hash Join  (cost=27.32..36.46 rows=65 width=124)"
"                    Hash Cond: (s.hall_id = h.id)"
"                    ->  Bitmap Heap Scan on seances s  (cost=4.94..13.92 rows=65 width=8)"
"                          Recheck Cond: ((date_start >= '2021-01-01 00:00:00'::timestamp without time zone) AND (date_start <= '2021-01-07 00:00:00'::timestamp without time zone))"
"                          ->  Bitmap Index Scan on i_seances_date_start  (cost=0.00..4.93 rows=65 width=0)"
"                                Index Cond: ((date_start >= '2021-01-01 00:00:00'::timestamp without time zone) AND (date_start <= '2021-01-07 00:00:00'::timestamp without time zone))"
"                    ->  Hash  (cost=15.50..15.50 rows=550 width=120)"
"                          ->  Seq Scan on halls h  (cost=0.00..15.50 rows=550 width=120)"
"              ->  Index Scan using i_tickets_seance_id on tickets t  (cost=0.42..23.12 rows=425 width=8)"
"                    Index Cond: (seance_id = s.id)"
```
во время анализа найдена ошибка в логике запроса, добавил приведение date_start::date, добавил индекс по этому выражению и запрос стал быстрее примерно в 10 раз
```
CREATE INDEX i_seances_date ON seances USING btree((date_start::date));

EXPLAIN SELECT h.id AS hall_id, h.title, COUNT(t.id) AS tickets_count
FROM tickets AS t
INNER JOIN seances AS s ON t.seance_id = s.id
INNER JOIN halls AS h ON s.hall_id = h.id
WHERE s.date_start::date BETWEEN '2021-01-01' AND '2021-01-07'
GROUP BY h.id, h.title
ORDER BY COUNT(t.id) DESC;

"Sort  (cost=214.07..215.45 rows=550 width=128)"
"  Sort Key: (count(t.id)) DESC"
"  ->  HashAggregate  (cost=183.54..189.04 rows=550 width=128)"
"        Group Key: h.id"
"        ->  Nested Loop  (cost=12.43..172.92 rows=2124 width=124)"
"              ->  Hash Join  (cost=12.00..32.37 rows=5 width=124)"
"                    Hash Cond: (h.id = s.hall_id)"
"                    ->  Seq Scan on halls h  (cost=0.00..15.50 rows=550 width=120)"
"                    ->  Hash  (cost=11.94..11.94 rows=5 width=8)"
"                          ->  Bitmap Heap Scan on seances s  (cost=4.33..11.94 rows=5 width=8)"
"                                Recheck Cond: (((date_start)::date >= '2021-01-01'::date) AND ((date_start)::date <= '2021-01-07'::date))"
"                                ->  Bitmap Index Scan on i_seances_date  (cost=0.00..4.33 rows=5 width=0)"
"                                      Index Cond: (((date_start)::date >= '2021-01-01'::date) AND ((date_start)::date <= '2021-01-07'::date))"
"              ->  Index Scan using i_tickets_seance_id on tickets t  (cost=0.42..23.86 rows=425 width=8)"
"                    Index Cond: (seance_id = s.id)"
```

## Анализ на 1 млн фильмов
пересоздаем пустые таблицы

заполняем таблицы записями на 1 млн фильмов

создаем на них индексы, которые создали во время анализа на 10к записей

```
CREATE INDEX i_seances_price ON seances USING btree(price);
CREATE INDEX i_fav_film_id ON films_attr_values USING btree(film_id);
CREATE INDEX i_fav_attr_id ON films_attr_values USING btree(attr_id);
CREATE INDEX i_fav_val_bool ON films_attr_values USING btree(val_bool);
CREATE INDEX i_fav_has_golden_globus 
ON films_attr_values 
USING btree(attr_id, val_bool)
WHERE val_bool AND attr_id = 6;
CREATE INDEX i_fav_val_date ON films_attr_values USING btree(val_date);
CREATE INDEX i_tickets_seance_id ON tickets USING btree(seance_id);
CREATE INDEX i_seances_film_id ON seances USING btree(film_id);
CREATE INDEX i_seances_hall_id ON seances USING btree(hall_id);
CREATE INDEX i_seances_date_start ON seances USING btree(date_start);
CREATE INDEX i_seances_date ON seances USING btree((date_start::date));
```

##### 10 самых дорогих сеансов
```
EXPLAIN SELECT id, film_id, date_start, price
FROM seances
ORDER BY price DESC
LIMIT 10;

"Limit  (cost=0.42..0.97 rows=10 width=21)"
"  ->  Index Scan Backward using i_seances_price on seances  (cost=0.42..5556.27 rows=100000 width=21)"
```
запрос работает быстро, попробуем добавить дополнительное условие
```
EXPLAIN SELECT id, film_id, date_start, price
FROM seances
WHERE date_start > '2021-04-01'
ORDER BY price DESC
LIMIT 10;

"Limit  (cost=0.42..2.68 rows=10 width=21)"
"  ->  Index Scan Backward using i_seances_price on seances  (cost=0.42..5806.27 rows=25632 width=21)"
"        Filter: (date_start > '2021-04-01 00:00:00'::timestamp without time zone)"
```
запрос работает достаточно быстро

##### Фильмы, получившие Золотой глобус
```
EXPLAIN SELECT f.id, f.title
FROM films AS f
INNER JOIN films_attr_values AS fav ON fav.film_id = f.id
WHERE fav.attr_id = 6 AND fav.val_bool;

"Gather  (cost=74610.19..98462.91 rows=102583 width=22)"
"  Workers Planned: 2"
"  ->  Parallel Hash Join  (cost=73610.19..87204.61 rows=42743 width=22)"
"        Hash Cond: (f.id = fav.film_id)"
"        ->  Parallel Seq Scan on films f  (cost=0.00..12500.67 rows=416667 width=22)"
"        ->  Parallel Hash  (cost=73075.90..73075.90 rows=42743 width=4)"
"              ->  Parallel Bitmap Heap Scan on films_attr_values fav  (cost=890.98..73075.90 rows=42743 width=4)"
"                    Recheck Cond: (val_bool AND (attr_id = 6))"
"                    ->  Bitmap Index Scan on i_fav_has_golden_globus  (cost=0.00..865.34 rows=102583 width=0)"
```
ресурсы на запрос пропорционально возросли возросшему количеству фильмов

##### Фильмы, премьера в мире которых еще не состоялась
```
EXPLAIN SELECT f.title, fav.val_date 
FROM films AS f
INNER JOIN films_attr_values AS fav ON fav.film_id = f.id
WHERE fav.attr_id = 2 AND fav.val_date > NOW()
ORDER BY fav.val_date;

"Gather Merge  (cost=153506.64..178668.50 rows=215658 width=22)"
"  Workers Planned: 2"
"  ->  Sort  (cost=152506.62..152776.19 rows=107829 width=22)"
"        Sort Key: fav.val_date"
"        ->  Parallel Hash Join  (cost=122380.56..141280.98 rows=107829 width=22)"
"              Hash Cond: (f.id = fav.film_id)"
"              ->  Parallel Seq Scan on films f  (cost=0.00..12500.67 rows=416667 width=22)"
"              ->  Parallel Hash  (cost=120610.70..120610.70 rows=107829 width=8)"
"                    ->  Parallel Bitmap Heap Scan on films_attr_values fav  (cost=10811.63..120610.70 rows=107829 width=8)"
"                          Recheck Cond: (attr_id = 2)"
"                          Filter: (val_date > now())"
"                          ->  Bitmap Index Scan on i_fav_attr_id  (cost=0.00..10746.93 rows=987000 width=0)"
"                                Index Cond: (attr_id = 2)"
"JIT:"
"  Functions: 14"
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"                   Index Cond: (attr_id = 2)"
```
добавим индекс с нужным нам условием attr_id
```
CREATE INDEX i_fav_attr_id_is_2 ON films_attr_values USING btree(attr_id) WHERE attr_id = 2;

"Gather Merge  (cost=151046.71..176207.64 rows=215650 width=22)"
"  Workers Planned: 2"
"  ->  Sort  (cost=150046.69..150316.25 rows=107825 width=22)"
"        Sort Key: fav.val_date"
"        ->  Parallel Hash Join  (cost=119921.00..138821.42 rows=107825 width=22)"
"              Hash Cond: (f.id = fav.film_id)"
"              ->  Parallel Seq Scan on films f  (cost=0.00..12500.67 rows=416667 width=22)"
"              ->  Parallel Hash  (cost=118151.19..118151.19 rows=107825 width=8)"
"                    ->  Parallel Bitmap Heap Scan on films_attr_values fav  (cost=8352.12..118151.19 rows=107825 width=8)"
"                          Recheck Cond: (attr_id = 2)"
"                          Filter: (val_date > now())"
"                          ->  Bitmap Index Scan on i_fav_attr_id_is_2  (cost=0.00..8287.42 rows=987000 width=0)"
"JIT:"
"  Functions: 14"
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
```
особого прироста не получили

##### Сеансы, на которые куплено 500+ билетов
```
EXPLAIN WITH stats AS (
    SELECT s.id AS seance_id, COUNT(t.id) AS tickets_count
    FROM seances AS s
    INNER JOIN tickets AS t ON t.seance_id = s.id
    GROUP BY s.id
)
SELECT seance_id, tickets_count
FROM stats
WHERE tickets_count >= 500
ORDER BY tickets_count DESC;

"Sort  (cost=1632900.48..1632983.82 rows=33333 width=12)"
"  Sort Key: (count(t.id)) DESC"
"  ->  Finalize GroupAggregate  (cost=1603978.10..1630063.07 rows=33333 width=12)"
"        Group Key: s.id"
"        Filter: (count(t.id) >= 500)"
"        ->  Gather Merge  (cost=1603978.10..1627313.07 rows=200000 width=12)"
"              Workers Planned: 2"
"              ->  Sort  (cost=1602978.08..1603228.08 rows=100000 width=12)"
"                    Sort Key: s.id"
"                    ->  Partial HashAggregate  (cost=1455031.40..1594673.26 rows=100000 width=12)"
"                          Group Key: s.id"
"                          Planned Partitions: 4"
"                          ->  Parallel Hash Join  (cost=2541.80..456810.01 rows=17746158 width=8)"
"                                Hash Cond: (t.seance_id = s.id)"
"                                ->  Parallel Seq Scan on tickets t  (cost=0.00..407682.58 rows=17746158 width=8)"
"                                ->  Parallel Hash  (cost=2020.96..2020.96 rows=41667 width=4)"
"                                      ->  Parallel Index Only Scan using seances_pk on seances s  (cost=0.29..2020.96 rows=41667 width=4)"
"JIT:"
"  Functions: 18"
"  Options: Inlining true, Optimization true, Expressions true, Deforming true"
```
создадим MATERIALIZED VIEW который будет содержать id сеанса и количество билетов
```
CREATE MATERIALIZED VIEW mv_seances_tickets_count
AS
SELECT s.id AS seance_id, COUNT(t.id) AS tickets_count
FROM seances AS s
INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY s.id
WITH DATA;

-- меняем запрос
EXPLAIN SELECT seance_id, tickets_count
FROM mv_seances_tickets_count
WHERE tickets_count >= 500
ORDER BY tickets_count DESC;

"Sort  (cost=4862.51..4962.93 rows=40167 width=12)"
"  Sort Key: tickets_count DESC"
"  ->  Seq Scan on mv_seances_tickets_count  (cost=0.00..1791.00 rows=40167 width=12)"
"        Filter: (tickets_count >= 500)"
```
MATERIALIZED VIEW победил тяжелый запрос, но нужно понимать, что данные этой вьюхи нужно обновлять периодически и она подходит больше для отчётов, чем для горячих данных

##### Самый прибыльный фильм
```
EXPLAIN SELECT f.id AS film_id, f.title, SUM(s.price)
FROM films AS f
INNER JOIN seances AS s ON s.film_id = f.id
INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY f.id, f.title
ORDER BY SUM(s.price) DESC
LIMIT 10;

"Limit  (cost=2692771.62..2692771.65 rows=10 width=54)"
"  ->  Sort  (cost=2692771.62..2695271.62 rows=1000000 width=54)"
"        Sort Key: (sum(s.price)) DESC"
"        ->  Finalize GroupAggregate  (cost=2410312.36..2671161.98 rows=1000000 width=54)"
"              Group Key: f.id"
"              ->  Gather Merge  (cost=2410312.36..2643661.98 rows=2000000 width=54)"
"                    Workers Planned: 2"
"                    ->  Sort  (cost=2409312.33..2411812.33 rows=1000000 width=54)"
"                          Sort Key: f.id"
"                          ->  Partial HashAggregate  (cost=1986169.24..2241292.49 rows=1000000 width=54)"
"                                Group Key: f.id"
"                                Planned Partitions: 128"
"                                ->  Parallel Hash Join  (cost=23848.68..572022.27 rows=17746158 width=27)"
"                                      Hash Cond: (t.seance_id = s.id)"
"                                      ->  Parallel Seq Scan on tickets t  (cost=0.00..407682.58 rows=17746158 width=4)"
"                                      ->  Parallel Hash  (cost=23327.84..23327.84 rows=41667 width=31)"
"                                            ->  Hash Join  (cost=3475.00..23327.84 rows=41667 width=31)"
"                                                  Hash Cond: (f.id = s.film_id)"
"                                                  ->  Parallel Seq Scan on films f  (cost=0.00..12500.67 rows=416667 width=22)"
"                                                  ->  Hash  (cost=1736.00..1736.00 rows=100000 width=13)"
"                                                        ->  Seq Scan on seances s  (cost=0.00..1736.00 rows=100000 width=13)"
"JIT:"
"  Functions: 27"
"  Options: Inlining true, Optimization true, Expressions true, Deforming true"
```
тут также поможет MV
```
CREATE MATERIALIZED VIEW mv_films_money
AS
SELECT f.id AS film_id, f.title, SUM(s.price) AS total_money
FROM films AS f
INNER JOIN seances AS s ON s.film_id = f.id
INNER JOIN tickets AS t ON t.seance_id = s.id
GROUP BY f.id, f.title
WITH DATA;

-- меняем запрос
EXPLAIN SELECT film_id, title, total_money
FROM mv_films_money
ORDER BY total_money DESC
LIMIT 10;

"Limit  (cost=3702.74..3702.76 rows=10 width=28)"
"  ->  Sort  (cost=3702.74..3940.30 rows=95026 width=28)"
"        Sort Key: total_money DESC"
"        ->  Seq Scan on mv_films_money  (cost=0.00..1649.26 rows=95026 width=28)"
```

##### Посещаемость залов за диапазон дат
```
EXPLAIN SELECT h.id AS hall_id, h.title, COUNT(t.id) AS tickets_count
FROM tickets AS t
INNER JOIN seances AS s ON t.seance_id = s.id
INNER JOIN halls AS h ON s.hall_id = h.id
WHERE s.date_start BETWEEN '2021-01-01' AND '2021-01-07'
GROUP BY h.id, h.title
ORDER BY COUNT(t.id) DESC;

"Sort  (cost=463210.05..463211.42 rows=550 width=128)"
"  Sort Key: (count(t.id)) DESC"
"  ->  Finalize GroupAggregate  (cost=463045.67..463185.01 rows=550 width=128)"
"        Group Key: h.id"
"        ->  Gather Merge  (cost=463045.67..463174.01 rows=1100 width=128)"
"              Workers Planned: 2"
"              ->  Sort  (cost=462045.65..462047.02 rows=550 width=128)"
"                    Sort Key: h.id"
"                    ->  Partial HashAggregate  (cost=462015.11..462020.61 rows=550 width=128)"
"                          Group Key: h.id"
"                          ->  Hash Join  (cost=967.30..457581.24 rows=886775 width=124)"
"                                Hash Cond: (s.hall_id = h.id)"
"                                ->  Hash Join  (cost=944.93..455213.15 rows=886775 width=8)"
"                                      Hash Cond: (t.seance_id = s.id)"
"                                      ->  Parallel Seq Scan on tickets t  (cost=0.00..407682.58 rows=17746158 width=8)"
"                                      ->  Hash  (cost=882.47..882.47 rows=4997 width=8)"
"                                            ->  Bitmap Heap Scan on seances s  (cost=71.51..882.47 rows=4997 width=8)"
"                                                  Recheck Cond: ((date_start >= '2021-01-01 00:00:00'::timestamp without time zone) AND (date_start <= '2021-01-07 00:00:00'::timestamp without time zone))"
"                                                  ->  Bitmap Index Scan on i_seances_date_start  (cost=0.00..70.26 rows=4997 width=0)"
"                                                        Index Cond: ((date_start >= '2021-01-01 00:00:00'::timestamp without time zone) AND (date_start <= '2021-01-07 00:00:00'::timestamp without time zone))"
"                                ->  Hash  (cost=15.50..15.50 rows=550 width=120)"
"                                      ->  Seq Scan on halls h  (cost=0.00..15.50 rows=550 width=120)"
"JIT:"
"  Functions: 28"
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
```
основную нагрузку в этом запросе дают JOIN, уйти от нагрузки можно с помощью денормализации или создания view, добавив идентификатор зала в таблицу билетов

