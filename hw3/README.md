# Как устроен PostgreSQL

## 7. Схема управления кинотеатром

- [Логическая модель](/hw3/leason7/logical_sheme.png)
- [DDL скрипт](/hw3/leason7/cinema.sql)
- [SQL-запрос, для получения наиболее прибыльного фильма](/hw3/leason7/max_debit.sql)
- [Дамп данных](/hw3/leason7/dump.sql)

 ![Логическая модель](/hw3/leason7/logical_sheme.png)
 
 ## 9. EAV-хранение данных

В данной реализации выбрана модель, при которой любой тип значения аттрибута хранится как текст.

Для реализации хранения в соответствии с типом аттрибута, необходимо применять какой-либо фреймворк реализующий EAV-паттерн.
 
 - [Логическая модель](/hw3/leason9/schema.png)
 - [DDL скрипт](/hw3/leason9/eav.sql)
 - [View для маркетинга](/hw3/leason9/marketing.sql)
 - [View для служебных данных](/hw3/leason9/system_tasks.sql)
 - [Дамп данных](/hw3/leason9/dump.sql)
 
 ![Логическая модель](/hw3/leason9/schema.png)
 
 
 ## 10. Оптимизация запросов
 
 В файле [cinema.sql](/hw3/leason10/cinema.sql) содержится DDL-схема кинотеатра, с возможностью указания дополнительной информации к фильму.
 Выбраны три простых и три сложных запроса к этой базе - [querys.sql](/hw3/leason10/querys.sql)
 
 Создана процедура для генерации и наполнения тестовыми данными - [gen_data.sql](/hw3/leason10/gen_data.sql)
 
 Результаты анализа и модификаци запросов:
 - [Запрос 1 - билеты дороже 100 руб](/hw3/leason10/res10k/result_1.md)
 - [Запрос 2 - Значения аттрибута, начинающегося на букву `D`](/hw3/leason10/res10k/result_2.md)
 - [Запрос 3 - Сеансы, начинающиеся после 01 декабря 2020](/hw3/leason10/res10k/result_3.md)
 - [Запрос 4 - Все фильмы и их аттрибуты](/hw3/leason10/res10k/result_4.md)
 - [Запрос 5 - Фильм, с наибольшей выручкой](/hw3/leason10/res10k/result_5.md)
 - [Запрос 6 - Наиболее посещаемый зал](/hw3/leason10/res10k/result_6.md)
 
 ---
 ### Полезные ссылки:
 
 - [Wikipedia EAV-model](https://en.wikipedia.org/wiki/Entity–attribute–value_model)
 - [Частичные индексы Postgres](https://postgrespro.ru/docs/postgrespro/9.5/indexes-partial)
 - [PlPgSQL](https://postgrespro.ru/docs/postgresql/9.6/plpgsql)