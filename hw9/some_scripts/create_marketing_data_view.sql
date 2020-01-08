create view marketing_data as
select
	f.name as film_name,
	fat.name as attribute_type,
	fa.name as attribute_name,
	case fat.id
		when 1 then fav.val_text
		when 2 then cast(fav.val_bool as text)
		when 3 then cast(fav.val_date as text)
		when 4 then cast(fav.val_int as text)
		when 5 then cast(fav.val_decimal as text)
		when 6 then cast(fav.val_date as text)
	end as attribute_value
from film_attribute_value as fav
join film_attribute as fa on fa.id = fav.attribute_id
join film_attribute_type as fat on fat.id = fa.type_id
join film as f on f.id = fav.film_id
;