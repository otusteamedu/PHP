Create or replace function random_string(length integer) returns text as
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


insert into movie ("name") select random_string(15) from generate_series(1, 10);
insert into attribute_type ("name") select random_string(15) from generate_series(1, 30);
insert into "attribute" (type_id, "name") select floor(random() * 10 + 1)::int, random_string(20) from generate_series(1, 1000);
insert into movie_attribute_value (movie_id, text_value, attribute_id) select floor(random() * 10 + 1)::int, random_string(20), floor(random() * 10 + 1)::int from generate_series(1, 10000);