create table if not exists public.seat_type (
	id serial,
	name varchar(255) not null,
	CONSTRAINT seat_type_pkey PRIMARY KEY (id)
);

create table if not exists public.hall (
	id serial,
	name varchar(255) not null,
	CONSTRAINT hall_pkey PRIMARY KEY (id)
);

create table if not exists public.seat (
	id serial,
	hall_id int4 not null,
	type_id int4 not null,
	number int4 not null,
	"row" int4 not null,
	active bool not null default true,
	CONSTRAINT seat_pkey PRIMARY KEY (id),
	unique (hall_id, number, "row"),
	CONSTRAINT fk_5 FOREIGN KEY (hall_id) REFERENCES hall(id) ON DELETE restrict,
	CONSTRAINT fk_6 FOREIGN KEY (type_id) REFERENCES seat_type(id) ON DELETE restrict
);

create table if not exists public.movie (
	id serial,
	name varchar(255) not null,
	description varchar(255),
	duration int4,
	country varchar(255),
	language varchar(255),
	CONSTRAINT movie_pkey PRIMARY KEY (id)
);
CREATE index if not exists idx_1 ON public.movie USING btree (name);

create table if not exists public.session (
	id serial,
	hall_id int4 not null,
	movie_id int4 not null,
	datetime timestamp not null,
	CONSTRAINT session_pkey PRIMARY KEY (id),
	unique (hall_id, datetime),
	CONSTRAINT fk_1 FOREIGN KEY (movie_id) REFERENCES movie(id) ON DELETE restrict,
	CONSTRAINT fk_2 FOREIGN KEY (hall_id) REFERENCES hall(id) ON DELETE restrict
);
CREATE index if not exists idx_2 ON public.session USING btree (movie_id);
CREATE index if not exists idx_3 ON public.session USING btree (datetime);

create table if not exists public.session_seat (
	id serial,
	session_id int4 not null,
	seat_id int4 not null,
	rate int not null,
	CONSTRAINT session_seat_pkey PRIMARY KEY (id),
	unique (session_id, seat_id),
	CONSTRAINT fk_3 FOREIGN KEY (session_id) REFERENCES session(id) ON DELETE restrict,
	CONSTRAINT fk_4 FOREIGN KEY (seat_id) REFERENCES seat(id) ON DELETE restrict
);

create table if not exists public.client (
	id serial,
	first_name varchar(255),
	last_name varchar(255),
	phone varchar(50),
	CONSTRAINT client_pkey PRIMARY KEY (id)
);
CREATE index if not exists idx_4 ON public.client USING btree (phone);
CREATE index if not exists idx_5 ON public.client USING btree (last_name);
CREATE index if not exists idx_6 ON public.client USING btree (first_name);

create table if not exists public.order (
	id serial,
	client_id int4 not null,
	state varchar(255) not null,
	CONSTRAINT order_pkey PRIMARY KEY (id),
	CONSTRAINT fk_9 FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE restrict
);

create table if not exists public.order_item (
	id serial,
	order_id int4 not null,
	session_seat_id int4 not null,
	discount int not null default 0,
	CONSTRAINT order_item_pkey PRIMARY KEY (id),
	unique (session_seat_id),
	CONSTRAINT fk_7 FOREIGN KEY (session_seat_id) REFERENCES session_seat(id) ON DELETE restrict,
	CONSTRAINT fk_8 FOREIGN KEY (order_id) REFERENCES "order"(id) ON DELETE cascade
);
CREATE index if not exists idx_7 ON public.order_item USING btree (order_id);

