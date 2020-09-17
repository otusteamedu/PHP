CREATE OR REPLACE FUNCTION public.fake_client()
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
	declare
	    	client_id integer;
	BEGIN
		INSERT INTO public.client ("name") VALUES (random_string(random_int(3, 10))||' '||random_string(random_int(3, 10))) RETURNING id INTO client_id;
		return client_id;
	END;
$function$
;

CREATE OR REPLACE FUNCTION public.fake_hall(seat_type_id_list integer[])
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
	declare
    	hall_id integer;
    	st_id integer;
	BEGIN
		INSERT INTO public.hall ("name") VALUES (random_string(random_int(3, 8))) RETURNING id INTO hall_id;
		FOREACH st_id IN ARRAY seat_type_id_list loop
			INSERT INTO public.seats (hall_id, seat_type_id, quantity) VALUES (hall_id, st_id, random_int(5, 60));
		END LOOP;
		return hall_id;

	END;
$function$
;

CREATE OR REPLACE PROCEDURE public.fake_movie()
 LANGUAGE plpgsql
AS $procedure$
	declare
    	movie_id integer;
    	integer_value integer;
    	text_value text;
    	short_text_value varchar(255);
    	boolean_value boolean;
    	decimal_value float;
    	datetime_value timestamp;
    	attr_id integer; attr_type integer;
	BEGIN
		INSERT INTO public.movie ("name") VALUES (random_string(random_int(5, 15))) RETURNING id INTO movie_id;

		FOR attr_id, attr_type in select id, attribute_type_id from movie_eav_attribute mea
		loop
			integer_value := null;
			text_value := null;
			short_text_value := null;
			boolean_value := null;
			decimal_value := null;
			datetime_value := null;
			CASE
				WHEN attr_type=1 THEN integer_value := random_int(1, 1000);
	            WHEN attr_type=2 THEN text_value := random_string(random_int(500, 1500));
	            WHEN attr_type=3 THEN datetime_value := NOW() + (random() * (NOW()+'90 days' - NOW())) + '30 days';
	            WHEN attr_type=4 THEN short_text_value := random_string(random_int(16, 32));
	            WHEN attr_type=5 THEN boolean_value := random() > 0.5;
	            WHEN attr_type=6 THEN decimal_value := random()*(100-1)+1;

       		END CASE;
       		INSERT INTO public.movie_eav_value
				("movie_id", "attribute_id", "integer_value", "text_value", "short_text_value", "boolean_value", "decimal_value", "datetime_value")
			VALUES(movie_id, attr_id, integer_value, text_value, short_text_value, boolean_value, decimal_value, datetime_value);
--		   RETURN NEXT;
		END LOOP;


	END;
$procedure$
;

CREATE OR REPLACE FUNCTION public.fake_places(session_id integer, hall_id_value integer)
 RETURNS integer[]
 LANGUAGE plpgsql
AS $function$
	declare
		p_ids integer[];
		p_id integer;
		s_id integer;
	BEGIN
		FOR s_id in select id as s_id from seats where "hall_id" = hall_id_value loop
			INSERT INTO public.place ("session_id", "seats_id", "price") VALUES (session_id, s_id, random_int(100, 500)::float) RETURNING id INTO p_id;
			p_ids = array_append(p_ids, p_id);
		END LOOP;
		return p_ids;
	END;
$function$
;

CREATE OR REPLACE FUNCTION public.fake_session(hall_id integer, movie_id integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
	declare
		session_id integer;
	BEGIN
		INSERT INTO public.session ("hall_id", "movie_id", "date") VALUES (hall_id, movie_id,
			NOW() + (random() * (NOW()+'90 days' - NOW())) + '30 days'
		) RETURNING id INTO session_id;
		return session_id;
	END;
$function$
;

CREATE OR REPLACE FUNCTION public.fake_ticket(client_id integer, place_id integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
	declare
		t_id integer;
	BEGIN
		INSERT INTO public.ticket ("client_id", "paid", "place_id", "seat_number")
			VALUES (client_id, random_int(100, 500)::float, place_id, random_int(1, 60)) RETURNING id INTO t_id;
		return t_id;
	END;
$function$
;

CREATE OR REPLACE PROCEDURE public.fill_data(size integer)
 LANGUAGE plpgsql
AS $procedure$
	DECLARE
    	movies_qty integer := ceil(size / 500);
    	halls_qty integer := ceil(size / 10000);
    	clients_qty integer := ceil(size / 100);
    	movie_id integer;
    	session_id integer;
    	hall_id integer;
    	place_id integer;
    	client_id integer;
    	movies_id_list integer[];
    	halls_id_list integer[];
    	seat_type_id_list integer[];
    	clients_id_list integer[];
    	item_id integer;
    	places_id_list integer[];
	BEGIN

		for i in 1..movies_qty loop
            call fake_movie();
        end loop;

   		seat_type_id_list := array(select id from seat_type);
   		for i in 1..halls_qty loop
   			perform fake_hall(seat_type_id_list);
   		end loop;

   		halls_id_list := array(select id from hall);

   		FOR movie_id in select id from movie loop
	    	for i in 1..random_int(1, 3) loop
	    		hall_id := halls_id_list[random_int(1, cardinality(halls_id_list))];
				session_id := fake_session(hall_id, movie_id);
				perform fake_places(session_id, hall_id);
			end loop;
		END LOOP;

   		for i in 1..clients_qty loop
   			perform fake_client();
   		end loop;

   		places_id_list := array(select id from place);
   		clients_id_list := array(select id from client);
	   	for i in 1..size loop
	   		place_id := places_id_list[random_int(1, cardinality(places_id_list))];
	   		client_id := clients_id_list[random_int(1, cardinality(clients_id_list))];
	   		perform fake_ticket(client_id, place_id);
	   	end loop;


	END;
$procedure$
;

CREATE OR REPLACE FUNCTION public.random_int(min_value integer, max_value integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
	begin
		if min_value > max_value then return min_value; end if;
		return floor(random() * (max_value-min_value+1) + min_value);


	end;
$function$
;

CREATE OR REPLACE FUNCTION public.random_string(length integer)
 RETURNS text
 LANGUAGE plpgsql
AS $function$
	DECLARE
	  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
	  result text := '';
	  i integer := 0;
	BEGIN
	  if length < 0 then
	    raise exception 'Given length cannot be less than 0';
	  end if;
	  for i in 1..length loop
	    result := result || chars[1+random()*(array_length(chars, 1)-1)];
	  end loop;
	  return result;
	END;
$function$
;
