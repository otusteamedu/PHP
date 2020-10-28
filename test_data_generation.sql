/* генерация записей в залы */
insert into halls(name, site_count)
select array_to_string(
               array(select chr((ascii('A') + round(random() * 25))::integer)
                     from generate_series(1, 10 + 0 * x)), ''),
       int2((50 + random() * 100)::integer)
from generate_series(1, 100000) as x;

/*тестовые вызовы для проверки данных*/
select name
from halls group by name;

delete
from halls;