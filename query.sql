WITH ticket_pr AS (
    SELECT tp.*, t.id_session FROM ticket_price tp 
    join tickets t on t.id=tp.id 
), session_price as (
	select id_session, sum(price) as col_session_price from ticket_pr
	group by id_session 
), session_content as (
	select sp.*, s.id_content from "session" s 
	join session_price sp on sp.id_session=s.id
), content_price as (
	select id_content, sum(col_session_price) as col_content_price from session_content
	group by id_content 
)
select c."name", cp.col_content_price from content as c
join content_price cp on cp.id_content=c.id
order by cp.col_content_price DESC
limit 1
