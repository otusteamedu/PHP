-- queries

-- 1) выбрать все сеансы определенных фильмов
select
	id,
	film_id,
	hall_id,
	start
from session as s
where film_id in (1, 111, 999)
order by film_id
;

-- 2) выбрать все сеансы в определенных залах
select
	id,
	film_id,
	hall_id,
	start
from session as s
where hall_id in (1, 222, 876)
order by hall_id
;

-- 3) выбрать все билеты определенных сеансов
select
	id,
	session_id,
	place,
	price
from ticket as t
where session_id in (10100, 14000, 20000)
order by session_id
;

-- 4) выбрать все билеты определенных клиентов на сеансы следующей недели
select
	c.name,
	f.name,
	s.start,
	h.name as hall_name,
	t.place as hall_place
from client_ticket as ct
join client as c on c.id = ct.client_id
join ticket as t on t.id = ct.ticket_id
join session as s on s.id = t.session_id
join film as f on f.id = s.film_id
join hall as h on h.id = s.hall_id
where s.start >= (CURRENT_TIMESTAMP)
	and s.start <= (CURRENT_TIMESTAMP + interval '14 days')
order by s.start
;

-- 5) вывести данные о продажах билетов по месяцам за год
-- (кол-во билетов за месяц, сумма)
select
	r.year,
	sum(case when r.month = 1 then r.price end) as january,
	sum(case when r.month = 2 then r.price end) as february,
	sum(case when r.month = 3 then r.price end) as march,
	sum(case when r.month = 4 then r.price end) as april,
	sum(case when r.month = 5 then r.price end) as may,
	sum(case when r.month = 6 then r.price end) as june,
	sum(case when r.month = 7 then r.price end) as july,
	sum(case when r.month = 8 then r.price end) as august,
	sum(case when r.month = 9 then r.price end) as september,
	sum(case when r.month = 10 then r.price end) as october,
	sum(case when r.month = 11 then r.price end) as november,
	sum(case when r.month = 12 then r.price end) as december
from
(
	select
		s.start,
		t.price,
		extract(year from s.start) as year,
	    extract(month from s.start) as month
	from client_ticket as ct
	join ticket as t on t.id = ct.ticket_id
	join session as s on s.id = t.session_id
	where (
			s.start >= (CURRENT_TIMESTAMP - interval '1 year')
			and
			s.start <= CURRENT_TIMESTAMP
		  )
) as r
group by year
;

-- 6) запрос атрибутов по фильмам, которые показывались на прошлой и будующей неделе
-- для показа этих данных в афише на сайте
select
	f.name,
	string_agg(concat(h.name, ': ', date_trunc('minute', s.start)), '; ') as sessions,
	string_agg(concat(
		fa.name, ': ',
		coalesce(
			fav.val_date::text,
			fav.val_text,
			fav.val_int::text,
			fav.val_decimal::text,
			fav.val_bool::text
		)
	), '; ') as attrs
from ticket as t
join session as s on s.id = t.session_id
join film as f on f.id = s.film_id
join hall as h on h.id = s.hall_id
join film_attribute_value as fav on fav.film_id = f.id
join film_attribute as fa on fa.id = fav.attribute_id
join film_attribute_type as fat on fat.id = fa.type_id
where s.start >= (CURRENT_TIMESTAMP - interval '7 days')
	and s.start <= (CURRENT_TIMESTAMP + interval '7 days')
	group by f.name
;