create or replace view marketing_view as
    select
        movies.name as movie_name,
        attribute_types.name as attribute_type,
        attributes.name as attribute_name,
        coalesce(
            attribute_movie_values.text_value, 
            attribute_movie_values.string_value, 
            attribute_movie_values.integer_value::text, 
            attribute_movie_values.money_value::text, 
            attribute_movie_values.date_value::text,
            attribute_movie_values.boolean_value::text
        ) as attribute_value
    from movies
    left join attribute_movie_values on attribute_movie_values.movie_id = movies.id
    left join attributes on attributes.id = attribute_movie_values.attribute_id
    left join attribute_types on attribute_types.id = attributes.type_id
    order by movies.id
