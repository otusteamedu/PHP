# Размеры

Total: 9503 MB

|object | type | size |
|---|---|---|
| movies_name_search | index | 2744 MB |
| movies | table | 1662 MB |
| movie_values | table | 1347 MB |
| movie_values_unique | index | 643 MB |
| show_seats | table | 611 MB |
| show_seats_unique | index | 488 MB |
| movies_unique_name | index | 324 MB |
| show_seats_show_cost_idx | index | 301 MB |
| show_seats_lock_idx | index | 280 MB |
| show_seats_ticket_id_key | index | 280 MB |
| show_seats_pkey | index | 264 MB |
| view_tasks_idx | index | 214 MB |
| movies_pkey | index | 214 MB |
| shows_unique_timerange | index | 32 MB |
| shows | table | 30 MB |
| shows_movie_idx | index | 11 MB |
| shows_start_idx | index | 11 MB |
| shows_pkey | index | 11 MB |
| shows_hall_idx | index | 11 MB |
| tasks_materialized | materialized view | 9592 kB |
| seats | table | 1024 kB |
| seats_unique | index | 984 kB |
| seats_pkey | index | 456 kB |
| halls_unique_name | index | 32 kB |
| clients_email_key | index | 8192 bytes |
| clients_id_seq | sequence | 8192 bytes |
| clients_pkey | index | 8192 bytes |
| halls_id_seq | sequence | 8192 bytes |
| halls_pkey | index | 8192 bytes |
| movie_attrs_id_seq | sequence | 8192 bytes |
| movie_attrs_name_key | index | 8192 bytes |
| movie_attrs_pkey | index | 8192 bytes |
| movies_id_seq | sequence | 8192 bytes |
| orders_client_idx | index | 8192 bytes |
| orders_id_seq | sequence | 8192 bytes |
| orders_pkey | index | 8192 bytes |
| seats_id_seq | sequence | 8192 bytes |
| show_seats_id_seq | sequence | 8192 bytes |
| shows_id_seq | sequence | 8192 bytes |
| tickets_id_seq | sequence | 8192 bytes |
| tickets_order_idx | index | 8192 bytes |
| tickets_pkey | index | 8192 bytes |
| tickets_show_seat_idx | index | 8192 bytes |
| tickets_unique_seats | index | 8192 bytes |
| clients | table | 0 bytes |
| halls | table | 0 bytes |
| marketing | view | 0 bytes |
| movie_attrs | table | 0 bytes |
| orders | table | 0 bytes |
| tasks | view | 0 bytes |
| tickets | table | 0 bytes |

### query
```sql
select pg_size_pretty(pg_database_size('app'));
select
    c.relname as name,
    case c.relkind
        when 'r' then 'table'
        when 'v' then 'view'
        when 'm' then 'materialized view'
        when 'i' then 'index'
        when 'S' then 'sequence'
        when 's' then 'special'
        when 'f' then 'foreign table'
        when 'p' then 'partitioned table'
        when 'i' then 'partitioned index'
        end as type,
    pg_size_pretty((relpages::bigint * 8 * 1024)::bigint) as size
from pg_catalog.pg_class c
inner join pg_catalog.pg_namespace n on n.oid = c.relnamespace
where n.nspname = 'public'
  -- and relpages > 1
order by relpages desc, name
```
