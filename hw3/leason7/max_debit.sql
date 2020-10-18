-- Информация о фильме
-- сколько билетов продано и на какую сумму
/*
select
    f.name,
    count(t.id) 'Total tikets',
    sum(t.coast) 'Total sum'
from film f
         inner join seanse s on s.film=f.id
         inner join ticket t on t.seanse=s.id
group by f.name;
*/

-- Получить фильм с наибольшей выручкой
with t_total as (
    select f.name,
           count(t.id)  't_tikets',
           sum(t.coast) 't_sum'
    from film f
             inner join seanse s on s.film = f.id
             inner join ticket t on t.seanse = s.id
    group by f.name
)
select * from t_total
having max(`t_sum`) = `t_sum`;