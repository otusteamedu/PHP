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

Результат:
Name                    |Type |Owner   |Size    |
------------------------|-----|--------|--------|
contentAttrValues       |table|postgres|78077952|
content_un              |index|postgres|55361536|
contentattrvalues_un    |index|postgres|26976256|
i_cav_idContent         |index|postgres|26976256|
i_cav_idfield           |index|postgres|26976256|
i_cav_val_boolean       |index|postgres|26976256|
i_cav_val_date          |index|postgres|26976256|
contentattrvalues_pk    |index|postgres|26976256|
content_pk              |index|postgres|22732800|
i_cav_val_date_less_2021|index|postgres| 6144000|
content                 |table|postgres| 6062080|
i_c_name                |index|postgres| 3178496|
contentAttrType         |table|postgres|   49152|
contentFields           |table|postgres|   40960|
contentAttr             |table|postgres|   40960|
