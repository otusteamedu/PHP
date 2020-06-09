/**
 * Самый собираемый фильм в данной сети кинотеатров
 */
select m2.id, m2."name", sum(ss.rate) as box_office, sum((1 - cast (oi.discount as float) / 100) * ss.rate) as box_office_with_discount
from movie m2
inner join "session" s on s.movie_id = m2.id
inner join session_seat ss on ss.session_id = s.id
inner join order_item oi on oi.session_seat_id = ss.id
group by m2.id
order by box_office_with_discount desc
limit 1