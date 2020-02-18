10000 - записей

Sorted Biggest objects
table_name                  |table_size|indexes_size|total_size|
----------------------------|----------|------------|----------|
"public"."movies_attr_value"|520 kB    |880 kB      |1400 kB   |
"public"."tickets"          |536 kB    |768 kB      |1304 kB   |
"public"."movies_attr"      |80 kB     |96 kB       |176 kB    |
"public"."halls"            |8192 bytes|32 kB       |40 kB     |
"public"."movies_attr_type" |8192 bytes|32 kB       |40 kB     |
"public"."sessions"         |8192 bytes|32 kB       |40 kB     |
"public"."movies"           |16 kB     |16 kB       |32 kB     |
"public"."places"           |8192 bytes|16 kB       |24 kB     |

High usage

tablename  |indexname                      |totalrows|tablesize |indexsize|totalnumberofscan|totaltupleread|totaltuplefetched|
-----------|-------------------------------|---------|----------|---------|-----------------|--------------|-----------------|
movies     |movies_pk                      |        0|8192 bytes|16 kB    |         20241113|      20221092|         20221092|
sessions   |sessions_pk                    |        0|8192 bytes|16 kB    |         20020114|      20020312|         20020112|
movies_attr|movies_attr_pk                 |        0|56 kB     |40 kB    |         20010082|      20010082|         20010082|
tickets    |tickets_place_id_session_id_key|        0|512 kB    |304 kB   |          3981303|       4782147|          3981247|
halls      |halls_pk                       |        0|8192 bytes|16 kB    |           201435|        201422|           201422|

Low usage

tablename        |indexname                         |totalrows|tablesize |indexsize|totalnumberofscan|totaltupleread|totaltuplefetched|
-----------------|----------------------------------|---------|----------|---------|-----------------|--------------|-----------------|
sessions         |idx_sessions_movie_id             |        0|8192 bytes|16 kB    |                0|             0|                0|
tickets          |tickets_pk                        |        0|512 kB    |240 kB   |                0|             0|                0|
movies_attr      |movies_attr_name_idx              |        0|56 kB     |56 kB    |                0|             0|                0|
tickets          |idx_tickets_session_id            |        0|512 kB    |224 kB   |                0|             0|                0|
movies_attr_value|idx_movies_attr_value_value_string|        0|488 kB    |328 kB   |                0|             0|                0|


10000000 записей

Sorted Biggest objects

table_name                  |table_size|indexes_size|total_size|
----------------------------|----------|------------|----------|
"public"."movies_attr_value"|472 MB    |903 MB      |1375 MB   |
"public"."tickets"          |498 MB    |818 MB      |1316 MB   |
"public"."sessions"         |5912 kB   |5072 kB     |11 MB     |
"public"."movies"           |600 kB    |240 kB      |840 kB    |
"public"."movies_attr"      |80 kB     |96 kB       |176 kB    |
"public"."halls"            |8192 bytes|32 kB       |40 kB     |
"public"."movies_attr_type" |8192 bytes|32 kB       |40 kB     |
"public"."places"           |8192 bytes|16 kB       |24 kB     |

High usage

tablename  |indexname                      |totalrows|tablesize |indexsize|totalnumberofscan|totaltupleread|totaltuplefetched|
-----------|-------------------------------|---------|----------|---------|-----------------|--------------|-----------------|
movies     |movies_pk                      |    10000|568 kB    |240 kB   |         20241113|      20221092|         20221092|
sessions   |sessions_pk                    |   100000|5888 kB   |2208 kB  |         20020114|      20020312|         20020112|
movies_attr|movies_attr_pk                 |     1000|56 kB     |40 kB    |         20010082|      20010082|         20010082|
tickets    |tickets_place_id_session_id_key| 10000115|498 MB    |408 MB   |          3981303|       4782147|          3981247|
halls      |halls_pk                       |        0|8192 bytes|16 kB    |           201435|        201422|           201422|

Low usage

tablename        |indexname                         |totalrows|tablesize|indexsize|totalnumberofscan|totaltupleread|totaltuplefetched|
-----------------|----------------------------------|---------|---------|---------|-----------------|--------------|-----------------|
sessions         |idx_sessions_movie_id             |   100000|5888 kB  |2864 kB  |                0|             0|                0|
tickets          |tickets_pk                        | 10000115|498 MB   |214 MB   |                0|             0|                0|
movies_attr      |movies_attr_name_idx              |     1000|56 kB    |56 kB    |                0|             0|                0|
tickets          |idx_tickets_session_id            | 10000115|498 MB   |196 MB   |                0|             0|                0|
movies_attr_value|idx_movies_attr_value_value_string|  9993695|472 MB   |272 MB   |                0|             0|                0|