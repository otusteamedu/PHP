/**
 * Отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
 */
SELECT
    schema_name,
    relname as "object",
    pg_size_pretty(table_size) AS "size"
FROM (
         SELECT
             pg_catalog.pg_namespace.nspname AS schema_name,
             relname,
             pg_relation_size(pg_catalog.pg_class.oid) AS table_size

         FROM pg_catalog.pg_class
                  JOIN pg_catalog.pg_namespace ON relnamespace = pg_catalog.pg_namespace.oid
     ) AS t
WHERE schema_name NOT LIKE 'pg_%'
ORDER BY table_size DESC
LIMIT 15;

/**
 * Отсортированный список (5 значений) самых часто используемых индексов
 */
SELECT
    indexrelname AS index_name, -- индекс
    idstat.relname AS table_name, -- имя таблицы
    idstat.idx_scan AS index_scans_count, -- число сканирований по этому индексу
    tabstat.idx_scan AS table_reads_index_count -- индексных чтений по таблице
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
    idstat.idx_scan DESC
LIMIT 5;
