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

""public"."tickets""	"498 MB"	"858 MB"	"1355 MB"
""public"."clients""	"21 MB"	"26 MB"	"47 MB"
""public"."seance""	"64 kB"	"64 kB"	"128 kB"
""public"."attributes_value""	"16 kB"	"48 kB"	"64 kB"
""public"."attributes""	"8192 bytes"	"48 kB"	"56 kB"
""public"."film""	"8192 bytes"	"48 kB"	"56 kB"
""public"."hall""	"8192 bytes"	"16 kB"	"24 kB"
""public"."attributes_types""	"8192 bytes"	"16 kB"	"24 kB"


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
ORDER BY TotalNumberOfScan desc limit 5;


/*
"seance"	"seance_pkey"	"550"	"40 kB"	"32 kB"	"10020032"	"10020032"	"10020032"
"clients"	"clients_pkey"	"500000"	"21 MB"	"11 MB"	"10020000"	"10020000"	"10020000"
"film"	"film_pkey"	"33"	"8192 bytes"	"16 kB"	"1237"	"1237"	"1237"
"hall"	"hall_pkey"	"0"	"8192 bytes"	"16 kB"	"1155"	"1155"	"1155"
"attributes"	"attributes_pkey"	"20"	"8192 bytes"	"16 kB"	"84"	"84"	"84"


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
"seance"	"idx_id_film"	"550"	"40 kB"	"32 kB"	"0"	"0"	"0"
"tickets"	"idx_tickets"	"1e+07"	"498 MB"	"214 MB"	"0"	"0"	"0"
"tickets"	"tickets_pkey"	"1e+07"	"498 MB"	"214 MB"	"0"	"0"	"0"
"tickets"	"idx_price_tickets"	"1e+07"	"498 MB"	"215 MB"	"0"	"0"	"0"
"attributes_value"	"attributes_value_pkey"	"20"	"8192 bytes"	"16 kB"	"0"	"0"	"0"



*/