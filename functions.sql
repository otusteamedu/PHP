CREATE OR REPLACE FUNCTION public.random_string(length integer)
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

CREATE OR REPLACE FUNCTION public.truncate_tables()
 RETURNS boolean
 LANGUAGE plpgsql
AS $function$
DECLARE
    statements CURSOR FOR
        SELECT tablename FROM pg_tables
        WHERE schemaname = 'public';
BEGIN
    FOR stmt IN statements LOOP
            EXECUTE 'TRUNCATE TABLE ' || quote_ident(stmt.tablename) || ' RESTART IDENTITY CASCADE;';
    END LOOP;
    RETURN TRUE;
END;
$function$
;

CREATE OR REPLACE FUNCTION public.fill_halls_table(rows_count integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
declare
    total_rows_count integer := 0;
begin
    INSERT INTO halls (name, description, capacity)
        SELECT
            random_string((1+ random()*10) :: integer),
            random_string((1+ random()*100) :: integer),
            (1+ random()*100) :: integer
        FROM pg_catalog.generate_series(1,rows_count);
    SELECT count(*) into total_rows_count FROM halls;
    return total_rows_count;
end;
$function$
;

CREATE OR REPLACE FUNCTION public.fill_films_table(rows_count integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
declare
    total_rows_count integer := 0;
begin
    INSERT INTO films (name, description, age_restrict, duration)
        SELECT
            random_string((1+ random()*10) :: integer),
            random_string((1+ random()*100) :: integer),
            (1+ random()*16) :: integer,
            justify_hours('1 hour' + random() * (interval '2 hours')) :: time
        FROM pg_catalog.generate_series(1,rows_count);
    SELECT count(*) into total_rows_count FROM films;
    return total_rows_count;
end;
$function$
;

CREATE OR REPLACE FUNCTION public.fill_seances_table(rows_count integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
declare
    total_rows_count integer := 0;
begin
    INSERT INTO seances (hall_id, film_id, show_at, price)
        SELECT
                1 + random()* (rows_count - 1) :: integer,
                1 + random()* (rows_count - 1) :: integer,
                NOW() + (random() * (NOW()+'90 days' - NOW())),
                1+ random()*20000 :: integer
        FROM pg_catalog.generate_series(1,rows_count);
    SELECT count(*) into total_rows_count FROM seances;
    return total_rows_count;
end;
$function$
;

CREATE OR REPLACE FUNCTION public.fill_tickets_table(rows_count integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
declare
    seance_id_val integer := 0;
    row_val integer := 0;
    place_val integer := 0;
    total_rows_count integer := 0;
begin
    for i in 1..rows_count loop
        seance_id_val := 1 + random()* (rows_count - 1) :: integer;
        row_val := 1 + random()*10 :: integer;
    SELECT place INTO place_val FROM tickets WHERE seance_id = seance_id_val AND row = row_val ORDER BY id DESC LIMIT 1;

    if place_val IS NOT NULL then
            place_val := place_val+1;
    end if;

        if place_val IS NULL then
            place_val := 1;
    end if;
    INSERT INTO tickets (seance_id, row, place, price)
        VALUES (seance_id_val,
                row_val,
                place_val,
                1 + random()*20000 :: integer);
    end loop;

    SELECT count(*) into total_rows_count FROM tickets;
    RETURN total_rows_count;
end;
$function$
;

CREATE OR REPLACE FUNCTION public.fill_film_attribute_types_table(rows_count integer)
    RETURNS integer
    LANGUAGE plpgsql
AS $function$
declare
    total_rows_count integer := 0;
    attribute_name text := '';
BEGIN

    for i in 1..rows_count LOOP
            attribute_name := random_string((1+ random()*10) :: integer);

            BEGIN
                INSERT INTO film_attribute_types (id, name, description)
                VALUES(
                          i,
                          attribute_name,
                          random_string((1+ random()*100) :: integer)
                      );
            EXCEPTION WHEN unique_violation THEN
                INSERT INTO film_attribute_types (id, name, description)
                VALUES(
                          i,
                          CONCAT(attribute_name, i, random_string((1+ random()*10) :: integer)),
                          random_string((1+ random()*100) :: integer)
                      );
            END;
        end loop;

    SELECT count(*) into total_rows_count FROM film_attribute_types;
    return total_rows_count;
END;
$function$
;


CREATE OR REPLACE FUNCTION public.fill_film_attributes_table(rows_count integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
declare
total_rows_count integer := 0;
begin
    INSERT INTO film_attributes (film_attribute_type_id, name, description)
        SELECT
            1 + random()* (rows_count - 1) :: integer,
            random_string((1+ random()*10) :: integer),
            random_string((1+ random()*100) :: integer)
        FROM pg_catalog.generate_series(1,rows_count);

    SELECT count(*) into total_rows_count FROM film_attributes;
    return total_rows_count;
end;
$function$
;

CREATE OR REPLACE FUNCTION public.fill_film_attribute_values_table(rows_count integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
declare
  film_attribute_id_val integer := 0;
  film_id_val integer := 0;
  text_val text := '';
  bool_val bool := FALSE;
  date_val date := now();
  integer_val integer := 0;
  float_val float := 0.00;
  total_rows_count integer := 0;
BEGIN
    for i in 1..rows_count loop
        film_attribute_id_val := 1 + random() * (rows_count - 1) :: integer;
        film_id_val := 1 + random() * (rows_count - 1) :: integer;

        IF i % 6 = 0 THEN
            text_val := random_string((1+ random()*100) :: integer);
            bool_val := NULL;
            date_val := NULL;
            integer_val := NULL;
            float_val := NULL;
        ELSEIF  i % 5 = 0  THEN
            text_val := NULL;
            bool_val := (random() < 0.5) :: bool;
            date_val := NULL;
            integer_val := NULL;
            float_val := NULL;
        ELSEIF  i % 4 = 0  THEN
            text_val := NULL;
            bool_val := NULL;
            date_val := NOW() + (random() * (NOW()+'90 days' - NOW()));
            integer_val := NULL;
            float_val := NULL;
        ELSEIF  i % 3 = 0  THEN
            text_val := NULL;
            bool_val := NULL;
            date_val := NULL;
            integer_val := NULL;
            float_val := (1+ random()*100000) :: float;
        ELSE
            text_val := NULL;
            bool_val := NULL;
            date_val := NULL;
            integer_val := (1+ random()*100000) :: integer;
            float_val := NULL;
        END IF;

        BEGIN

            INSERT INTO film_attribute_values (film_attribute_id, film_id, text_value, boolean_value, date_value,integer_value,float_value)
                VALUES (film_attribute_id_val,film_id_val,text_val,bool_val,date_val,integer_val,float_val);

            EXCEPTION WHEN unique_violation THEN
                INSERT INTO film_attribute_values (film_attribute_id, film_id, text_value, boolean_value, date_value,integer_value,float_value)
                    VALUES (film_attribute_id_val,
                    (1 + (SELECT MAX(film_id) FROM film_attribute_values
                    WHERE film_attribute_id = film_attribute_id_val)),
                    text_val,bool_val,date_val,integer_val,float_val);

            END;
    END loop;

    SELECT count(*) into total_rows_count FROM film_attribute_values;
    RETURN total_rows_count;
end;
$function$
;

CREATE OR REPLACE FUNCTION public.fill_tables(rows_count integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$
begin
    PERFORM truncate_tables(),
        fill_halls_table(rows_count),
        fill_films_table(rows_count),
        fill_seances_table(rows_count),
        fill_tickets_table(rows_count),
        fill_film_attribute_types_table(rows_count),
        fill_film_attributes_table(rows_count),
        fill_film_attribute_values_table(rows_count);
    RETURN rows_count;
end;
$function$
;