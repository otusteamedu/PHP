/* From SO https://stackoverflow.com/questions/3970795/how-do-you-create-a-random-string-thats-suitable-for-a-session-id-in-postgresql */
CREATE OR REPLACE FUNCTION random_string(length integer default 10) RETURNS text AS
$$
DECLARE
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
BEGIN
  IF length < 0 THEN
    RAISE EXCEPTION 'Given length cannot be less than 0';
  END if;
  FOR i IN 1..length LOOP
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  END LOOP;
  RETURN result;
END;
$$ language plpgsql;

/* Self made */
CREATE OR REPLACE FUNCTION random_timestamp(fromdate timestamp default '2019-01-01 00:00:00', todate timestamp default '2020-12-31 23:59:59') RETURNS timestamp AS
$$
BEGIN
  RETURN (random() * (todate - fromdate)) + fromdate;
END;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION random_boolean(factor numeric default 0.5) RETURNS boolean AS
$$
BEGIN
  RETURN (random() >= factor);
END;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION random_numeric(low numeric default 0, high numeric default 100) RETURNS numeric AS
$$
BEGIN
    RETURN round((random() * (high - low)) + low);
END;
$$ language plpgsql;