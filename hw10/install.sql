create table if not exists cinemas (
    id serial primary key,
    name varchar(100) not null,
    code varchar(100) not null,
    constraint cinema_unique unique (code)
);

create table if not exists halls (
    id serial primary key,
    name varchar(100) not null,
    code varchar(100) not null,
    cinema_id integer,
    constraint hall_unique unique (code, cinema_id),
    foreign key (cinema_id) references cinemas (id)
);

create table if not exists seats (
    id serial primary key,
    hall_id integer,
    row smallint,
    seat smallint,
    base_price numeric(18,2),
    constraint seat_unique unique (hall_id, row, seat),
    foreign key (hall_id) references halls (id)
);
-- create unique index seat_unique on seats (hall_id, row, seat);

create table if not exists movies (
    id serial primary key,
    name varchar(255) not null
);

create table if not exists sessions (
    id serial primary key,
    hall_id integer,
    movie_id integer,
    date timestamp,
    coefficient decimal(1,1),
    foreign key (hall_id) references halls (id),
    foreign key (movie_id) references movies (id)
);

create table if not exists clients (
    id serial primary key,
    name varchar(50) not null,
    last_name varchar(50) not null
);

create table if not exists orders (
    id serial primary key,
    client_id integer,
    total numeric(18,2),
    foreign key (client_id) references clients (id)
);

create table if not exists basket (
    id serial primary key,
    order_id integer,
    session_id integer,
    seat_id integer,
    price numeric(18,2),
    constraint basket_unique unique (session_id, seat_id),
    foreign key (order_id) references orders (id),
    foreign key (session_id) references sessions (id),
    foreign key (seat_id) references seats (id)
);

create table if not exists property_types (
    id serial primary key,
    name varchar(100) not null,
    code varchar(100) not null,
    comment varchar(255) default '',
    constraint property_type_unique unique (code)
);

create index idx_prop_type_code on property_types (code);

create table if not exists movie_properties (
    id serial primary key,
    name varchar(100) not null,
    type varchar(100) not null
);

create index idx_movie_prop_type on movie_properties (type);

create table if not exists movie_property_values (
    id serial primary key,
    movie integer,
    property integer,
    text_value text,
    date_value date,
    boolean_value boolean,
    integer_value integer,
    float_value numeric(8, 5),
    constraint movie_property_unique unique (movie, property),
    foreign key (movie) references movies (id),
    foreign key (property) references movie_properties (id)
);

create index idx_movie_prop_values on movie_property_values (movie, property);
create index idx_movie_prop_values_dates on movie_property_values (date_value);
create index idx_movie_prop_values_integer on movie_property_values (integer_value);
create index idx_movie_prop_values_float on movie_property_values (float_value);



create view tasks as
    select 
        movies.id as movie_id, 
        movies.name as movie_name, 
        today_tasks.task as today, 
        future_tasks.task as "in 20 days"
        from movies
        left join (
            select movie, mp.name as task from movie_property_values mpv
            left join movie_properties mp on mpv.property = mp.id
            where mp.type='service_dates' and date_value=current_date
        ) today_tasks on movies.id = today_tasks.movie
        left join (
            select movie, mp.name as task from movie_property_values mpv
            left join movie_properties mp on mpv.property = mp.id
            where mp.type='service_dates' and date_value=current_date + interval '20 days'
        ) future_tasks on movies.id = future_tasks.movie
    where today_tasks.task is not null or future_tasks.task is not null 
;

create view movie_props as
    select 
        m.id as movie_id,
        m.name as movie_name, 
        mp.name as property_name, 
        coalesce (
            mpv.boolean_value::text , 
            mpv.date_value::text , 
            mpv.text_value::text , 
            mpv.integer_value::text ,
            mpv.float_value::text
        ) as property_value 
        from movie_property_values mpv
    left join movies m on m.id = mpv.movie 
    left join movie_properties mp on mp.id = mpv.property 
    left join property_types pt on pt.code = mp.type
;



-- функция для заполнения мест в залах
create or replace function fill_seats(hall_code text, cinema_code text, rows_count integer, seats_count integer, price integer) 
returns boolean as $$

declare
    _hall_id integer := null; 
    row_number integer := 1; 
    seat_number integer := 1;

begin
    select halls.id into _hall_id from halls
        left join cinemas on halls.cinema_id = cinemas.id 
        where halls.code=hall_code and cinemas.code=cinema_code;

    if _hall_id is null then
        return false;
    end if;
    
    select max(row) + 1 into row_number from seats where hall_id = _hall_id;

    if row_number is null then
        row_number := 1;
    end if;

    rows_count := rows_count + row_number;

    <<row_loop>>
    while row_number < rows_count loop
        seat_number := 1;
        <<seat_loop>>
        while seat_number <= seats_count loop
            insert into seats values (default, _hall_id, row_number, seat_number, price);
            seat_number := seat_number + 1;
        end loop seat_loop;

        row_number := row_number + 1;
    end loop row_loop;

    return true;
end;
$$ language plpgsql;

-- случайная строка
create or replace function random_string(length integer) returns text as
$$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$$ language plpgsql;


-- случайная дата
create or replace function random_timestamp(period text) returns timestamp as
$$
begin
    return (now() - period::interval * random());
end;
$$ language plpgsql;


-- случайное целое число
create or replace function random_int(min_int int, max_int int) returns int as
$$
begin
    return (random()*(max_int-min_int)+min_int)::int;
end;
$$ language plpgsql;


-- случайное дробное число
create or replace function random_float(number_from numeric, number_to numeric, dec_number integer) returns numeric as
$$
begin
    return round((random() * (number_to - number_from) + number_from)::numeric, dec_number);
end;
$$ language plpgsql;


-- случайный элемент массива
create or replace function random_pick(p_items anyarray)
returns anyelement as
$$
declare
    res text := p_items[0]; 
begin
select (p_items)[floor(random() * array_length(p_items, 1) + 1)] into res;
return res::text;
end;
$$ language plpgsql;



-- кинотеатры
INSERT INTO cinemas VALUES 
    (DEFAULT, 'Первый кинотеатр', 'first'),
    (DEFAULT, 'Второй кинотеатр', 'second');


-- залы
INSERT INTO halls VALUES 
    (DEFAULT, 'Синий зал', 'blue', (SELECT id FROM cinemas WHERE code='first')),
    (DEFAULT, 'Синий зал', 'blue', (SELECT id FROM cinemas WHERE code='second')),
    (DEFAULT, 'Зеленый зал', 'green', (SELECT id FROM cinemas WHERE code='first'));


-- 100 мест
SELECT fill_seats('blue', 'first', 3, 10, 300);
SELECT fill_seats('blue', 'first', 3, 10, 500);
SELECT fill_seats('blue', 'first', 3, 10, 300);
SELECT fill_seats('green', 'first', 2, 5, 1000);


-- типы свойств
INSERT INTO property_types VALUES 
    (DEFAULT, 'Рецензии', 'reviews'),
    (DEFAULT, 'Премии', 'awards'),
    (DEFAULT, 'Важные даты', 'important_dates'),
    (DEFAULT, 'Служебные даты', 'service_dates'),
    (DEFAULT, 'Счетчики', 'counters'),
    (DEFAULT, 'Рейтинги', 'ratings');


-- свойства
INSERT INTO movie_properties VALUES 
    (DEFAULT, 'Оскар', 'awards'),
    (DEFAULT, 'Золотая пальмовая ветвь', 'awards'),
    (DEFAULT, 'Рецензия одного известного критика', 'reviews'),
    (DEFAULT, 'Рецензия неизвестного критика', 'reviews'),
    (DEFAULT, 'Премьера, мир', 'important_dates'),
    (DEFAULT, 'Премьера, РФ', 'important_dates'),
    (DEFAULT, 'Старт рекламы на TV', 'service_dates'),
    (DEFAULT, 'Старт продажи билетов', 'service_dates'),
    (DEFAULT, 'Сборы в мире', 'counters'),
    (DEFAULT, 'Сборы в РФ', 'counters'),
    (DEFAULT, 'Количество зрителей', 'counters'),
    (DEFAULT, 'Рейтинг Кинопоиск', 'ratings'),
    (DEFAULT, 'Рейтинг критиков', 'ratings');