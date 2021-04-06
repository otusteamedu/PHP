-- используемые индексы
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
 ORDER BY number_of_scans desc
 -- убираем desc и получаем наименее используемые
 LIMIT 15;