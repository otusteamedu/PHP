CREATE OR replace FUNCTION random_string(length integer) RETURNS text AS
$$
DECLARE
	chars text[] :=
	'{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,R,S,T,U,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,r,s,t,u,w,x,y,z}';
	result text := '';
	i integer := 0;
BEGIN
	IF length < 0 THEN
		raise EXCEPTION 'Given length cannot be less than 0';
	END IF;

	FOR i IN 1..length LOOP
		RESULT := RESULT || chars[1 + random()*(array_length(chars, 1) - 1)];
	END LOOP;
	
	RETURN result;
END;
$$ LANGUAGE plpgsql;



-- random int
--
CREATE OR replace FUNCTION random_int(min integer, max integer) RETURNS integer AS
$$
BEGIN
	RETURN floor(random() * (max - min + 1) + min)::int;
END;
$$ LANGUAGE plpgsql;


-- random dates
-- year offset
CREATE OR replace FUNCTION random_date_year(yearOffset integer) RETURNS DATE AS
$$
DECLARE

	yearText text := yearOffset::text || ' years';

BEGIN

	RETURN date(
		(current_date + yearText::INTERVAL) + 
		trunc(random() * 365) * '1 day'::INTERVAL +
		trunc(random() * (abs(yearOffset) - 1)) * '1 year'::INTERVAL
	);
	
END;
$$ LANGUAGE plpgsql;


-- month offset
CREATE OR replace FUNCTION random_date_month(monthOffset integer) RETURNS DATE AS
$$
DECLARE

	monthText text := monthOffset::text || ' month';

BEGIN

	RETURN date(
		(current_date + monthText::INTERVAL) + 
		trunc(random() * 30) * '1 day'::INTERVAL +
		trunc(random() * (abs(monthOffset) - 1)) * '1 month'::INTERVAL
	);
	
END;
$$ LANGUAGE plpgsql;

-- days offset
CREATE OR replace FUNCTION random_date_day(dayOffset integer) RETURNS DATE AS
$$
DECLARE

	daysText text := dayOffset::text || ' days';

BEGIN

	RETURN date(
		(current_date + daysText::INTERVAL) + 
		trunc(random() * 24) * '1 hour'::INTERVAL +
		trunc(random() * (abs(dayOffset) - 1)) * '1 day'::INTERVAL
	);
	
END;
$$ LANGUAGE plpgsql;


-- random date_time
CREATE OR replace FUNCTION random_datetime(startDate date, dayOffset integer) 
	RETURNS TIMESTAMP AS
$$
DECLARE

	daysText text := dayOffset::text || ' days';

BEGIN

	return (
		(startDate + daysText::INTERVAL) + 
		(random_int(0, 23)::text || ' hours')::interval +
		(random_int(0, 59)::text || ' minutes')::interval +
		(random_int(0, 59)::text || ' seconds')::interval
	)::timestamp;
	
END;
$$ LANGUAGE plpgsql;







