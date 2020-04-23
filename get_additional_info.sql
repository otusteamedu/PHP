-- получить самые часто используемые индексы
SELECT relname
FROM pg_stat_user_indexes
ORDER BY idx_scan DESC
LIMIT 5;

-- получить самые редко используемые индексы
SELECT relname
FROM pg_stat_user_indexes
ORDER BY idx_scan
LIMIT 5;

-- получить самые большие объекты бд (по кол-ву страниц)
SELECT relname, relpages
FROM pg_class
ORDER BY relpages DESC
LIMIT 15;
