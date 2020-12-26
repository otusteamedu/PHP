create table if not exists movies (
	id serial primary key,
	name char(255) not null,
	duration int,
	age_limit int not null,
	description text
);

-- поиск будет проходить в основном по названию фильма
create index movies_name_index on movies (name);

create table if not exists halls(
	id serial primary key,
	number char(8) not null unique,
	max_moviegoers int not null,
	floor int
);

-- поиск будет проходить в основном по номеру зала
create index halls_number_index on halls (number);

create table if not exists schedule (
	id serial primary key,
	movie_id integer references movies,
	hall_id integer references halls,
	start_time integer not null, --unix_timestamp буду юзать
	unique (hall_id, start_time) -- комбинация hall_id и start_time должна быть уникальной
);


create index schedule_index on schedule (movie_id, hall_id, start_time);

create table if not exists moviegoers (
	id serial primary key,
	phone integer,
	email char(180),
	hash_code char(250) unique not null
);

create index moviegoers_hash_code_index on moviegoers (hash_code);

create table if not exists tickets (
	id serial primary key,
	schedule_id integer not null references schedule,
	moviegoer_id integer not null references moviegoers,
	number integer  unique not null,
	status integer default 1, -- будут статусы типа 1 активный 2 использован 3 заблокирован и тд
	unique (moviegoer_id,schedule_id) -- комбинация moviegoer_id и schedule_id должна быть уникальной
);

create index tickets_number_index on tickets (schedule_id, moviegoer_id, number);






