###ER модель
Файл `er-model-and-results.png` (там так же виден результат выполнения sql-запроса из задачи)

### DDL
Файл `cinema-ddl.sql`

### Задача. Написать SQL для нахождения самого прибыльного фильма
```
select max(m."name") movie, sum(s.price) revenue
 from "session" s
 join ticket t on t.session_id = s.id 
 join movie m on m.id = s.movie_id 
 group by movie_id
 order by revenue desc
```