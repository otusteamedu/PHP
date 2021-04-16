DROP TRIGGER IF EXISTS make_ticket ON public.seances;
DROP FUNCTION IF EXISTS task_date,fill_seats_fake_data, fill_seances_fake_data, fill_tickets_fake_data;
CREATE OR REPLACE FUNCTION task_date() RETURNS date
	AS $$ VALUES ((CURRENT_TIMESTAMP + RANDOM() * ( CURRENT_TIMESTAMP + INTERVAL '20 day' - CURRENT_TIMESTAMP ))::date), (CURRENT_DATE) ORDER BY random() LIMIT 1; $$
	LANGUAGE SQL;


CREATE OR REPLACE FUNCTION get_random_id_from(tbl regclass, OUT id integer) AS
$$
	BEGIN
		EXECUTE format('SELECT id FROM %s ORDER BY random() LIMIT 1', tbl) 
	INTO id;
	END
$$ 	LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION fill_seats_fake_data() RETURNS void AS
$$
DECLARE 
	hid public.halls%rowtype;
BEGIN
	DELETE FROM seats;
    FOR hid IN 
    	SELECT id FROM public.halls
    LOOP 
    	FOR "row" IN 1..4 LOOP 
		   RAISE NOTICE 'HID: %, Row: %', hid.id, "row";
		   INSERT INTO public.seats (hall_id, "number", "row", type_id)
		   SELECT
			   hid.id,
			   number_id."number",
			   "row",
			   get_random_id_from('public.seats_type')
		   FROM generate_series(1, 10) AS number_id("number");
		   
    	END LOOP;
    END LOOP;
    RETURN;
 END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fill_seances_fake_data(rows_count integer = 100) RETURNS void AS 
$$
BEGIN
	DELETE FROM public.seats_price;
	DELETE FROM public.tickets;
	DELETE FROM public.seances;
	WITH _seances AS (
		INSERT INTO public.seances (start_at ,end_at , hall_id , movie_id)
		SELECT
			w.d,
			w.d + INTERVAL '2 hours',
			get_random_id_from('public.halls'),
			get_random_id_from('public.movies')
		FROM generate_series( 
			date_trunc('hour', current_timestamp - INTERVAL '1 month'),
	        date_trunc('hour', current_timestamp) - '1 month'::interval  + (rows_count * 30 || ' minutes')::interval - '30 minutes'::interval, 
	        '30 minutes')AS w(d)
	    RETURNING id, hall_id)
    INSERT INTO public.seats_price (seance_id, seat_type_id, price)
    SELECT _seances.id, st.id, (random() * 2300 + 100)::integer 
    FROM _seances
    LEFT JOIN public.seats_type st ON st.id IS NOT NULL;
END $$ LANGUAGE plpgsql;
 
CREATE OR REPLACE FUNCTION fill_tickets_fake_data() RETURNS TRIGGER AS 
$$
BEGIN
	INSERT INTO public.tickets (customer_id,seance_id,seat_id)
	SELECT get_random_id_from('public.customers'), NEW.id, seats.id
	FROM public.seats seats WHERE seats.hall_id = NEW.hall_id ORDER BY random() LIMIT 30;
	RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER make_ticket
	AFTER INSERT ON public.seances 
	FOR EACH ROW
	EXECUTE PROCEDURE fill_tickets_fake_data();



