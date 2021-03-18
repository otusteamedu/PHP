-- выбрать объекты по их размеру
SELECT 
	nspname || '.' || relname AS "name",
	pg_size_pretty(pg_total_relation_size(C.oid)) AS totalsize,
	pg_size_pretty(pg_relation_size(C.oid)) AS realsize
	FROM pg_class C
	LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
	ORDER BY pg_total_relation_size(C.oid) DESC
	LIMIT 15;