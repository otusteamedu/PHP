create or replace view tasks as
select
    m.name as movie,
    string_agg(case when mav.date between current_date and (current_date + interval '1 day') then ma.name end, ', ') as today,
    string_agg(case when mav.date between (current_date + interval '1 day') and (current_date + interval '20 day') then ma.name end, ', ') as in_twenty_days
from movie_values mav
inner join movies m on m.id = mav.movie_id
inner join movie_attrs ma on ma.id = mav.attr_id
where mav.date is not null and mav.date between current_date and (current_date + interval '20 day')
group by m.name
;

create or replace view marketing as
select
    m.id as movie_id,
    m.name as movie_name,
    ma.name as attr_name,
    coalesce(bool::varchar, text::varchar, int::varchar, numeric::varchar, date::varchar) as attr_val
from movie_values mav
inner join movies m on mav.movie_id = m.id
inner join movie_attrs ma on mav.attr_id = ma.id
;
