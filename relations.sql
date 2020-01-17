select relname                                 as table_name,
       pg_size_pretty(pg_relation_size(c.oid)) as size
from pg_class c
         left join pg_namespace n on n.oid = c.relnamespace
where nspname not in ('pg_catalog', 'information_schema')
order by pg_relation_size(c.oid) desc
limit 15;

/*
10M строк
*/
-- tickets	                        892 MB
-- movies_attributes_values	        549 MB

-- unique_ticket	                521 MB
--                  ограничение чтобы не продать билет на один и тот же сеанс на одно и то же место в зале,
--                  наверно целесообразнее проверку делать на уровне приложения

-- tickets_pkey	                    384 MB
-- movies_attributes_values_pkey	229 MB
-- idx_as_dec	                    226 MB
-- attr_movie_idx	                161 MB
-- movies	                        62 MB
-- sessions	                        59 MB
-- movie_duration_idx	            26 MB
-- movies_pkey	                    26 MB
-- ses_time_idx	                    26 MB
-- sessions_pkey	                26 MB
-- movies_attributes_types_pkey	    16 kB
-- movies_attributes_pkey	        16 kB

/*
10k строк
*/
-- tickets	                            2104 kB
-- unique_ticket	                    1248 kB
-- movies_attributes_values	            1192 kB
-- tickets_pkey	                        920 kB
-- movies_attributes_values_pkey	    352 kB
-- movies	                            160 kB
-- sessions	                            144 kB
-- movies_pkey	                        88 kB
-- sessions_pkey	                    80 kB
-- hall_id	                            16 kB
-- movies_attributes_pkey	            16 kB
-- movies_attributes_types_pkey	        16 kB
-- movies_attributes_values_id_seq	    8192 bytes
-- movies_id_seq	                    8192 bytes
-- movies_attributes_types_id_seq	    8192 bytes
