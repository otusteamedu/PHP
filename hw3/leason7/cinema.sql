-- зал

create table if not exists hall (
id serial not null,
name varchar(50) not null,
primary key (id)
);

-- фильм
create table if not exists film (
id serial not null,
name varchar(100) not null,
primary key (id)
);

-- сеанс
create table if not exists seanse (
id serial not null,
hall_id int not null,
film_id int not null,
start_show time not null,
primary key (id)
);

-- билет
create table if not exists ticket (
id serial not null,
seanse_id int not null,
row int not null,
col int not null,
coast numeric(6,2),
primary key (id)
);
