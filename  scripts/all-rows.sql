
select 'Films' as "Table",  count(*) as "Rows count" from "tFilms" 

union all

select 'Halls' as "Table",  count(*) as "Rows count" from "tHalls" 

union all

select 'Sessions' as "Table",  count(*) as "Rows count" from "tSessions" 

union all

select 'Tickets' as "Table",  count(*) as "Rows count" from "tTickets" 

union all 

select 'Users' as "Table",  count(*) as "Rows count" from "tUsers"

union all

select 
	' - ' as "Table", 
	(select count(*) from "tHalls") + 
	(select count(*) from "tUsers") + 
	(select count(*) from "tSessions") +
	(select count(*) from "tTickets") +
	(select count(*) from "tFilms")
		as "Rows count";