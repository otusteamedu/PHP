отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

```
SELECT c.relname as "Name",
  CASE c.relkind WHEN 'r' THEN 'table' WHEN 'v' THEN 'view' WHEN 'm' THEN 'materialized view' WHEN 'i' THEN 'index' WHEN 'S' THEN 'sequence' WHEN 's' THEN 'special' WHEN 'f' THEN 'foreign table' WHEN 'p' THEN 'table' WHEN 'I' THEN 'index' END as "Type",
  pg_catalog.pg_get_userbyid(c.relowner) as "Owner",
  pg_catalog.pg_table_size(c.oid) as "Size"
FROM pg_catalog.pg_class c
     LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
     LEFT JOIN pg_catalog.pg_index i ON i.indexrelid = c.oid
     LEFT JOIN pg_catalog.pg_class c2 ON i.indrelid = c2.oid
WHERE c.relkind IN ('r','p','v','m','S','s','f','i','I','')
      AND n.nspname !~ '^pg_toast'
      AND n.nspname = 'public'
ORDER BY "Size" DESC
LIMIT 15
```

|Name                    |Type             |Owner  |Size      |
|------------------------|-----------------|-------|----------|
|tickets                 |table            |default|1886478336|
|tickets_seance_place_idx|index            |default|1315373056|
|mv_films_attributes     |materialized view|default|1145069568|
|tickets_pk              |index            |default|956653568 |
|films_attr_values       |table            |default|560332800 |
|i_tickets_seance_id     |index            |default|306905088 |
|films_attr_values_pk    |index            |default|224632832 |
|films_attr_values_un    |index            |default|222199808 |
|i_fav_film_id           |index            |default|94519296  |
|films_title_and_date_un |index            |default|87695360  |
|i_fav_val_date          |index            |default|69427200  |
|i_fav_attr_id           |index            |default|69320704  |
|i_fav_val_bool          |index            |default|69320704  |
|films                   |table            |default|68321280  |
|mv_film_tasks           |materialized view|default|36716544  |


часто используемые индексы

```
select indexrelname AS index_name, stat.idx_scan AS index_scans_count
from pg_stat_user_indexes AS stat
join pg_indexes as pgi on indexrelname = indexname AND stat.schemaname = pgi.schemaname
join pg_stat_user_tables AS tabstat on stat.relid = tabstat.relid
ORDER by stat.idx_scan DESC limit 5
```
|index_name          |index_scans_count|
|--------------------|-----------------|
|i_fav_film_id       |2244464          |
|films_attr_pk       |28476            |
|films_pk            |117              |
|i_seances_date_start|17               |
|films_attr_values_pk|7                |

редко используемые индексы

```
select indexrelname AS index_name, stat.idx_scan AS index_scans_count
from pg_stat_user_indexes AS stat
join pg_indexes as pgi on indexrelname = indexname AND stat.schemaname = pgi.schemaname
join pg_stat_user_tables AS tabstat on stat.relid = tabstat.relid
ORDER by stat.idx_scan asc limit 5
```
|index_name          |index_scans_count|
|--------------------|-----------------|
|halls_pk            |0                |
|films_title_and_date_un|0                |
|seances_pk          |0                |
|places_pk           |0                |
|places_place_in_hall_idx|0                |


