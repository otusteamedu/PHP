truncate "tUserTickets" cascade;
truncate "tTickets" cascade;
truncate "tSessions" cascade;

-- Sessions
do
$$
declare

	startOffsetDate integer := -40; -- 0 для одного дня
	endOffsetDate integer := 40; -- 0 для одного дня
	rowsCounter integer := 0;

	minPrice integer := 1000;
	maxPrice integer := 5000;

	moviesIds integer[];
	hallId integer;
	d integer;


	
begin
	select array(select id from "tFilms") into moviesIds ;

	for d in startOffsetDate..endOffsetDate 
	loop
	
		for hallId in select id from "tHalls"
		loop
		
			for h in 9..21 by 3
			loop
		
				insert into "tSessions" (hall_id, movie_id, date, time, price) values
				(
				hallId,
				moviesIds[random_int(1, array_length(moviesIds, 1))],
				(current_date + (d::text || ' days')::interval)::date,
				(h::text || ':00:00')::time,
				random_int(minPrice, maxPrice)
				);
			
				rowsCounter = rowsCounter + 1;
			
			end loop;
		
		end loop;
	
	end loop;

	raise info 'insert to "tSessions" % rows', rowsCounter;

end;
$$ language plpgsql;
























