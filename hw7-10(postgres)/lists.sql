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
ORDER BY table_size;


"schemaname",   "tablename",   "indexname",   "num_rows",   "table_size",   "index_size",   "unique",   "number_of_scans",   "tuples_read",   "tuples_fetched"
otus,   hall_seats,   hall_seats_pkey,   10000000,   "498 MB",   "214 MB",   Y,   24085922,   74086909,   74086909
otus,   orders,   orders_pkey,   10000000,   "574 MB",   "214 MB",   Y,   0,   0,   0
otus,   movie_attribute_values,   movie_attribute_values_attribute_type_id_idx,   10000000,   "719 MB",   "214 MB",   N,   10,   14283120,   0
otus,   movie_attribute_values,   movie_attribute_values_value_date_idx,   10000000,   "719 MB",   "214 MB",   N,   0,   0,   0
otus,   movie_attribute_values,   movie_attribute_values_attribute_id_idx,   10000000,   "719 MB",   "214 MB",   N,   0,   0,   0
otus,   movie_attribute_values,   movie_attribute_values_movie_id_idx,   10000000,   "719 MB",   "214 MB",   N,   0,   0,   0
otus,   movie_attribute_values,   movie_attribute_values_pkey,   10000000,   "719 MB",   "214 MB",   Y,   0,   0,   0
otus,   tickets,   tickets_status_idx,   10000000,   "730 MB",   "214 MB",   N,   0,   0,   0
otus,   tickets,   tickets_pkey,   10000000,   "730 MB",   "214 MB",   Y,   10000001,   10000001,   10000001
otus,   tickets,   tickets_hall_seat_id_idx,   10000000,   "730 MB",   "214 MB",   N,   12,   12,   12
otus,   tickets,   tickets_session_id_idx,   10000000,   "730 MB",   "214 MB",   N,   18,   1072584,   1072584
otus,   sessions,   sessions_movie_id_idx,   10000000,   "805 MB",   "214 MB",   N,   0,   0,   0
otus,   sessions,   sessions_pkey,   10000000,   "805 MB",   "214 MB",   Y,   146,   21066677,   21066677
otus,   movies,   movies_pkey,   10.0,   "8192 bytes",   "16 kB",   Y,   5,   50,   50
otus,   halls,   halls_pkey,   10.0,   "8192 bytes",   "16 kB",   Y,   0,   0,   0
otus,   cinemas,   cinemas_pkey,   1.0,   "8192 bytes",   "16 kB",   Y,   0,   0,   0
otus,   movie_attribute_types,   movie_attribute_types_pkey,   7.0,   "8192 bytes",   "16 kB",   Y,   3,   21,   21
otus,   movie_attribute_types,   movie_attribute_types_name_idx,   7.0,   "8192 bytes",   "16 kB",   N,   0,   0,   0
otus,   movie_attributes,   movie_attributes_pkey,   14.0,   "8192 bytes",   "16 kB",   Y,   3,   42,   42
otus,   employees,   employees_pkey,   5.0,   "8192 bytes",   "16 kB",   Y,   10000000,   10000000,   10000000


select * from pg_statio_user_indexes order by idx_blks_read desc limit 5;

"relid",   "indexrelid",   "schemaname",   "relname",   "indexrelname",   "idx_blks_read",   "idx_blks_hit"
23394,   23398,   otus,   hall_seats,   hall_seats_pkey,   12430933,   89935153
23436,   23443,   otus,   tickets,   tickets_pkey,   7267459,   52665279
23418,   23422,   otus,   sessions,   sessions_pkey,   83372,   29879701
23505,   23512,   otus,   movie_attribute_values,   movie_attribute_values_pkey,   27435,   29877645
23467,   23472,   otus,   orders,   orders_pkey,   27425,   29877643

select * from pg_statio_user_indexes order by idx_blks_read limit 5;

"relid",   "indexrelid",   "schemaname",   "relname",   "indexrelname",   "idx_blks_read",   "idx_blks_hit"
23505,   24009,   otus,   movie_attribute_values,   movie_attribute_values_movie_id_idx,   1,   0
23505,   24010,   otus,   movie_attribute_values,   movie_attribute_values_value_date_idx,   1,   0
23505,   24007,   otus,   movie_attribute_values,   movie_attribute_values_attribute_id_idx,   1,   0
23498,   24006,   otus,   movie_attribute_types,   movie_attribute_types_name_idx,   1,   0
23418,   24011,   otus,   sessions,   sessions_movie_id_idx,   1,   0

