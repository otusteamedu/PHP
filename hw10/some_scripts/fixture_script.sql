-- client table
insert into client (id, name)
	select
		gs.id,
		concat('Client Name ', gs.id)
	from generate_series(5, 10000) as gs(id)
;

-- film table
insert into film (id, name)
	select
		gs.id,
		concat('Film Name ', gs.id)
	from generate_series(4, 10000) as gs(id)
;

-- hall table
insert into hall (id, name, size)
	select
		gs.id,
		concat('Hall Name ', gs.id),
		10000000
	from generate_series(5, 10000) as gs(id)
;

-- session table
insert into session (id, film_id, hall_id, start)
	select
		gs.id,
		(random()*10000)::integer,
		(random()*10000)::integer,
		timestamp '2019-01-01 00:00:00' +
   		random() * (timestamp '2020-03-01 20:00:00' -
               		timestamp '2019-01-01 00:00:00')
	from generate_series(10010, 20000) as gs(id)
;

-- ticket table - первый вариант до оптимизации
insert into ticket (id, session_id, place, price)
	select
		gs.id,
		floor(random() * (20000 - 10010 + 1) + 10010)::int,
		(random()*10000)::integer,
		(random()*5000)::integer
	from generate_series(20, 10000) as gs(id)
;

-- ticket_v2 table - для 4 запроса
insert into ticket_v2 (id, session_id, client_id, film_id, hall_id, place, price)
	select
		gs.id,
		ceil(random()*1000000)::int,
		ceil(random()*1000000)::int,
		ceil(random()*100000)::int,
		ceil(random()*10000)::int,
		ceil(random()*10000)::int,
		ceil(random()*10000)::int
	from generate_series(1, 5000000) as gs(id)
;

-- film_attribute_type table
insert into film_attribute_type (id, name)
	select
		gs.id,
		concat('Film attribute TYPE ', gs.id)
	from generate_series(7, 100) as gs(id)
;

-- film_attribute table
insert into film_attribute (id, name, type_id)
	select
		gs.id,
		concat('Film attribute ', gs.id),
		floor(random() * (1 - 100 + 1) + 100)::int
	from generate_series(18, 1000) as gs(id)
;

-- film_attribute_value table
insert into film_attribute_value (id, attribute_id, film_id,
	val_date, val_text, val_int, val_decimal, val_bool)
	select
		gs.id,
		floor(random() * 1000 + 1)::int,
		floor(random() * 10000 + 1)::int,
		case
			when (right(gs.id::text, 1)::int) <= 2 then
					timestamp '2019-01-01 00:00:00' +
   					random() * (timestamp '2020-03-01 20:00:00' -
               		timestamp '2019-01-01 00:00:00')
		end,
		case
			when ((right(gs.id::text, 1)::int) > 2) and ((right(gs.id::text, 1)::int) <= 4) then
					md5(random()::text)
		end,
		case
			when ((right(gs.id::text, 1)::int) > 4) and ((right(gs.id::text, 1)::int) <= 6) then
					floor(random() * (1 - 100 + 1) + 100)::int
		end,
		case
			when ((right(gs.id::text, 1)::int) > 6) and ((right(gs.id::text, 1)::int) <= 8) then
					random() * (1 - 100 + 1) + 100::numeric
		end,
		case
			when ((right(gs.id::text, 1)::int) > 8) then
					floor(random())::int::boolean
		end
	from generate_series(50, 10000) as gs(id)
;

-- client_ticket table
insert into client_ticket (client_id, ticket_id)
	select
		floor(random() * (10000 - 1 + 1) + 1)::int,
		floor(random() * (10000 - 2 + 1) + 2)::int
	from generate_series(18, 10000) as gs(id)
;