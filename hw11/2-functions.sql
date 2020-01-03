\connect cinema

CREATE OR REPLACE FUNCTION random_string(length integer) returns text AS
$$
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
$$ language plpgsql;

CREATE OR REPLACE FUNCTION random_between(low INT ,high INT) 
   RETURNS INT AS
$$
BEGIN
   RETURN floor(random()* (high-low + 1) + low);
END;
$$ language 'plpgsql' STRICT;