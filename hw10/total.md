```
SELECT nspname || '.' || relname as name,
    pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
    pg_size_pretty(pg_relation_size(C.oid)) as rolsize
    FROM pg_class as C
    LEFT JOIN pg_namespace as N ON (N.oid = C.relnamespace)
    WHERE nspname NOT IN ('pg catalog', 'information_schema')
    ORDER BY pg_total_relation_size(C.oid) DESC
    LIMIT 15;
 
```

Cамых больших по размеру объектов БД 

1) homework.seats_hall	8133 MB	3189 MB
2) homework.sessions	6678 MB	6247 MB
3) homework.halls	6375 MB	3005 MB
4) homework.client	5796 MB	5580 MB
5) homework.seats_hall_series_number_hall_id_key	4722 MB	4722 MB
6) homework.movies	3220 MB	3005 MB
7) homework.cinemas	3220 MB	3005 MB
8) homework.index_title	3155 MB	3155 MB
9) homework.tickets	1295 MB	651 MB
10) homework.movies_attributes	959 MB	745 MB
11) homework.seats_hall_pkey	222 MB	222 MB
12) homework.index_movie_id	215 MB	215 MB
13) homework.index_cost	215 MB	215 MB
14) homework.index_client_id	215 MB	215 MB
15) homework.movies_pkey	214 MB	214 MB



самые часто используемые индексы

| table_name  | index_name  | index_scans_count  | index_size | table_reads_index_count | table_reads_seq_count | table_reads_count | table_writes_count | table_size |
| ------------- |:-------------:| -----:| -----:| -----:| -----:| -----:| -----:| -----:|
sessions | sessions_pkey | 18 | 214 MB | 22 | 18 | 40 | 0 | 6247 MB
halls | index_title | 6 | 3155 MB | 12 | 5 | 17 | 0 | 3005 MB
halls | halls_pkey | 6 | 214 MB | 12 | 5 | 17 | 0 | 3005 MB
sessions | index_movie_id | 4 | 215 MB | 22 | 18 | 40 | 0 | 6247 MB
movies | movies_pkey | 4 | 214 MB | 4 | 0 | 4 | 0 | 3005 MB
```
SELECT
    idstat.relname AS TABLE_NAME, -- имя таблицы
    indexrelname AS index_name, -- индекс
    idstat.idx_scan AS index_scans_count, -- число сканирований по этому индексу
    pg_size_pretty(pg_relation_size(indexrelid)) AS index_size, -- размер индекса
    tabstat.idx_scan AS table_reads_index_count, -- индексных чтений по таблице
    tabstat.seq_scan AS table_reads_seq_count, -- последовательных чтений по таблице
    tabstat.seq_scan + tabstat.idx_scan AS table_reads_count, -- чтений по таблице
    n_tup_upd + n_tup_ins + n_tup_del AS table_writes_count, -- операций записи
    pg_size_pretty(pg_relation_size(idstat.relid)) AS table_size -- размер таблицы
FROM
    pg_stat_user_indexes AS idstat
JOIN
    pg_indexes
    ON
    indexrelname = indexname
    AND
    idstat.schemaname = pg_indexes.schemaname
JOIN
    pg_stat_user_tables AS tabstat
    ON
    idstat.relid = tabstat.relid
ORDER BY
    idstat.idx_scan DESC,
    pg_relation_size(indexrelid) DESC
LIMIT 5
```



самые редко используемые индексы

| table_name  | index_name  | index_scans_count  | index_size | table_reads_index_count | table_reads_seq_count | table_reads_count | table_writes_count | table_size |
| ------------- |:-------------:| -----:| -----:| -----:| -----:| -----:| -----:| -----:|
cinemas | cinemas_pkey | 0 | 8192 bytes | 0 | 0 | 0 | 0 | 0 bytes
movies_attributes_types | movies_attributes_types_pkey | 0 | 16 kB | 0 | 0 | 0 | 0 | 8192 bytes
movies_attributes_values | movies_attributes_values_pkey | 0 | 240 kB | 0 | 0 | 0 | 0 | 608 kB
movies_attributes | movies_attributes_pkey | 0 | 214 MB | 0 | 0 | 0 | 0 | 745 MB
tickets | tickets_pkey | 0 | 214 MB | 3 | 23 | 26 | 0 | 651 MB
```
SELECT
    idstat.relname AS TABLE_NAME, -- имя таблицы
    indexrelname AS index_name, -- индекс
    idstat.idx_scan AS index_scans_count, -- число сканирований по этому индексу
    pg_size_pretty(pg_relation_size(indexrelid)) AS index_size, -- размер индекса
    tabstat.idx_scan AS table_reads_index_count, -- индексных чтений по таблице
    tabstat.seq_scan AS table_reads_seq_count, -- последовательных чтений по таблице
    tabstat.seq_scan + tabstat.idx_scan AS table_reads_count, -- чтений по таблице
    n_tup_upd + n_tup_ins + n_tup_del AS table_writes_count, -- операций записи
    pg_size_pretty(pg_relation_size(idstat.relid)) AS table_size -- размер таблицы
FROM
    pg_stat_user_indexes AS idstat
JOIN
    pg_indexes
    ON
    indexrelname = indexname
    AND
    idstat.schemaname = pg_indexes.schemaname
JOIN
    pg_stat_user_tables AS tabstat
    ON
    idstat.relid = tabstat.relid
ORDER BY
    idstat.idx_scan ASC,
    pg_relation_size(indexrelid) ASC
LIMIT 5
```

