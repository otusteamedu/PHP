
-- часто используемые индексы

select indexrelname AS index_name, stat.idx_scan AS index_scans_count
from pg_stat_user_indexes AS stat
join pg_indexes as pgi on indexrelname = indexname AND stat.schemaname = pgi.schemaname
join pg_stat_user_tables AS tabstat on stat.relid = tabstat.relid
ORDER by stat.idx_scan DESC limit 5;

-- 1M

-- index_name                    | index_scans_count
-- ------------------------------+-------------------
--  events_pkey                  |           2996346
--  films_pkey                   |           1998754
--  halls_pkey                   |           1004734
--  orders_event_id_place_id_key |           1000004
--  orders_pkey                  |           1000000


-- 10k

-- index_name          | index_scans_count
-- ------------------------------+-------------------
--  events_pkey                  |             29977
--  films_pkey                   |             20020
--  halls_pkey                   |             16000
--  orders_event_id_place_id_key |             10004
--  events_hall_id_datetime_key  |             10000


-----------------------------------------------------------------------
-- редко используемые индексы

select indexrelname AS index_name, stat.idx_scan AS index_scans_count
from pg_stat_user_indexes AS stat
join pg_indexes as pgi on indexrelname = indexname AND stat.schemaname = pgi.schemaname
join pg_stat_user_tables AS tabstat on stat.relid = tabstat.relid
ORDER by stat.idx_scan asc limit 5;

-- 1M

-- index_name                   | index_scans_count
-- -----------------------------+-------------------
--  users_email_key           |                 0
--  orders_orderstatusid2_ind |                 0
--  fav_bool_ind              |                 0
--  users_username_key        |                 0
--  films_title_key           |                 0


-- 10k

-- index_name         | index_scans_count
-- ---------------------------+-------------------
--  users_username_key        |                 0
--  places_number_hall_id_key |                 0
--  halls_title_key           |                 0
--  films_title_key           |                 0
--  users_email_key           |                 0



-- conclusion
-- индексы хоть и дают улучшение (queries.sql), primary и foreign ключи куда чаще вступают в ход

