create or replace function random_string(length int) returns text as
$$
declare
    chars  text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text   := '';
    i      int    := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length
        loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
    return result;
end;
$$ language plpgsql;

create or replace function random_int(max int) returns int as
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
    return (now()+(random() * (interval '20 days')) - (random() * (interval '30 days')));
end;
$$ language plpgsql;


truncate table public.booking restart identity cascade;
truncate table public.schedule_place_price restart identity cascade;
truncate table public.schedule restart identity cascade;
truncate table public.movie_attr_value restart identity cascade;
truncate table public.movie_attr restart identity cascade;
truncate table public.movie_attr_type restart identity cascade;
truncate table public.movie restart identity cascade;
truncate table public.places restart identity cascade;
truncate table public.hall restart identity cascade;
truncate table public.cinema restart identity cascade;
truncate table public.customer restart identity cascade;
truncate table public.place_category restart identity cascade;


--place category
insert into public.place_category(name)
select random_string(5)
from generate_series(1, 4);
-- customer
insert into public.customer(name, email)
select random_string(5), random_string(35)
from generate_series(1, 150000);
--cinemas
insert into public.cinema(name, address)
select random_string(10), random_string(25)
from generate_series(1, 10);
--hall
insert into public.hall(name, id_cinema)
select random_string(10), random_int(10)
from generate_series(1, 100)
on conflict do nothing;
--place
insert into public.places (id_place_category, id_hall, row_number, place_number)
select random_int(4), random_int(100), random_int(30), random_int(20)
from generate_series(1, 60000)
on conflict do nothing;
-- movies
insert into public.movie(title, description, duration)
select random_string(10), random_string(120), random_int(300)
from generate_series(1, 200000)
on conflict do nothing;
--movie attr types
insert into public.movie_attr_type ("name", "comment")
values ('text', 'текстовое поле'),
       ('int', 'целое число'),
       ('double', 'число с плавающей точкой'),
       ('date', 'дата'),
       ('boolean', 'булевое');
--movie attrs
insert into public.movie_attr (id_type, "name")
values (1, 'Короткое описание'),
       (3, 'Рейтинг IMDB'),
       (2, 'Сборы в мире'),
       (4, 'Дата премьеры в мире'),
       (4, 'Дата премьеры в Украине'),
       (5, 'Номинирован на оскар'),
       (5, 'Участник Каннского кинофестиваля'),
       (1, 'Жанр'),
       (4, 'Дата начала продажи биллетов'),
       (4, 'Дата запуска рекламы'),
       (4, 'Дата начала проката');
--movie attr values
insert into public.movie_attr_value(id_attr, id_movie, value_text, value_int, value_date)
select random_int(11), random_int(20000), random_string(255), random_int(1000), random_date_time()
from generate_series(1, 220000)
on conflict do nothing;
--schedule
insert into public.schedule(id_hall, id_movie, date_start, date_end)
select random_int(100), random_int(20000), random_date_time(), random_date_time()
from generate_series(1, 2000000)
on conflict do nothing;
--schedule_place_price
insert into public.schedule_place_price(id_schedule, id_place_category, price)
select n, 1, random_int(1000)
from generate_series(1, 2000000) as x(n)
on conflict do nothing;

insert into public.schedule_place_price(id_schedule, id_place_category, price)
select n, 2, random_int(1000)
from generate_series(1, 2000000) as x(n)
on conflict do nothing;

insert into public.schedule_place_price(id_schedule, id_place_category, price)
select n, 3, random_int(1000)
from generate_series(1, 2000000) as x(n)
on conflict do nothing;

insert into public.schedule_place_price(id_schedule, id_place_category, price)
select n, 4, random_int(1000)
from generate_series(1, 2000000) as x(n)
on conflict do nothing;
--booking
insert into public.booking(id_schedule, id_customer, created_at, updated_at, id_place)
select random_int(2000000),
       random_int(150000),
       random_date_time(),
       random_date_time(),
       (select id from public.places order by random() limit 1)
from generate_series(0, 1000000)
on conflict do nothing;