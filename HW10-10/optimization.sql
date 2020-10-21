DROP INDEX IF EXISTS film_sessions_hall_id_indx;
DROP INDEX IF EXISTS tickets_session_id_indx;
DROP INDEX IF EXISTS film_sessions_film_id_indx;
DROP INDEX IF EXISTS orders_client_id_indx;
CREATE INDEX film_sessions_hall_id_indx ON film_sessions (hall_id);
CREATE INDEX tickets_session_id_indx ON tickets (session_id);
CREATE INDEX film_sessions_film_id_indx ON film_sessions (film_id);
CREATE INDEX orders_client_id_indx ON orders (client_id);