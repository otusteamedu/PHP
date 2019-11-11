
Скрипт создания БД в [ddl.aql](ddl.aql)

Скрипт заполнения базы тестовыми данными в [playground.sql](playground.sql)

планы запроса на малой базе
[plan_small_data_before_index.sql](plan_small_data_before_index.sql)

планы на увеличенной базе
[plan_big_data_before_index.sql](plan_big_data_before_index.sql)

планы на увеличенной базе с индексами
[plan_big_data_after_index.sql](plan_big_data_after_index.sql)

Самые часто используемые индексы
и самые большие объекты
[often_indexes_and_big_objects.txt](often_indexes_and_big_objects.txt)





Три простых запроса:

1. количество сеансов одного фильма 
```SQL
EXPLAIN ANALYSE SELECT COUNT(*) FROM seance WHERE film_id = 5;
```

2. количество билетов с хешем длинее 100 символов
```SQL
EXPLAIN ANALYSE SELECT COUNT(*) FROM ticket WHERE length(hash) > 100;
```

3. максимальная цена сеанса
```SQL
EXPLAIN ANALYSE SELECT MAX(price) FROM seance;
```


Три сложных запроса:

4. бестселлер
```SQL
EXPLAIN ANALYSE SELECT f.film_id, SUM(price) AS sum FROM film AS f
  LEFT JOIN seance AS s ON s.film_id = f.film_id
  LEFT JOIN ticket AS t ON t.seance_id = s.seance_id
  GROUP BY f.film_id
  HAVING SUM(price) >= ALL(
    SELECT SUM(price) FROM film AS f
      LEFT JOIN seance AS s ON s.film_id = f.film_id
      LEFT JOIN ticket AS t ON t.seance_id = s.seance_id
      GROUP BY f.film_id
  );
```

5. сколько заработал кинотеатр
```SQL
EXPLAIN ANALYSE SELECT SUM(price) FROM ticket join seance USING (seance_id);
```

6. самый ночной фильм, который заканчивается или начинается между 20:00 и 5:00
```SQL
EXPLAIN ANALYSE SELECT f.film_name, COUNT(*) AS cnt FROM film AS f
  LEFT JOIN seance AS s ON f.film_id = s.film_id
  WHERE s.time_start::time NOT BETWEEN '05:00' AND '20:00'
  OR s.time_start::time + (f.duration || ' minutes')::interval NOT BETWEEN '05:00' AND '20:00'
  GROUP BY f.film_id
  HAVING COUNT(*) >= ALL(
    SELECT COUNT(*) FROM film AS f
    LEFT JOIN seance AS s ON f.film_id = s.film_id
      WHERE s.time_start::time NOT BETWEEN '05:00' AND '20:00'
      OR s.time_start::time + (f.duration || ' minutes')::interval NOT BETWEEN '05:00' AND '20:00'
      GROUP BY f.film_id
  );
```



Добавил индексы:
```SQL
CREATE INDEX ON "seance" (film_id);
CREATE INDEX ON "ticket" (length(hash));
CREATE INDEX ON "seance" (price);
CREATE INDEX ON "ticket" (seance_id);
```

1. Первый запрос оптимизировал индесом, получился Index Only Scan
```SQL
CREATE INDEX ON "seance" (film_id);
```

2. Второй запрос оптимизировал функциональным индексом, получился Index Scan
```SQL
CREATE INDEX ON "ticket" (length(hash));
```

3. Для третьего запроса сделал индекс, получился Index Only Scan
```SQL
CREATE INDEX ON "seance" (price);
```

4. Чтобы найти бестселлер добавил еще один индекс
```SQL
CREATE INDEX ON "ticket" (seance_id);
```
это оптимизировало запрос,
но если отказаться от HAVING и заменить на ORDER BY sum DESC LIMIT 1,
то выгрыш в оптимизации больше, и даже индексы не потребуются.


Не получилось через индексы оптимизировать запросы:

> 5. сколько заработал кинотеатр
> 6. самый ночной фильм, который заканчивается или начинается между 20:00 и 5:00

в первом несмотря на индексы все равно необходимо обойти две таблицы полностью и сджойнить их
во втором индексы невозможно применить, потому что не храним время завершения сеанса, и приходится его пересчитывать для каждого сеанса,
в таком случае оптимизировать уже не индексами и структурой.
