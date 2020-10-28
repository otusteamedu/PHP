-- простые запросы

-- билеты дороже 100 руб
select *
from ticket
where coast >= 100;

-- все значения аттрибутов начинающихся на D
select *
from attr_values
where attr_value like 'D%';

-- все сеансы, которые начинаются после 01 декабря 2020
select *
from seanse
where start_show >= '2020-12-01 09:00:00';


-- сложные запросы

-- все фильмы с дополнительными аттрибутами
select f.name as "film",
       att.attr_type,
       attrs.attr_name,
       av.attr_value
from film f
         left join attr_values av on av.film = f.id
         left join atts on attrs.id = av.attr
         left join attr_types at on att.id = attrs.attr_type;

-- Получить фильм с наибольшей выручкой
with t_total as (
    select f.name,
           count(t.id)  as "t_tikets",
           sum(t.coast) as "t_sum"
    from film f
             inner join seanse s on s.film = f.id
             inner join ticket t on t.seanse = s.id
    group by f.name
)
select *
from t_total
order by t_sum desc
limit 1;

-- наиболее посещаемый зал

with t1 as (
    select hall.name        as "hall",
           count(ticket.id) as "ticket_count"
    from hall
             inner join seanse on seanse.hall = hall.id
             inner join ticket on ticket.seanse = seanse.id
    group by hall.name
)

select *
from t1
order by ticket_count desc
limit 1;

