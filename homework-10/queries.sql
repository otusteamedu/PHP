-- 1. Выбрать все билеты купленные вчера
select * from tickets where created_at::date = current_date - 1;

-- 2. Выбрать все сеансы, базовая стоимость которых равна 100 единицам за 2019 год
select * from sessions where price = 100 and extract(year from starts_at) = 2019;

-- 3. Дата продажи первого билета
select * from tickets order by created_at limit 1;

-- 4. Средняя стоимость билета на первом ряду
select avg(tickets.cost) from tickets
left join seats on seats.id = tickets.seat_id
left join rows on rows.id = seats.row_id
where rows.number = 1;

-- 5. Посчитать наибольшую и наименьшую прибыль сеанса за последние 5 дней
select min(overal_cost) as min_overal_cost, max(overal_cost) as max_overal_cost from (
    select tickets.session_id as session_id, sum(tickets.cost) as overal_cost from tickets
    where created_at::date between current_date::date - interval '7 days' and current_date
    group by session_id
) as aggregate_data;

-- 6. Фильм с наибольшими сборами
select movies.id, movies.name, sum(tickets.cost) as box_office from tickets
left join sessions on sessions.id = tickets.session_id
left join movies on movies.id = sessions.movie_id
group by movies.id
order by box_office desc
limit 1;
