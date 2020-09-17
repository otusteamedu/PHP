create or replace view service_view as
    select
        movies.name,
        case 
            when attribute_movie_values.date_value = current_date 
            then attributes.name 
        end as today,
        case 
            when attribute_movie_values.date_value between current_date + 10 and current_date + 30 
            then attributes.name 
        end as other_day
    from movies
    left join attribute_movie_values on attribute_movie_values.movie_id = movies.id
    left join attributes on attributes.id = attribute_movie_values.attribute_id
    where
        attribute_movie_values.date_value = current_date
        or attribute_movie_values.date_value between current_date + 10 and current_date + 30
    order by movies.id
