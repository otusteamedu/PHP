CREATE OR REPLACE FUNCTION public.random_date(year_start integer, year_finish integer, OUT res text)
 RETURNS text
 LANGUAGE plpgsql
AS $function$
declare
	year_range int := round(random() * (year_start + year_finish) * 365);
	year_to_start timestamp = now() - (year_start || ' year')::interval;
begin 
	select year_to_start + (year_range || ' day')::interval into res; 
end;
$function$
;

