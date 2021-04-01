-- Задачи
create view movie_task as 
select m."name", 
		(case 
		when av.value_date = CURRENT_DATE
	 	   		then value_text
	 	else '-'
		end) as "Задачи на сегодня",
		(case 
		when av.value_date = CURRENT_DATE + interval '20' day
	 	   		then value_text
	 	else '-'
		end) as "Выполнить через 20 дней"
from attribute_value av 
left join "attribute" a on a.id = av.attribute_id 
left join movie m on m.id = av.movie_id
where a."name" = 'task' and (av.value_date = CURRENT_DATE or av.value_date = CURRENT_DATE + interval '20' day);