

      
      
      CREATE VIEW act_tasks AS
select
now_date.film_name, 
now_date.attr_name as now_act_task ,
forward_date.attr_name as interval_days_20_act_task 
from (select film_name, date_val , attr_name  from attributes_value
	  join film on film.id=attributes_value.id_film
	  join attributes on attributes_value.id_attributes=attributes.id
	  where attributes_value.date_val>= current_date) as now_date
	  full outer join (
	  select film_name, date_val , attr_name from attributes_value
	  join film on film.id=attributes_value.id_film
		   join attributes on attributes_value.id_attributes=attributes.id
	  where attributes_value.date_val>= current_date+interval '20 days') as forward_date   
	  on  now_date.film_name=forward_date.film_name


      CREATE VIEW marketing AS
select 
film.film_name, 
attributes_types.type_name,
attributes_value.text_val,
attributes_value.boolean_val ,
attributes_value.date_val ,
attributes_value.realis_number_val ,
attributes_value.float_number_val,
attributes.attr_name
from film 
inner join attributes_value
on film.id=attributes_value.id_film
inner join attributes
on attributes_value.id_attributes=attributes.id
inner join attributes_types
on attributes.id_type=attributes_types.id

