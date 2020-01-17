select s.id, s.hall_id, s.movie_id
from sessions s
         inner join halls h on s.hall_id = h.id
where h.id = 4;

select distinct t.tablename as table_name,
                indexname as index_name,
                idx_scan as number_of_scans
from pg_tables t
         left outer join pg_class c on t.tablename = c.relname
         left outer join
     (select indrelid,
             max(cast(indisunique as integer)) as is_unique
      from pg_index
      group by indrelid) x
     on c.oid = x.indrelid
         left outer join
     (select c.relname   as ctablename,
             ipg.relname as indexname,
             x.indnatts  as number_of_columns,
             idx_scan,
             idx_tup_read,
             idx_tup_fetch,
             indexrelname
      from pg_index x
               join pg_class c on c.oid = x.indrelid
               join pg_class ipg on ipg.oid = x.indexrelid
               join pg_stat_all_indexes psai on x.indexrelid = psai.indexrelid)
         as foo
     on t.tablename = foo.ctablename
where t.schemaname = 'public'
order by 3 desc
-- order by 3
limit 5;

---------------------------------------------------------------------------
-- table_name                   index_name                  number_of_scans
---------------------------------------------------------------------------
-- movies	                    movies_pkey	                7806357
-- movies_attributes	        movies_attributes_pkey	    4777644
-- movies_attributes_values 	idx_as_dec	                439
-- halls	                    hall_id	                    387
-- movies_attributes_values	    attr_movie_idx  	        278


-------------------------------------------------------------------------------
-- table_name                   index_name                      number_of_scans
-------------------------------------------------------------------------------
-- halls	                    hall_id	                        0
-- movies	                    movie_duration_idx	            0
-- movies	                    movies_pkey	                    1
-- movies_attributes	        movies_attributes_pkey	        1
-- movies_attributes_types	    movies_attributes_types_pkey    3
