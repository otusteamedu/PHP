select 
	relname,
	indexrelname,
	idx_scan,
	idx_tup_read,
	idx_tup_fetch
from pg_stat_all_indexes 
where schemaname in ('public')
order by idx_tup_read desc;