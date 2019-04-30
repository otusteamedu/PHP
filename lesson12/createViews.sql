create or replace view test_db.market_view
as
select film.title,
       attribute_type.title as type,
       attribute_name.title as attribute,
       case attribute_type.type
           when 'integer'::text then attribute_value.int_val::text
           when 'timestamp'::text then attribute_value.date_val::text
           when 'text'::text then attribute_value.text_val
           when 'boolean'::text then attribute_value.bool_val::text
           else null::text
           end              as value
from film
         left join film_attribute on film.id = film_attribute.film_id
         left join attribute_name on film_attribute.attribute_name_id = attribute_name.id
         left join attribute_type on film_attribute.attribute_type_id = attribute_type.id
         left join attribute_value on film_attribute.attribute_value_id = attribute_value.id
order by film.id;


create or replace view test_db.work_tasks
as
select film.title,
       string_agg(DISTINCT today_work.title, ', ') as today,
       string_agg(DISTINCT future_work.title, ',') as future
from film
         left join (
    select fa_today.film_id, a_today.title as title
    from film_attribute fa_today
             left join attribute_name a_today on fa_today.attribute_name_id = a_today.id
             left join attribute_type at_today on (fa_today.attribute_type_id = at_today.id and at_today.code = 'work')
             left join attribute_value av_today on fa_today.attribute_value_id = av_today.id
    where date(av_today.date_val) = current_date) as today_work on film.id = today_work.film_id
         left join (
    select fa_future.film_id, a_future.title as title
    from film_attribute fa_future
             left join attribute_name a_future on fa_future.attribute_name_id = a_future.id
             left join attribute_type at_future
                       on (fa_future.attribute_type_id = at_future.id and at_future.code = 'work')
             left join attribute_value av_future on fa_future.attribute_value_id = av_future.id
    where date(av_future.date_val) = current_date + interval '20 day') as future_work on film.id = future_work.film_id
group by film.id;