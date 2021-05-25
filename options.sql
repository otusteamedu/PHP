-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

SELECT
  nspname || '.' || relname                            AS name,
  pg_size_pretty(pg_total_relation_size(pg_class.oid)) AS size,
  CASE relkind
  WHEN 'r'
    THEN 'Таблица'
  WHEN 'i'
    THEN 'Индекс'
  WHEN 'S'
    THEN 'Последовательность(Sequence)'
  WHEN 'v'
    THEN 'Представление(view)'
  WHEN 'm'
    THEN 'Материализованное представление(materialized view)'
  END                                                  AS type
FROM pg_class
  LEFT JOIN pg_namespace pn ON pn.oid = pg_class.relnamespace
WHERE nspname = 'public'
ORDER BY pg_total_relation_size(pg_class.oid) DESC
LIMIT 15;

-- частые индексы

SELECT *
FROM pg_stat_user_indexes
ORDER BY idx_scan DESC
LIMIT 5;

-- редкие индексы
SELECT *
FROM pg_stat_user_indexes
ORDER BY idx_scan ASC
LIMIT 5;
