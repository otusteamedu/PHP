create view marketing as
    select film.name, attribute.name as attribute,
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
    order by film.id