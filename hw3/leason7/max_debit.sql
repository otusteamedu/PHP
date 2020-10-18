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
select * from t_total
order by t_sum desc
limit 1;
