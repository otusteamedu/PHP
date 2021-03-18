-- Пользователь ru количество билетов и потраченная сумма
select 
	tu.firstname || ' ' || tu.lastname as "Пользователь",
	tu.email as "Почта",
	sum(tt.price) as "Потраченная сумма", 
	count(tt.id) as "Количество билетов" 
from "tUserTickets" tut
	left join "tTickets" tt on tt.id = tut.ticket_id
	left join "tUsers" tu on tu.id = tut.user_id 
where tu.email like '%ru'
group by tu.id
order by "Потраченная сумма" DESC;

-- Сборы с фильмов
select
	tf.title as "Фильм", 
	count(tt.id) "Количество билетов", 
	sum(tt.price) as "Сумма сбора" 
from "tTickets" tt
	left join "tSessions" ts on ts.id = tt.session_id 
	left join "tFilms" tf on tf.id = ts.movie_id 
group by tf.id
order by "Сумма сбора" desc;
	

-- количестов свободных мест в залах на дату, время
select 
	th.name as "Зал", 
	th.number_rows * th.seats_in_row - count(tt.id) as "Количество свободных мест",
	ts."date"::text || ' ' || ts."time"::text as "Дата время"
from "tTickets" tt
	left join "tSessions" ts on ts.id = tt.session_id 
	left join "tHalls" th on th.id = ts.hall_id 
	where ts."date" = (current_date - '1 days'::interval) and ts.time = '12:00'::time
	group by th.id, ts.id
	order by th.name;
	



