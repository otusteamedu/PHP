### ER модель
Файл `er-model-and-results.png` (там так же виден результат выполнения sql-запроса из задачи)

### DDL
Файл `cinema-ddl.sql`

### Задача
> Написать SQL для нахождения самого прибыльного фильма
```
select max(m."name") movie, sum(t.paid) revenue
 from "session" s
 join place p on p.session_id = s.id
 join ticket t on t.place_id = p.id 
 join movie m on m.id = s.movie_id 
 group by movie_id
 order by revenue desc
```
