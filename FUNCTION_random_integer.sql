CREATE OR REPLACE FUNCTION public.random_integer(length integer)
 RETURNS text
 LANGUAGE plpgsql
AS $function$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9}';
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

