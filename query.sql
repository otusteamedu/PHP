WITH num_ticket AS (
	SELECT id_session, count(id) AS num FROM tickets AS t GROUP BY id_session
), session_total AS (
	SELECT nt.id_session, (s.price * nt.num) AS session_total FROM num_ticket AS nt
	JOIN session AS s ON s.id = nt.id_session
), content_total AS (
	SELECT s.id_content, SUM(st.session_total) AS content_total FROM session AS s
	JOIN session_total AS st ON s.id=st.id_session
	GROUP BY s.id_content
	ORDER BY content_total DESC 
	LIMIT 1
)
SELECT c.name, ct.content_total FROM content AS c 
JOIN content_total AS ct ON ct.id_content=c.id 
