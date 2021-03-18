CREATE OR replace VIEW "vTickets" AS

SELECT f.title, t.date_sale, t.price, t.row, t.seat FROM "tTickets" t
	LEFT JOIN "tSessions" s ON s.id = t.session_id
	left join "tFilms" f on f.id = s.movie_id;



