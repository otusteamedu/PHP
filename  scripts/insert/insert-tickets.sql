truncate "tUserTickets" cascade;
truncate "tTickets" cascade;

do
$$
declare
-- строка из sessions
	rSession RECORD; 

-- ряд, место
	r integer;
	seat integer;


-- user data
	uid integer;
	uDisc integer;


	dPrice integer; -- цена с дискоунтом
	ticketId integer;

	isTicketUser boolean; -- есть ли пользователь у билет
	
	counter integer := 0;
	

begin

	for rSession in 
		select s.id as sid, s.date as d, s.time as t, s.price as p, h.number_rows as rc, h.seats_in_row as sc 
		from "tSessions" s
			left join "tHalls" h on h.id = s.hall_id 
	loop 
	
	
		for r in 1..rSession.rc loop
			
			for seat in 1..rSession.sc loop
			
				continue when random() < 0.02;
			
				isTicketUser = random() < 0.04;
			
				if isTicketUser then
				
					select id, discount from "tUsers" tu order by random() limit 1 into uid, uDisc;
					
					dPrice = rSession.p - (rSession.p * uDisc / 100);
				else
					dPrice = rSession.p;
					
				end if;
			
				
				insert into "tTickets" (session_id, price, date_sale, row, seat) values
				(
					rSession.sid,
					dPrice,
					random_datetime(rSession.d, random_int(1, 20) * (-1)),
					r,
					seat
				) returning id into ticketId;
			
				if isTicketUser then
					insert into "tUserTickets" (ticket_id, user_id) values (ticketId, uid);
				end if;
			
				counter = counter + 1;
				
			end loop;
		
		end loop;
	
	end loop;

	raise info 'Insert % tickets', counter;
	
end;
$$ language plpgsql;
























