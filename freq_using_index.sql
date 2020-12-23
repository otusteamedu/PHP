
часто используемые

select indexrelname AS index_name, stat.idx_scan AS index_scans_count
from pg_stat_user_indexes AS stat
join pg_indexes as pgi on indexrelname = indexname AND stat.schemaname = pgi.schemaname
join pg_stat_user_tables AS tabstat on stat.relid = tabstat.relid
ORDER by stat.idx_scan DESC limit 5

index_name          |index_scans_count|
--------------------|-----------------|
content_pk          |         16606688|
contentattrvalues_un|          1010431|
contentfields_pk    |             1278|
i_cav_idContent     |              647|
contentattr_pk      |               56|


редко используемые

select indexrelname AS index_name, stat.idx_scan AS index_scans_count
from pg_stat_user_indexes AS stat
join pg_indexes as pgi on indexrelname = indexname AND stat.schemaname = pgi.schemaname
join pg_stat_user_tables AS tabstat on stat.relid = tabstat.relid
ORDER by stat.idx_scan asc limit 5

index_name|index_scans_count|
----------|-----------------|
genre_pk  |                0|
halls_pk  |                0|
places_pk |                0|
seance_pk |                0|
tickets_pk|                0|
