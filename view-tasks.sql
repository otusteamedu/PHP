create or replace view movies."vTasks" as
	with current_tasks as (
	select v.film_id as "film", a.name as n from movies."values" v
		left join movies."attributes" a on v.attr_id = a.id
		left join movies."types" t on a.type_id = t.id 
	where t.name = 'Служебные даты'  and v.val_date = current_date 
	), scheduled_tasks as (
	select v.film_id as "film", a.name as n from movies."values" v 
			left join movies."attributes" a on v.attr_id = a.id
			left join movies."types" t on a.type_id = t.id 
		where t.name = 'Служебные даты'  and v.val_date = (current_date + interval '20 days')
	)
	select
		f.title as "Фильм",
		(select n from current_tasks where current_tasks.film = f.id) as "Задачи на сегодня", 
		(select n from scheduled_tasks where scheduled_tasks.film = f.id) as "Задачи через 20 дней" 
	from movies.films f;