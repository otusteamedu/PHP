-- дата премьеры
create view date_of_service as 
select m."name", a.showname, av.value_date from attribute_value av 
left join "attribute" a on a.id = av.attribute_id 
left join movie m on m.id = av.movie_id 
where a.name = 'date_of_premier';

