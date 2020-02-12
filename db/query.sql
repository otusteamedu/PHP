---- скрипты заполнения таблиц
create or replace function random_string(length int) returns text as
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i int := 0;
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

create or replace function random_id(max int) returns int as
$$
begin
    if max < 1 then
        raise exception 'Given max cannot be less than 1';
    end if;

    return (1 + random() * (max - 1))::int;
end;
$$ language plpgsql;

create or replace function random_date_time() returns timestamp as
$$
begin
    return (now() - (random() * (interval '30 days')));
end;
$$ language plpgsql;

insert into booking_statuses(status) values ('free'), ('booked'), ('sold'), ('unavailable');
insert into cinemas(title) values (random_string(16));
insert into halls(title, cinema_id) select random_string(16), 1 from generate_series(1, 5);
insert into movies(title) select random_string(16) from generate_series(1, 100);
insert into showtimes(date_time, format, movie_id, hall_id) select random_date_time(), case when random() > 0.5 then '2D' else '3D' end, random_id(100), random_id(5) from generate_series(1, 10000);
insert into bookings(seat, price, status_id, showtime_id) select random_id(100), random()*10::money, random_id(4), random_id(10000) from generate_series(1, 10000) on conflict do nothing;
insert into showtimes(date_time, format, movie_id, hall_id) select random_date_time(), case when random() > 0.5 then '2D' else '3D' end, random_id(100), random_id(5) from generate_series(1, 10000000);
insert into bookings(seat, price, status_id, showtime_id) select random_id(100), random()*10::money, random_id(4), random_id(10010000) from generate_series(1, 10000000) on conflict do nothing;
