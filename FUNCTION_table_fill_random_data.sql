CREATE OR REPLACE FUNCTION public.table_fill_random_data(t_name text, row_count integer)
 RETURNS text[]
 LANGUAGE plpgsql
AS $function$
declare
	c int;
	t_fields text[] := array[]::text[];
	t_types record;
	t_values text[] := array[]::text[];

begin
	--	получаем массив названий столбцов;
	select array(select column_name::text from information_schema.columns
		where table_name = t_name and column_default is null) into t_fields;
	     
	
	for c in 1..row_count
	loop
		 --получаем массив типов столбцов
		
		for t_types in
			select data_type::text from information_schema.columns
		      	where table_name = t_name and column_default is null
		loop
			if t_types.data_type = 'character varying' then 
--				a = 20;
				t_values = array_append(t_values, random_string(99)); 
			elseif t_types.data_type = 'text' then 
				t_values = array_append(t_values,  random_string(1000)); 
			elseif t_types.data_type = 'smallint' or t_types.data_type = 'integer' or t_types.data_type = 'bigint' then 
				t_values = array_append(t_values, random_integer(3));
			elseif t_types.data_type = 'timestamp without time zone' or t_types.data_type = 'date' then 
				t_values = array_append(t_values,  random_date(7, 3)::text); 
			else 
				t_values = array_append(t_values, random_string(99));
			end if;
		end loop;
		

		raise notice 'insert into public.%(%) 
						values(''%'')',  t_name, array_to_string(t_fields,','), array_to_string( t_values, ''',''');
		
		execute format('insert into public.%I(' || array_to_string(t_fields,',') || ') 
						values(''' || array_to_string( t_values, ''' , ''') ||  ''')',  t_name);
	
		t_values = ( select t_values[1:array_upper(t_values, 1) - array_length(t_values, 1)] );
		
	end loop;	
		
	
	return t_values;
end;
$function$
;

