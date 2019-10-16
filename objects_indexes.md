## Sorted Biggest objects
- tickets | table | cinema | 498 MB
- tickets_seat_id_session_id_key | index | cinema | tickets | 348 MB
- session_idx | index | cinema | tickets | 235 MB
- tickets_pkey  | index | cinema | tickets  | 214 MB
- price_idx | index | cinema | tickets | 203 MB
- sessions  | table | cinema | 536 kB
- film_id_idx | index | cinema | sessions | 312 kB
- sessions_pkey  | index | cinema | sessions | 240 kB
- seats | table | cinema | 72 kB
- seats_pkey | index | cinema | seats  | 40 kB
- halls_pkey | index | cinema | halls  | 16 kB
- films_pkey  | index | cinema | films | 16 kB
- films  | table | cinema | 8192 bytes |
- films_attrs_values | table | cinema | 8192 bytes
- halls  | table | cinema | 8192 bytes

## Index usage statistics
    tablename	indexname	num_rows	table_size	index_size	unique	number_of_scans	tuples_read	tuples_fetched
### High usage
-	sessions	sessions_pkey	10000	512 kB	240 kB	Y	10010042	10010042	10010042
-	seats	    seats_pkey	    1000	48 kB	40 kB	Y	10010000	10010000	10010000
-	halls	    halls_pkey	    0	 8192 bytes	16 kB	Y	11200	11200	11200
-	films	    films_pkey	    100	 8192 bytes	16 kB	Y	10102	10102	10102
-   tickets	    session_idx	    1.0000115e+07	498 MB	235 MB	N	11	1000	1000

### Low usage
-    tickets	tickets_pkey	1.0000115e+07	498 MB	214 MB	Y	0	0	0
-    tickets	price_idx	1.0000115e+07	498 MB	203 MB	N	1	18	0
-	 sessions	film_id_idx	10000	512 kB	312 kB	N	0	0	0
-    tickets	tickets_seat_id_session_id_key	1.0000115e+07	498 MB	348 MB	Y	3	300	0

