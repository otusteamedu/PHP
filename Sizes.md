# Размеры данных на примере базы с большим количеством данных
## Размеры индексов и статистика использования:

```
SELECT
    t.schemaname,
    t.tablename,
    indexname,
    c.reltuples AS num_rows,
    pg_size_pretty(pg_relation_size(quote_ident(t.schemaname)::text || '.' || quote_ident(t.tablename)::text)) AS table_size,
    pg_size_pretty(pg_relation_size(quote_ident(t.schemaname)::text || '.' || quote_ident(indexrelname)::text)) AS index_size,
    CASE WHEN indisunique THEN 'Y'
        ELSE 'N'
    END AS UNIQUE,
    number_of_scans,
    tuples_read,
    tuples_fetched
FROM pg_tables t
LEFT OUTER JOIN pg_class c ON t.tablename = c.relname
LEFT OUTER JOIN (
    SELECT
        c.relname AS ctablename,
        ipg.relname AS indexname,
        x.indnatts AS number_of_columns,
        idx_scan AS number_of_scans,
        idx_tup_read AS tuples_read,
        idx_tup_fetch AS tuples_fetched,
        indexrelname,
        indisunique,
        schemaname
    FROM pg_index x
    JOIN pg_class c ON c.oid = x.indrelid
    JOIN pg_class ipg ON ipg.oid = x.indexrelid
    JOIN pg_stat_all_indexes psai ON x.indexrelid = psai.indexrelid
) AS foo ON t.tablename = foo.ctablename AND t.schemaname = foo.schemaname
WHERE t.schemaname NOT IN ('pg_catalog', 'information_schema')
ORDER BY 1,2;
```
Результат:
```
| schemaname | tablename | indexname | num_rows | table_size | index_size | unique | number_of_scans | tuples_read | tuples_fetched |
| public | film_attributes | film_attributes_pk | 33 | 8192 bytes | 16 kB | Y | 330726 | 330726 | 330726 |
| public | film_attributes_types | film_attributes_types_pk | 4 | 8192 bytes | 16 kB | Y | 33 | 33 | 33 |
| public | film_attributes_values | film_attributes_values_film_id_idx | 330590 | 16 MB | 7328 kB | N | 0 | 0 | 0 |
| public | film_attributes_values | film_attributes_values_pk | 330590 | 16 MB | 7272 kB | Y | 0 | 0 | 0 |
| public | film_attributes_values | film_attributes_values_value_timestamp_idx | 330590 | 16 MB | 7464 kB | N | 0 | 0 | 0 |
| public | films | films_pk | 10002 | 512 kB | 240 kB | Y | 349804 | 359825 | 359825 |
| public | halls | halls_pk | 14 | 8192 bytes | 16 kB | Y | 20993 | 20993 | 20993 |
| public | prices | prices_pk | 40 | 8192 bytes | 16 kB | Y | 1330353 | 1330353 | 1330353 |
| public | seats | seats_pk | 1928 | 88 kB | 64 kB | Y | 1311288 | 1311288 | 1311288 |
| public | sessions | sessions_pk | 18955 | 1128 kB | 432 kB | Y | 1311309 | 1311309 | 1311309 |
| public | tickets | tickets_pk | 1.311111e+06 | 55 MB | 28 MB | Y | 0 | 0 | 0 |
| public | tickets | tickets_seat_id_session_id | 1.311111e+06 | 55 MB | 41 MB | Y | 0 | 0 | 0 |
```

## Размеры объектов в базе
```
SELECT *, pg_size_pretty(total_bytes) AS total
    , pg_size_pretty(index_bytes) AS INDEX
    , pg_size_pretty(toast_bytes) AS toast
    , pg_size_pretty(table_bytes) AS TABLE
  FROM (
  SELECT *, total_bytes-index_bytes-COALESCE(toast_bytes,0) AS table_bytes FROM (
      SELECT c.oid,nspname AS table_schema, relname AS TABLE_NAME
              , c.reltuples AS row_estimate
              , pg_total_relation_size(c.oid) AS total_bytes
              , pg_indexes_size(c.oid) AS index_bytes
              , pg_total_relation_size(reltoastrelid) AS toast_bytes
          FROM pg_class c
          LEFT JOIN pg_namespace n ON n.oid = c.relnamespace
          WHERE relkind = 'r'
  ) a
  ORDER BY total_bytes DESC
) a
WHERE table_schema = 'public'
```
Результат:
```
| oid | table_schema | table_name | row_estimate | total_bytes | index_bytes | toast_bytes | table_bytes | total | index | toast | table | 
| 16504 | public | tickets | 1.311111e+06 | 130293760 | 72179712 |  | 58114048 | 124 MB | 69 MB |  | 55 MB | 
| 16425 | public | film_attributes_values | 330590 | 39690240 | 22593536 | 8192 | 17088512 | 38 MB | 22 MB | 8192 bytes | 16 MB | 
| 16481 | public | sessions | 18955 | 1630208 | 442368 |  | 1187840 | 1592 kB | 432 kB |  | 1160 kB | 
| 16387 | public | films | 10002 | 811008 | 245760 | 8192 | 557056 | 792 kB | 240 kB | 8192 bytes | 544 kB | 
| 16468 | public | seats | 1928 | 188416 | 65536 |  | 122880 | 184 kB | 64 kB |  | 120 kB | 
| 16398 | public | film_attributes_types | 4 | 65536 | 16384 | 8192 | 40960 | 64 kB | 16 kB | 8192 bytes | 40 kB | 
| 16449 | public | halls | 14 | 65536 | 16384 | 8192 | 40960 | 64 kB | 16 kB | 8192 bytes | 40 kB | 
| 16409 | public | film_attributes | 33 | 65536 | 16384 | 8192 | 40960 | 64 kB | 16 kB | 8192 bytes | 40 kB | 
| 16460 | public | prices | 40 | 57344 | 16384 |  | 40960 | 56 kB | 16 kB |  | 40 kB | 
```