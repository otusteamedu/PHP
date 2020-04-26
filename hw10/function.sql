CREATE OR REPLACE FUNCTION random_string() returns text AS
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    for i in 1..10 loop
            result := result || chars[1+random()*(array_length(chars, 1)-1)];
        end loop;
    return result;
end
$$ language plpgsql;

CREATE OR REPLACE FUNCTION gen_date(min date) RETURNS date AS $$
  SELECT CURRENT_DATE - (random() * (CURRENT_DATE - $1))::int;
$$ LANGUAGE sql STRICT VOLATILE;