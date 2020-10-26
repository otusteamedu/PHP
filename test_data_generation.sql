/* генерация записей в залы */
insert into halls(name, site_count)
select array_to_string(
               array(select chr((ascii('A') + round(random() * 25))::integer)
                     from generate_series(1, 10)), ''),
       int2((50 + random() * 100)::integer)
from generate_series(1, 10);

/*тестовые вызовы для проверки данных*/
select *
from halls;

delete
from halls;