-- Я понимаю, что надо делать через WITH, но эта конструкция вызывает ошибку.
-- SQL Error [42P01]: ERROR: relation "cm_table" does not exist
--   Position: 39

-- WITH total_ticket_table AS (
--    SELECT id_session, SUM(t.price) AS total_ticket FROM tickets AS t GROUP BY t.id_session
-- )

-- WITH cm_table AS (
--     SELECT SUM(sum_ticket.total_ticket) AS total_session, s.id_content 
--     FROM total_ticket_table AS sum_ticket
--     JOIN session AS s ON s.id=sum_ticket.id_session
--     GROUP BY s.id_content
-- )

-- SELECT cm.total_session, c.name 
-- FROM cm_table AS cm
-- JOIN content AS c ON c.id =cm.id_content
-- ORDER BY total_session DESC
-- LIMIT 1


SELECT cm.total_session, c.name 
FROM 
    (SELECT SUM(sum_ticket.total_ticket) AS total_session, s.id_content FROM 
        (SELECT id_session, SUM(t.price) AS total_ticket FROM tickets AS t GROUP BY t.id_session) AS sum_ticket
            JOIN session AS s ON s.id=sum_ticket.id_session
            GROUP BY s.id_content) AS cm
    JOIN content AS c ON c.id =cm.id_content
ORDER BY total_session DESC
LIMIT 1
