SELECT
  c.relname as "Name",
  CASE c.relkind
      WHEN 'r' THEN 'table'
      WHEN 'v' THEN 'view'
      WHEN 'm' THEN 'materialized view'
      WHEN 'i' THEN 'index'
      WHEN 'S' THEN 'sequence'
      WHEN 's' THEN 'special'
      WHEN 'f' THEN 'foreign table'
      WHEN 'p' THEN 'table'
      WHEN 'I' THEN 'index'
      END as "Type",
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
LIMIT 15;

-- Results:

-- 1M
--               Name             | Type  | Owner  |   Size
-- ------------------------------+-------+--------+-----------
--  filmAttributeValues          | table | docker | 112975872
--  films                        | table | docker | 101195776
--  events                       | table | docker |  60203008
--  orders                       | table | docker |  60055552
--  films_title_key              | index | docker |  54894592
--  events_hall_id_datetime_key  | index | docker |  40673280
--  orders_event_id_place_id_key | index | docker |  29548544
--  fav_bool_ind                 | index | docker |  22487040
--  films_pkey                   | index | docker |  22487040
--  fav_bigint_ind               | index | docker |  22487040
--  filmattrvalues_pk            | index | docker |  22487040
--  events_pkey                  | index | docker |  22454272
--  events_comment_ind           | index | docker |  22454272
--  events_price_ind             | index | docker |  22454272
--  orders_pkey                  | index | docker |  22405120

-- 10k
--               Name             | Type  | Owner  |   Size
-- ------------------------------+-------+--------+-----------
--  filmAttributeValues          | table | docker | 1163264
--  films                        | table | docker | 1048576
--  events                       | table | docker |  638976
--  orders                       | table | docker |  630784
--  films_title_key              | index | docker |  557056
--  events_hall_id_datetime_key  | index | docker |  425984
--  orders_event_id_place_id_key | index | docker |  311296
--  orders_pkey                  | index | docker |  245760
--  places                       | table | docker |  245760
--  filmattrvalues_pk            | index | docker |  245760
--  events_pkey                  | index | docker |  245760
--  films_pkey                   | index | docker |  245760
--  places_number_hall_id_key    | index | docker |  204800
--  places_pkey                  | index | docker |  155648
--  users                        | table | docker |  122880
