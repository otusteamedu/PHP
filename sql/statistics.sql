-- Учитываются только пользовательские индексы и не учитываются уникальные,
-- т.к. они используются как ограничения (как часть логики хранения данных).

-- 5 самых используемых индексов

SELECT idstat.relname AS table_name,                                -- имя таблицы
       indexrelname AS index_name,                                  -- индекс
       idstat.idx_scan AS index_scans_count,                        -- число сканирований по этому индексу
       pg_size_pretty(pg_relation_size(indexrelid)) AS index_size,  -- размер индекса
       tabstat.idx_scan AS table_reads_index_count,                 -- индексных чтений по таблице
       tabstat.seq_scan AS table_reads_seq_count,                   -- последовательных чтений по таблице
       tabstat.seq_scan + tabstat.idx_scan AS table_reads_count,    -- чтений по таблице
       n_tup_upd + n_tup_ins + n_tup_del AS table_writes_count,     -- операций записи
       pg_size_pretty(pg_relation_size(idstat.relid)) AS table_size -- размер таблицы
FROM pg_stat_user_indexes AS idstat
     JOIN pg_indexes ON indexrelname = indexname AND idstat.schemaname = pg_indexes.schemaname
     JOIN pg_stat_user_tables AS tabstat ON idstat.relid = tabstat.relid
WHERE indexdef !~* 'unique'
ORDER BY idstat.idx_scan DESC,
         pg_relation_size(indexrelid) DESC
LIMIT 5;

-- 5 самых не используемых индексов

SELECT idstat.relname AS table_name,                                -- имя таблицы
       indexrelname AS index_name,                                  -- индекс
       idstat.idx_scan AS index_scans_count,                        -- число сканирований по этому индексу
       pg_size_pretty(pg_relation_size(indexrelid)) AS index_size,  -- размер индекса
       tabstat.idx_scan AS table_reads_index_count,                 -- индексных чтений по таблице
       tabstat.seq_scan AS table_reads_seq_count,                   -- последовательных чтений по таблице
       tabstat.seq_scan + tabstat.idx_scan AS table_reads_count,    -- чтений по таблице
       n_tup_upd + n_tup_ins + n_tup_del AS table_writes_count,     -- операций записи
       pg_size_pretty(pg_relation_size(idstat.relid)) AS table_size -- размер таблицы
FROM pg_stat_user_indexes AS idstat
     JOIN pg_indexes ON indexrelname = indexname AND idstat.schemaname = pg_indexes.schemaname
     JOIN pg_stat_user_tables AS tabstat ON idstat.relid = tabstat.relid
WHERE indexdef !~* 'unique'
ORDER BY idstat.idx_scan,
         pg_relation_size(indexrelid) DESC
LIMIT 5;

-- 15 самых больших по размеру объектов БД

SELECT pn.nspname || '.' || pc.relname AS name,
       pg_size_pretty(pg_total_relation_size(pc.oid)) AS totalsize,
       pg_size_pretty(pg_relation_size(pc.oid)) AS relsize
FROM pg_class pc
     JOIN pg_namespace pn ON pc.relnamespace = pn.oid
WHERE pn.nspname NOT IN ('pg_toast', 'pg_catalog', 'information_schema')
ORDER BY pg_relation_size(pc.oid) DESC
LIMIT 15;
