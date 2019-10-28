SELECT
    TABLE_NAME,
    pg_size_pretty(table_size) AS table_size,
    pg_size_pretty(indexes_size) AS indexes_size,
    pg_size_pretty(total_size) AS total_size	
FROM (
    SELECT
        TABLE_NAME,
        pg_table_size(TABLE_NAME) AS table_size,
        pg_indexes_size(TABLE_NAME) AS indexes_size,
        pg_total_relation_size(TABLE_NAME) AS total_size
    FROM (
        SELECT ('"' || table_schema || '"."' || TABLE_NAME || '"') AS TABLE_NAME
        FROM information_schema.tables
    WHERE table_schema NOT IN ('information_schema','pg_catalog')) AS all_tables
    ORDER BY total_size  DESC limit 15 
) AS pretty_sizes 
/*
""public"."tickets""	"536 kB"	"960 kB"	"1496 kB"
""public"."clients""	"248 kB"	"304 kB"	"552 kB"
""public"."attributes_value""	"16 kB"	"48 kB"	"64 kB"
""public"."seance""	"8192 bytes"	"48 kB"	"56 kB"
""public"."attributes""	"8192 bytes"	"48 kB"	"56 kB"
""public"."film""	"8192 bytes"	"48 kB"	"56 kB"
""public"."hall""	"8192 bytes"	"16 kB"	"24 kB"
""public"."attributes_types""	"8192 bytes"	"16 kB"	"24 kB"

*/
SELECT
    TABLE_NAME,
    pg_size_pretty(table_size) AS table_size,
    pg_size_pretty(indexes_size) AS indexes_size,
    pg_size_pretty(total_size) AS total_size	
FROM (
    SELECT
        TABLE_NAME,
        pg_table_size(TABLE_NAME) AS table_size,
        pg_indexes_size(TABLE_NAME) AS indexes_size,
        pg_total_relation_size(TABLE_NAME) AS total_size
    FROM (
        SELECT ('"' || table_schema || '"."' || TABLE_NAME || '"') AS TABLE_NAME
        FROM information_schema.tables
    WHERE table_schema NOT IN ('information_schema','pg_catalog')) AS all_tables
    ORDER BY total_size  ASC limit 15 
) AS pretty_sizes 




SELECT
    pt.tablename AS TableName
    ,t.indexname AS IndexName
    ,pc.reltuples AS TotalRows
    ,pg_size_pretty(pg_relation_size(quote_ident(pt.tablename)::text)) AS TableSize
    ,pg_size_pretty(pg_relation_size(quote_ident(t.indexrelname)::text)) AS IndexSize
    ,t.idx_scan AS TotalNumberOfScan
    ,t.idx_tup_read AS TotalTupleRead
    ,t.idx_tup_fetch AS TotalTupleFetched
FROM pg_tables AS pt
LEFT OUTER JOIN pg_class AS pc 
	ON pt.tablename=pc.relname
LEFT OUTER JOIN
( 
	SELECT 
		pc.relname AS TableName
		,pc2.relname AS IndexName
		,psai.idx_scan
		,psai.idx_tup_read
		,psai.idx_tup_fetch
		,psai.indexrelname 
	FROM pg_index AS pi
	JOIN pg_class AS pc 
		ON pc.oid = pi.indrelid
	JOIN pg_class AS pc2 
		ON pc2.oid = pi.indexrelid
	JOIN pg_stat_all_indexes AS psai 
		ON pi.indexrelid = psai.indexrelid 
)AS T
    ON pt.tablename = T.TableName
WHERE pt.schemaname='public'
ORDER BY TotalNumberOfScan desc limit 5;

/*
"seance"	"seance_pkey"	"55"	"8192 bytes"	"16 kB"	"10008"	"10008"	"10008"
"clients"	"clients_pkey"	"5000"	"224 kB"	"128 kB"	"10000"	"10000"	"10000"
"film"	"film_pkey"	"11"	"8192 bytes"	"16 kB"	"89"	"89"	"89"
"hall"	"hall_pkey"	"4"	"8192 bytes"	"16 kB"	"55"	"55"	"55"
"attributes"	"attributes_pkey"	"20"	"8192 bytes"	"16 kB"	"32"	"32"	"32"
*/


SELECT
    pt.tablename AS TableName
    ,t.indexname AS IndexName
    ,pc.reltuples AS TotalRows
    ,pg_size_pretty(pg_relation_size(quote_ident(pt.tablename)::text)) AS TableSize
    ,pg_size_pretty(pg_relation_size(quote_ident(t.indexrelname)::text)) AS IndexSize
    ,t.idx_scan AS TotalNumberOfScan
    ,t.idx_tup_read AS TotalTupleRead
    ,t.idx_tup_fetch AS TotalTupleFetched
FROM pg_tables AS pt
LEFT OUTER JOIN pg_class AS pc 
	ON pt.tablename=pc.relname
LEFT OUTER JOIN
( 
	SELECT 
		pc.relname AS TableName
		,pc2.relname AS IndexName
		,psai.idx_scan
		,psai.idx_tup_read
		,psai.idx_tup_fetch
		,psai.indexrelname 
	FROM pg_index AS pi
	JOIN pg_class AS pc 
		ON pc.oid = pi.indrelid
	JOIN pg_class AS pc2 
		ON pc2.oid = pi.indexrelid
	JOIN pg_stat_all_indexes AS psai 
		ON pi.indexrelid = psai.indexrelid 
)AS T
    ON pt.tablename = T.TableName
WHERE pt.schemaname='public'
ORDER BY TotalNumberOfScan asc limit 5;
/*
"tickets"	"idx_tickets"	"10000"	"512 kB"	"240 kB"	"0"	"0"	"0"
"tickets"	"idx_id_seance"	"10000"	"512 kB"	"240 kB"	"0"	"0"	"0"
"tickets"	"tickets_pkey"	"10000"	"512 kB"	"240 kB"	"0"	"0"	"0"
"tickets"	"idx_price_tickets"	"10000"	"512 kB"	"240 kB"	"0"	"0"	"0"
"seance"	"idx_id_film"	"55"	"8192 bytes"	"16 kB"	"0"	"0"	"0"
*/