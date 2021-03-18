truncate "tUsers" cascade;

do
$$
declare
	maxRows integer := 1000;
	domains text[] := '{com,ru,io,by,de,it,bg}';
	domainsLen integer;
	i integer;
	
begin
	domainsLen = array_length(domains, 1);

	for i in 1..maxRows 
	loop
	
		insert into "tUsers" (email, "password", firstname, lastname, discount) values
			(
				random_string(random_int(4, 10)) || '@mail.' || domains[random_int(1, domainsLen)],
				random_string(random_int(10, 30)),
				random_string(random_int(4, 20)),
				random_string(random_int(10, 30)),
				random_int(0, 70)
			);
	
	end loop;
	
end;
$$ language plpgsql;
























