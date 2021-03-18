truncate "tHalls" cascade;


do
$$
declare
-- "tHalls"
	minRows integer := 5;
	maxRows integer := 40;

	minSeats integer := 20;
	maxSeats integer := 40;

	minDescLen integer := 100;
	maxDescLen integer := 300;

	hallNames text[] := '{Cyan, Magenta, Yellow, Black}';
	n text;

	
begin
--	"tHalls"
	foreach n in array hallNames
		loop
	
			insert into "tHalls" ("name", number_rows, seats_in_row, description) values
			(
				n, 
				random_int(minRows, maxRows), 
				random_int(minSeats, maxSeats), 
				random_string(random_int(minDescLen, maxDescLen))
			);
	
	end loop;	
end;
$$ language plpgsql;
























