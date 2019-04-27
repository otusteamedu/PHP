create view marketing as
    select film.name, attribute_type.name as type, attribute.name as attribute,
       CASE attribute_type.name
           WHEN 'integer' THEN CAST (attribute_value.integer_value AS text)
           WHEN 'time' THEN CAST (attribute_value.time_value AS text)
           WHEN 'date' THEN CAST (attribute_value.date_value AS text)
           WHEN 'timestamp' THEN CAST (attribute_value.timestamp_value AS text)
           WHEN 'text' THEN CAST (attribute_value.text_value AS text)
           WHEN 'boolean' THEN CAST (attribute_value.boolean_value AS text)
           ELSE null
           END as value
    from film
         left join film_attribute on film.id = film_attribute.film_id
         inner join attribute on film_attribute.attribute_id = attribute.id
         inner join attribute_type on attribute.attribute_type_id = attribute_type.id
         inner join attribute_value on film_attribute.attribute_value_id = attribute_value.id
    order by film.id;

create view tasks as
    select film.name,
       CASE at1.name
           WHEN 'integer' THEN CAST (av1.integer_value AS text)
           WHEN 'time' THEN CAST (av1.time_value AS text)
           WHEN 'date' THEN CAST (av1.date_value AS text)
           WHEN 'timestamp' THEN CAST (av1.timestamp_value AS text)
           WHEN 'text' THEN CAST (av1.text_value AS text)
           WHEN 'boolean' THEN CAST (av1.boolean_value AS text)
           ELSE null
           END as act_on_2019_04_01,
       CASE at2.name
           WHEN 'integer' THEN CAST (av2.integer_value AS text)
           WHEN 'time' THEN CAST (av2.time_value AS text)
           WHEN 'date' THEN CAST (av2.date_value AS text)
           WHEN 'timestamp' THEN CAST (av2.timestamp_value AS text)
           WHEN 'text' THEN CAST (av2.text_value AS text)
           WHEN 'boolean' THEN CAST (av2.boolean_value AS text)
           ELSE null
           END as act_on_2019_04_20
    from film
         inner join film_attribute fa1 on film.id = fa1.film_id
         inner join attribute a1 on (fa1.attribute_id = a1.id and a1.id = 8)
         inner join attribute_type at1 on a1.attribute_type_id = at1.id
         inner join attribute_value av1 on fa1.attribute_value_id = av1.id

         inner join film_attribute fa2 on film.id = fa2.film_id
         inner join attribute a2 on (fa2.attribute_id = a2.id and a2.id = 9)
         inner join attribute_type at2 on a2.attribute_type_id = at2.id
         inner join attribute_value av2 on fa2.attribute_value_id = av2.id
    order by film.id;


