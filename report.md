#Планы выполнения

Запрос | План выполнения при 10K | План выполнения при 10M
--- | --- | ---
`EXPLAIN SELECT * FROM attribute_value;`|Seq Scan on attribute_value  (cost=0.00..170.00 rows=10000 width=46)|?
`EXPLAIN INSERT INTO attribute_value (attribute_id, film_id, val_bool) VALUES (8, 12, TRUE);`|Insert on attribute_value  (cost=0.00..0.01 rows=1 width=81)<br /> ->  Result  (cost=0.00..0.01 rows=1 width=81)|?
`EXPLAIN DELETE FROM attribute_value WHERE id > 4000;`|Delete on attribute_value  (cost=0.00..195.00 rows=6000 width=6)<br />  ->  Seq Scan on attribute_value  (cost=0.00..195.00 rows=6000 width=6)<br /> Filter: (id > 4000)|?
`EXPLAIN SELECT av.*, film."name" FROM attribute_value av INNER JOIN film ON av.film_id = film.id WHERE film.id = 2;`|Nested Loop  (cost=0.14..208.35 rows=519 width=562)<br />  ->  Index Scan using film_pk on film  (cost=0.14..8.16 rows=1 width=520)<br />        Index Cond: (id = 2)<br />  ->  Seq Scan on attribute_value av  (cost=0.00..195.00 rows=519 width=46)<br />        Filter: (film_id = 2)|?
`EXPLAIN SELECT * FROM attribute_value av INNER JOIN film ON av.film_id = film.id;`|Hash Join  (cost=13.15..210.19 rows=10000 width=598)<br />  Hash Cond: (av.film_id = film.id)<br />  ->  Seq Scan on attribute_value av  (cost=0.00..170.00 rows=10000 width=46)<br />  ->  Hash  (cost=11.40..11.40 rows=140 width=552)<br />        ->  Seq Scan on film  (cost=0.00..11.40 rows=140 width=552)|?
`EXPLAIN SELECT av.film_id, SUM(av.val_numeric) FROM attribute_value av WHERE av.film_id = 10 GROUP BY (av.film_id);`|GroupAggregate  (cost=0.00..197.87 rows=20 width=36)<br />  Group Key: film_id<br />  ->  Seq Scan on attribute_value av  (cost=0.00..195.00 rows=523 width=10)<br />        Filter: (film_id = 10)|?