-- 1) запрос на все билеты с ценой выше 1000
SELECT id FROM tickets
WHERE price >= 1000;
-- 2) запрос на сумму с продаж для сессий на определенные места
SELECT session_id, SUM(price) FROM public.tickets
WHERE place_id in (1, 8, 5, 5587, 9999, 111, 123)
GROUP BY session_id
ORDER BY session_id;
-- 3) Запрос значений атрибутов для определенных фильмов и атрибутов
SELECT * from movies_attr_value mav
WHERE length(mav.value_string) > 10
order by length(mav.value_string);
-- 4) запрос на сборы по фильмам, по билетам с ценой места в зале более 500 и с ценой сеанса менее 500
SELECT m.name, SUM(t.price) FROM public.tickets t
INNER JOIN public.sessions s ON t.session_id = s.id
INNER JOIN public.halls h ON h.id = s.hall_id
INNER JOIN public.places p ON h.id = p.hall_id AND t.place_id = p.id
INNER JOIN public.movies m ON m.id = s.movie_id
WHERE p.place_tariff > 500
and s.session_tariff < 500
GROUP BY m.id
ORDER BY m.name;
-- 5) запрос на сборы по фильмам (с определенными типами атрибутов), сгруппированные по залам.
SELECT h.name, m.name, m.description, sum(t.price) from tickets t
inner join public.sessions s on s.id = t.session_id
inner join public.movies m on m.id = s.movie_id
inner join public.halls h on h.id = s.hall_id
where m.id = 100
group by (h.id, m.id)
order by (h.name, m.name);
-- 6) вывести все атрибуты c длиной текстового значения меньше 10.
select m."name" as movie_id, ma.name as movie_attr_name, mav.value_date from public.movies_attr_value mav
inner join public.movies m on m.id = mav.movie_id
inner join public.movies_attr ma on ma.id  = mav.movie_attr_id
where length(mav.value_string) < 10
order by m.name;

