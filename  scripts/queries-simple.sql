-- пользователи с доменом ru
select 
	tu.firstname || ' ' || tu.lastname as "Пользователь",
	tu.email as "Почта" 
from "tUsers" tu where tu.email like '%ru';


-- Сеансы на 9 часов
select * from "tSessions" ts where ts.date = current_date + '5 days'::interval 
	and ts ."time" = '9:00'::time;
-- Сеансы на дату + 5 дней от текущей
select * from "tSessions" ts where ts.date = current_date + '5 days'::interval order by ts.time;

-- Количество проданных билетов проданных 3 дня назад
select count(*) from "tTickets" tt 
where tt.date_sale::date = (current_date - '3 days'::interval)::date;

