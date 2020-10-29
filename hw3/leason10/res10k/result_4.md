## Все фильмы и их аттрибуты

Исходный запрос:

````sql
select f.name as "film",
       at.attr_type,
       a.attr_name,
       av.attr_value
from film f
         left join attr_values av on av.film = f.id
         left join attrs a on a.id = av.attr
         left join attr_types at on at.id = a.attr_type;
````

План выполненния
````sql
QUERY PLAN                                                                           |
-------------------------------------------------------------------------------------|
Hash Left Join  (cost=20.55..276.15 rows=10000 width=447)                            |
  Hash Cond: (a.attr_type = at.id)                                                   |
  ->  Hash Left Join  (cost=6.50..235.23 rows=10000 width=33)                        |
        Hash Cond: (av.attr = a.id)                                                  |
        ->  Hash Right Join  (cost=3.25..204.61 rows=10000 width=26)                 |
              Hash Cond: (av.film = f.id)                                            |
              ->  Seq Scan on attr_values av  (cost=0.00..174.00 rows=10000 width=24)|
              ->  Hash  (cost=2.00..2.00 rows=100 width=10)                          |
                    ->  Seq Scan on film f  (cost=0.00..2.00 rows=100 width=10)      |
        ->  Hash  (cost=2.00..2.00 rows=100 width=15)                                |
              ->  Seq Scan on attrs a  (cost=0.00..2.00 rows=100 width=15)           |
  ->  Hash  (cost=11.80..11.80 rows=180 width=422)                                   |
        ->  Seq Scan on attr_types at  (cost=0.00..11.80 rows=180 width=422)         |
````
Видно, что используется полный перебор таблиц attr_values, film, attrs, attr_type.
Добавление индексов ни к чему не приведет, т.к. в запросе нет условия и сортировки.
 