-- Отсортированный список для двух видов объектов:
select
       nspname || '.' || relname as name,
       pg_size_pretty(pg_total_relation_size(pg_class.oid)) as size
from pg_class
left join pg_namespace N on N.oid = pg_class.relnamespace
where nspname = 'public'
order by pg_total_relation_size(pg_class.oid) DESC limit 15;
-----------------------------
-- Списки часто и редко используемых индексов
select * from pg_stat_user_indexes order by idx_scan desc limit 5;
select * from pg_stat_user_indexes order by idx_scan asc limit 5;