-- functions
--
--

-- TODO: constants

CREATE OR REPLACE FUNCTION get_big_number_objects() RETURNS INTEGER AS $$
BEGIN RETURN 10000; END;
-- BEGIN RETURN 1000000; END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_films() RETURNS INTEGER AS $$
BEGIN RETURN get_big_number_objects(); END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_halls() RETURNS INTEGER AS $$
BEGIN RETURN 30; END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_places() RETURNS INTEGER AS $$
BEGIN RETURN 200; END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_events() RETURNS INTEGER AS $$
BEGIN RETURN get_big_number_objects(); END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_users() RETURNS INTEGER AS $$
BEGIN RETURN 1000; END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_orderStatuses() RETURNS INTEGER AS $$
BEGIN RETURN 3; END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_orders() RETURNS INTEGER AS $$
BEGIN RETURN get_big_number_objects(); END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_filmAttributeTypes() RETURNS INTEGER AS $$
BEGIN RETURN 5; END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_filmAttributes() RETURNS INTEGER AS $$
BEGIN RETURN 10; END;
$$ LANGUAGE 'plpgsql' STRICT;

CREATE OR REPLACE FUNCTION get_number_filmAttributeValues() RETURNS INTEGER AS $$
BEGIN RETURN get_big_number_objects(); END;
$$ LANGUAGE 'plpgsql' STRICT;

--
--

CREATE OR REPLACE FUNCTION random_string(length integer)
 RETURNS text
 LANGUAGE plpgsql
AS $function$
declare
chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
end if;
for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
end loop;
return result;
end;
$function$
;

--
--

CREATE OR REPLACE FUNCTION get_random_number(INTEGER, INTEGER) RETURNS INTEGER AS $$
DECLARE
    start_int ALIAS FOR $1;
    end_int ALIAS FOR $2;
BEGIN
    RETURN trunc(random() * (end_int-start_int) + start_int);
END;
$$ LANGUAGE 'plpgsql' STRICT;

--
--

create or replace function get_event_id(e_id integer)
    returns integer as
$$
select
    case
        when exists (select id from events where id = $1) then $1
        else 1
        end ev_id
limit 1;
$$
    language 'sql' volatile;

----------------------------------------------------------------------------------------
----------------------------------------- insert fake data------------------------------
--
--
--
insert into "films" ("id", "title", "duration_in_minutes", "comment")
select
    gs.id,
    concat('movie ', gs.id),
    get_random_number(70, 110),
    random_string(50)
from generate_series(1, get_number_films()) as gs(id);

--
--

insert into "halls" ("id", "title")
select
    gs.id,
    concat('hall ', gs.id)
from generate_series(1, get_number_halls()) as gs(id);

-- places
DO
$do$
    BEGIN
        FOR hallN IN 1..get_number_halls() LOOP
                insert into places ("number", hall_id)
                select
                    gs.id,
                    hallN
                from generate_series(1, get_number_places()) as gs(id);
            END LOOP;
    END
$do$;

--events
insert into "events" ("id", hall_id, film_id, datetime, price)
select
    gs.id,
    get_random_number(1, get_number_halls()),
    get_random_number(1, get_number_films()),
    concat(get_random_number(2010, 2021), '-', get_random_number(10, 12), '-', get_random_number(10, 28), ' ', get_random_number(10, 24), ':', get_random_number(10, 60), ':', get_random_number(10, 60))::timestamp,
    get_random_number(200, 300)
from generate_series(1, get_number_events()) as gs(id)
ON CONFLICT do nothing;

--users
insert into "users" ("id", "username", "password", "email", "created_on", "last_login")
select
    gs.id,
    concat('username', gs.id),
    'password',
    concat('email', gs.id, '@email.com') ,
    '2020-10-25',
    '2020-11-29'
from generate_series(1, get_number_users()) as gs(id);

--order_statuses
INSERT INTO order_statuses (id, title) VALUES (1, 'booked');
INSERT INTO order_statuses (id, title) VALUES (2, 'paid');
INSERT INTO order_statuses (id, title) VALUES (3, 'canceled');

-- orders
create or replace function insert_order()
    returns void as
$$
INSERT INTO orders (event_id, place_id, order_status_id, user_id, datetime)
values (
           get_event_id(get_random_number(1, get_number_events())),
           get_random_number(1, get_number_places()),
           get_random_number(1, get_number_orderStatuses()),
           get_random_number(1, get_number_users()),
           '2020-10-25')
ON CONFLICT do nothing;
$$
    language 'sql' volatile;

select insert_order() from generate_series(1, get_number_orders());

-- filmAttributeTypes
--
-- insert into "filmAttributeTypes" ("id", "title", "comment")
-- select
--     gs.id,
--     concat('filmAttributeType ', gs.id),
--     random_string(50)
-- from generate_series(1, get_number_filmAttributeTypes()) as gs(id);
INSERT INTO public."filmAttributeTypes" (id, title, comment) VALUES (1, 'boolean type', '');
INSERT INTO public."filmAttributeTypes" (id, title, comment) VALUES (2, 'bigint type', '');
INSERT INTO public."filmAttributeTypes" (id, title, comment) VALUES (3, 'double precision type', '');
INSERT INTO public."filmAttributeTypes" (id, title, comment) VALUES (4, 'timestamp type', '');
INSERT INTO public."filmAttributeTypes" (id, title, comment) VALUES (5, 'text type', '');
-- last id must be === get_number_filmAttributeTypes()

-- filmAttributes
--
-- insert into "filmAttributes" ("id", "title", "type_id")
-- select
--     gs.id,
--     concat('filmAttribute ', gs.id),
--     get_random_number(1, get_number_filmAttributeTypes())
-- from generate_series(1, get_number_filmAttributes()) as gs(id);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (1, 'boolean attr 1', 1);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (2, 'boolean attr 2', 1);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (3, 'bigint attr 1', 2);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (4, 'bigint attr 2', 2);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (5, 'double precision attr 1', 3);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (6, 'double precision attr 2', 3);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (7, 'timestamp attr 1', 4);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (8, 'timestamp attr 2', 4);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (9, 'text attr 1', 5);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (10, 'text attr 2', 5);

-- filmAttributeValues
--
-- insert into "filmAttributeValues" (
--     id, film_id, attribute_id, val_bool, val_bigint, val_double, val_timestamp, val_text, comment
-- )
-- select
--     gs.id,
--     get_random_number(1, get_number_films()),
--     get_random_number(1, get_number_filmAttributes()),
-- --     get_random_number(1, get_number_filmAttributeTypes()),
--     random_string(50)
-- from generate_series(1, get_number_filmAttributeValues()) as gs(id);
DO
$do$

    declare
        number integer := 0;
    BEGIN
        FOR favN IN 1..get_number_filmAttributeValues() LOOP
            number = get_random_number(1, get_number_filmAttributeTypes());
                IF number = 1 THEN
                    INSERT INTO public."filmAttributeValues" (
                        id, film_id, attribute_id, val_bool, comment
                    )
                    VALUES (favN, get_random_number(1, get_number_films()), get_random_number(1, 2), (round(random())::int)::boolean, random_string(50));
                ELSIF number = 2 THEN
                    INSERT INTO public."filmAttributeValues" (
                        id, film_id, attribute_id, val_bigint, comment
                    )
                    VALUES (favN, get_random_number(1, get_number_films()), get_random_number(3, 4), get_random_number(100, 200), random_string(50));
                ELSIF number = 3 THEN
                    INSERT INTO public."filmAttributeValues" (
                        id, film_id, attribute_id, val_double, comment
                    )
                    VALUES (favN, get_random_number(1, get_number_films()), get_random_number(5, 6), 2.34, random_string(50));
                ELSIF number = 4 THEN
                    INSERT INTO public."filmAttributeValues" (
                        id, film_id, attribute_id, val_timestamp, comment
                    )
                    VALUES (favN, get_random_number(1, get_number_films()), get_random_number(7, 8), '2021-02-02', random_string(50));
                ELSIF number = 5 THEN
                    INSERT INTO public."filmAttributeValues" (
                        id, film_id, attribute_id, val_text, comment
                    )
                    VALUES (favN, get_random_number(1, get_number_films()), get_random_number(9, 10), random_string(50), random_string(50));
                END IF;
        END LOOP;
    END
$do$;