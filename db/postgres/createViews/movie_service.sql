-- фильм, тип атрибута, атрибут, значение (значение выводим как текст)
create view movie_service as 
select m."name" as movie,
       at2."name" as attribute_type,
       a.showname as "attribute",
	   (case
	 	   when at2."name" = 'text'  
	 	   		then value_text
	 	   when at2."name" = 'int'  
                then value_int::text
	 	   when at2."name" = 'float'  
                then value_float::text
	 	   when at2."name" = 'date'  
                then value_date::text
	 	   when at2."name" = 'bool'  
                then 'true'
           else null
        end) as value
from attribute_value av 
left join "attribute" a on a.id = av.attribute_id 
left join attribute_type at2 on at2.id = a.attribute_type_id 
left join movie m on m.id = av.movie_id 
order by showname;
