-- public.client definition

-- Drop table

-- DROP TABLE public.client;

CREATE TABLE public.client (
                               id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
                               "name" varchar(255) NOT NULL,
                               CONSTRAINT client_pk PRIMARY KEY (id)
);
CREATE INDEX client_name_len_idx ON public.client USING btree (length((name)::text));


-- public.hall definition

-- Drop table

-- DROP TABLE public.hall;

CREATE TABLE public.hall (
                             id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
                             "name" varchar(255) NOT NULL,
                             CONSTRAINT hall_pk PRIMARY KEY (id)
);


-- public.movie definition

-- Drop table

-- DROP TABLE public.movie;

CREATE TABLE public.movie (
                              id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
                              "name" varchar(255) NOT NULL,
                              CONSTRAINT movie_pk PRIMARY KEY (id)
);


-- public.movie_eav_attribute_type definition

-- Drop table

-- DROP TABLE public.movie_eav_attribute_type;

CREATE TABLE public.movie_eav_attribute_type (
                                                 id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
                                                 "name" varchar(255) NOT NULL,
                                                 CONSTRAINT movie_eav_attribute_type_pk PRIMARY KEY (id)
);


-- public.seat_type definition

-- Drop table

-- DROP TABLE public.seat_type;

CREATE TABLE public.seat_type (
                                  id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
                                  "name" varchar(255) NOT NULL,
                                  CONSTRAINT seat_type_pk PRIMARY KEY (id)
);


-- public.movie_eav_attribute definition

-- Drop table

-- DROP TABLE public.movie_eav_attribute;

CREATE TABLE public.movie_eav_attribute (
                                            id int2 NOT NULL GENERATED ALWAYS AS IDENTITY,
                                            attribute_type_id int2 NOT NULL,
                                            "name" varchar(255) NOT NULL,
                                            CONSTRAINT movie_eav_attribute_pk PRIMARY KEY (id),
                                            CONSTRAINT movie_eav_attribute_fk FOREIGN KEY (attribute_type_id) REFERENCES movie_eav_attribute_type(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX movie_eav_attribute_attribute_type_id_idx ON public.movie_eav_attribute USING btree (attribute_type_id);


-- public.movie_eav_value definition

-- Drop table

-- DROP TABLE public.movie_eav_value;

CREATE TABLE public.movie_eav_value (
                                        id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
                                        movie_id int4 NOT NULL,
                                        attribute_id int2 NOT NULL,
                                        integer_value int4 NULL,
                                        text_value text NULL,
                                        short_text_value varchar(255) NULL,
                                        boolean_value bool NULL,
                                        decimal_value float4 NULL,
                                        datetime_value timestamp NULL,
                                        CONSTRAINT movie_eav_value_pk PRIMARY KEY (id),
                                        CONSTRAINT movie_eav_value_fk FOREIGN KEY (movie_id) REFERENCES movie(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
                                        CONSTRAINT movie_eav_value_fk_1 FOREIGN KEY (attribute_id) REFERENCES movie_eav_attribute(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX movie_eav_value_attribute_id_idx ON public.movie_eav_value USING btree (attribute_id);
CREATE INDEX movie_eav_value_boolean_value_true_idx ON public.movie_eav_value USING btree (boolean_value) WHERE (boolean_value = true);
CREATE INDEX movie_eav_value_movie_id_idx ON public.movie_eav_value USING btree (movie_id);


-- public.seats definition

-- Drop table

-- DROP TABLE public.seats;

CREATE TABLE public.seats (
                              id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
                              hall_id int2 NOT NULL,
                              seat_type_id int2 NOT NULL,
                              quantity int2 NOT NULL,
                              price numeric(10,2) NULL,
                              CONSTRAINT seats_pk PRIMARY KEY (id),
                              CONSTRAINT seats_hall_fk FOREIGN KEY (hall_id) REFERENCES hall(id),
                              CONSTRAINT seats_type_fk FOREIGN KEY (seat_type_id) REFERENCES seat_type(id)
);
CREATE INDEX seats_hall_id_idx ON public.seats USING btree (hall_id);
CREATE INDEX seats_seat_type_id_idx ON public.seats USING btree (seat_type_id);


-- public."session" definition

-- Drop table

-- DROP TABLE public."session";

CREATE TABLE public."session" (
                                  id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
                                  hall_id int2 NOT NULL,
                                  movie_id int4 NOT NULL,
                                  datetime timestamp NOT NULL,
                                  duration interval NULL,
                                  CONSTRAINT session_pk PRIMARY KEY (id),
                                  CONSTRAINT session_fk FOREIGN KEY (hall_id) REFERENCES hall(id) ON UPDATE RESTRICT ON DELETE RESTRICT,
                                  CONSTRAINT session_movie_fk FOREIGN KEY (movie_id) REFERENCES movie(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX session_hall_id_idx ON public.session USING btree (hall_id);
CREATE INDEX session_movie_id_idx ON public.session USING btree (movie_id);


-- public.place definition

-- Drop table

-- DROP TABLE public.place;

CREATE TABLE public.place (
                              id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
                              session_id int4 NOT NULL,
                              seats_id int4 NOT NULL,
                              CONSTRAINT ticket_price_pk PRIMARY KEY (id),
                              CONSTRAINT ticket_price_fk FOREIGN KEY (session_id) REFERENCES session(id),
                              CONSTRAINT ticket_price_fk_1 FOREIGN KEY (seats_id) REFERENCES seats(id)
);
CREATE INDEX ticket_price_seats_id_idx ON public.place USING btree (seats_id);
CREATE INDEX ticket_price_session_id_idx ON public.place USING btree (session_id);


-- public.ticket definition

-- Drop table

-- DROP TABLE public.ticket;

CREATE TABLE public.ticket (
                               id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
                               client_id int4 NOT NULL,
                               paid numeric(10,2) NOT NULL,
                               place_id int4 NOT NULL,
                               seat_number int2 NOT NULL,
                               CONSTRAINT ticket_pk PRIMARY KEY (id),
                               CONSTRAINT ticket_fk FOREIGN KEY (place_id) REFERENCES place(id),
                               CONSTRAINT ticket_fk_1 FOREIGN KEY (client_id) REFERENCES client(id) ON UPDATE RESTRICT ON DELETE RESTRICT
);
CREATE INDEX ticket_client_id_idx ON public.ticket USING btree (client_id);
CREATE INDEX ticket_place_id_idx ON public.ticket USING btree (place_id);
CREATE INDEX ticket_seat_number_idx ON public.ticket USING btree (seat_number);

-- public.marketing_data source

CREATE OR REPLACE VIEW public.marketing_data
AS SELECT m.name AS movie,
          meat.name AS type,
          mea.name AS attribute,
          CASE
              WHEN mea.attribute_type_id = 1 THEN mev.integer_value::text
              WHEN mea.attribute_type_id = 2 THEN mev.text_value
              WHEN mea.attribute_type_id = 3 THEN mev.datetime_value::text
              WHEN mea.attribute_type_id = 4 THEN mev.short_text_value::text
              WHEN mea.attribute_type_id = 5 THEN mev.boolean_value::text
              WHEN mea.attribute_type_id = 6 THEN mev.decimal_value::text
              ELSE NULL::text
              END AS value
   FROM movie m
            JOIN movie_eav_value mev ON mev.movie_id = m.id
            JOIN movie_eav_attribute mea ON mea.id = mev.attribute_id
            JOIN movie_eav_attribute_type meat ON meat.id = mea.attribute_type_id;


-- public.service_task source

CREATE OR REPLACE VIEW public.service_task
AS SELECT max(m.name::text) AS movie,
          string_agg(
                  CASE
                      WHEN mev.datetime_value = CURRENT_DATE THEN mea.name
                      ELSE NULL::character varying
                      END::text, ', '::text) AS today,
          string_agg(
                  CASE
                      WHEN mev.datetime_value = (CURRENT_DATE + '20 days'::interval) THEN mea.name
                      ELSE NULL::character varying
                      END::text, ', '::text) AS after_20_days
   FROM movie m
            JOIN movie_eav_value mev ON mev.movie_id = m.id
            JOIN movie_eav_attribute mea ON mea.id = mev.attribute_id
   WHERE mea.attribute_type_id = 3
   GROUP BY m.id;

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

CREATE OR REPLACE FUNCTION public.movies_overlay_check()
    RETURNS trigger
    LANGUAGE plpgsql
AS $function$
DECLARE
    found integer;
BEGIN
    IF NEW.hall_id IS null or NEW.datetime IS null  THEN
        RETURN NEW;
    END IF;

    found := array_length(array(select s.id from "session" s
                                where duration is not null
                                  and hall_id = NEW.hall_id
                                  and NEW.datetime between datetime and (s.datetime + s.duration)), 1);

    IF found > 0 THEN
        RAISE EXCEPTION 'The date and time of this movie cannot overlap another movie in same hall';
    END IF;

    RETURN NEW;
END;
$function$
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

CREATE OR REPLACE PROCEDURE public.seed_test_data(size integer)
    LANGUAGE plpgsql
AS $procedure$
DECLARE
    movies_qty integer := size / 10;
    movie_id integer;
    movies_id_list integer[];
BEGIN

    for i in 1..movies_qty
        loop
            perform fake_movie();
        end loop;
    movies_id_list := array(select id from movies);



END;
$procedure$
;

CREATE TRIGGER trigger_movies_overlay_check
    BEFORE INSERT OR UPDATE
    ON public."session" FOR EACH ROW
EXECUTE PROCEDURE movies_overlay_check();