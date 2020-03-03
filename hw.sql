select element.name as film,
       p.code       as attr_name,
       p.type       as attr_typ,
       case
           when p.type = 'integer' then v.value_integer::text
           when p.type = 'date' then v.value_date::text
           when p.type = 'bool' then v.value_bool::text
           when p.type = 'float' then v.value_float::text
           else
               v.value_text
           end      as val
from element
         left join category as cat on cat.id = element.category_id
         left join property p on cat.id = p.category_id
         left join value v on element.id = v.element_id
where cat.code = 'film'
  and p.id = v.property_id
order by film
;

select e.name as film,
       val.value_date

from value as val
         join element e on val.element_id = e.id
         join category c on val.category_id = c.id
         join property p on val.property_id = p.id
where val.value_date in ('2020-01-10', '2020-03-27')
  and p.code = 'event1'
  and c.code = 'film';