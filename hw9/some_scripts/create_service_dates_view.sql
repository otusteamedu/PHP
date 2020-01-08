create view service_dates as
select
	f.name,
	current_dates.current_date_detail,
	future_dates.future_date_detail
from (
	select
		fav1.film_id,
		string_agg(concat(fa1.name, ': ', fav1.val_date), '; ') as current_date_detail
	from film_attribute_value as fav1
	join film_attribute as fa1 on fa1.id = fav1.attribute_id
	join film_attribute_type as fat1 on fat1.id = fa1.type_id
	where fat1.id = 6
		and fav1.val_date <= CURRENT_DATE
	group by fav1.film_id
	) as current_dates
left join (
	select
		fav2.film_id,
		string_agg(concat(fa2.name, ': ', fav2.val_date), '; ') as future_date_detail
	from film_attribute_value as fav2
	join film_attribute as fa2 on fa2.id = fav2.attribute_id
	join film_attribute_type as fat2 on fat2.id = fa2.type_id
	where fat2.id = 6
		and fav2.val_date > (CURRENT_DATE + interval '20 days')
	group by fav2.film_id
	) as future_dates
		on future_dates.film_id = current_dates.film_id
join film as f
	on f.id = current_dates.film_id or f.id = future_dates.film_id
;