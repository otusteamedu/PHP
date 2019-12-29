-- таблица залов
create table public.hall (
	id smallserial primary key,
	name text not null,
	size int not null
);

-- таблица фильмов
create table public.film (
	id serial primary key,
	name text not null,
	year date not null
);

-- таблица сеансов
create table public.session (
	id serial primary key,
	film_id int not null references public.film (id),
	hall_id smallint not null references public.hall (id),
	start timestamp with time zone
);

-- таблица клиентов
create table public.client (
	id serial primary key,
	name text not null
);

-- таблица билетов
create table public.ticket (
	id bigserial primary key,
	session_id int not null references public.session (id),
	place int not null,
	price int not null
);

-- таблица клиентов и билетов
create table public.client_ticket (
	client_id int references client (id),
	ticket_id bigint references ticket (id),
	primary key (client_id, ticket_id)
);