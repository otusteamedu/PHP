create or replace function random_string(length integer) returns text as
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

create or replace function random_int(min int, max int) returns int as
$$
begin
    if max < 1 then
        raise exception 'Given max cannot be less than 1';
    end if;
    if min < 1 then
        raise exception 'Given min cannot be less than 1';
    end if;
    if max < min then
        raise exception 'Given max cannot be less than min';
    end if;

    return (min + random() * (max - min))::int;
end;
$$ language plpgsql;

create or replace function random_date_time() returns timestamp as
$$
begin
    return (now()+(random() * (interval '20 days')) - (random() * (interval '30 days')));
end;
$$ language plpgsql;

create or replace function random_float(max int, min int) returns numeric(6, 2) as
$$
begin
    if max < 1 then
        raise exception 'Given max cannot be less than 1';
    end if;
    if min < 1 then
        raise exception 'Given min cannot be less than 1';
    end if;
    if max < min then
        raise exception 'Given max cannot be less than min';
    end if;
    return (min + random() * (max - min))::numeric(6,2);
end;
$$ language plpgsql;

--fill users
insert into users(name, email, created_on, password)
select random_string(10), random_string(35), random_date_time(), random_string(35)
from generate_series(1, 1000000);

--fill movies
insert into movies(title, duration)
select random_string(50), random_int(1,300)
from generate_series(1, 16000);

--fill halls
insert into halls(title)
select random_string(50)
from generate_series(1, 800)
on conflict do nothing;

--fill seats
insert into seats(number, hall_id)
select random_int(1,400), random_int(1,800)
from generate_series(1, 210000)
on conflict do nothing;

--fill sessions
insert into sessions(movie_id, hall_id, start_time, price)
select random_int(1,16000), random_int(1,700), random_date_time(), random_float(400,150)
from generate_series(1, 1000000)
on conflict do nothing;

--fill orders
insert into orders(session_id, seat_id, user_id, date_time)
select generator.session_id,generator.seat_id,generator.user_id,generator.date_time
from (
         select random_int(1,1000000) as session_id, random_int(1,210000) as seat_id, random_int(1,1000000) as user_id, random_date_time() as date_time
         from generate_series(1, 3000000)
     ) as generator
         inner join seats
                    on seats.id=generator.seat_id

on conflict do nothing;

--fill movieAttributeTypes
insert into movieAttributeTypes(name, description)
select random_string(50), random_string(100)
from generate_series(1, 500)
on conflict do nothing;

--fill movieAttributes
insert into movieAttributes(name, type_id)
select random_string(50), random_int(1,500)
from generate_series(1, 5000)
on conflict do nothing;

--fill movieAttributeValues
insert into movieAttributeValues(attribute_id, movie_id,value_text)
select random_int(1,1000), random_int(1,600),random_string(100)
from generate_series(1, 25000)
on conflict do nothing;

insert into movieAttributeValues(attribute_id, movie_id,value_date)
select random_int(1001,2000), random_int(1,600), random_date_time()
from generate_series(1, 25000)
on conflict do nothing;

insert into movieAttributeValues(attribute_id, movie_id,value_bool)
select random_int(2001,3000), random_int(1,600), random() < 0.5
from generate_series(1, 25000)
on conflict do nothing;

insert into movieAttributeValues(attribute_id, movie_id,value_int)
select random_int(3001,4000), random_int(1,600), random_int(1,10)
from generate_series(1, 25000)
on conflict do nothing;


insert into movieAttributeValues(attribute_id, movie_id,value_float)
select random_int(4001,5000), random_int(1,600), random_float(400,150)
from generate_series(1, 25000)
on conflict do nothing;