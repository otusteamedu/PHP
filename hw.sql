select element.name as film,
       p.code       as attr_name,
       p.type       as attr_typ,
       case
           when p.type = 'int' then v.i_value::text
           else
               v.s_value
           end      as val
from element
         left join category as cat on cat.id = element.category_id
         left join property p on cat.id = p.category_id
         left join value v on element.id = v.element_id and p.id = v.property_id
where cat.code = 'film'
order by film
;
