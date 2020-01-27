CREATE TABLE public.cinema (
	id serial NOT NULL,
	cinema_name varchar(255) NOT NULL,
	cinema_address varchar(255) NOT NULL,
	CONSTRAINT cinema_pkey PRIMARY KEY (id)
);

CREATE TABLE public.hall (
	hall_id serial NOT NULL,
	hall_name varchar(255) NULL,
	cinema_id int4 NULL,
	CONSTRAINT hall_pkey PRIMARY KEY (hall_id),
	CONSTRAINT hall_fk FOREIGN KEY (cinema_id) REFERENCES cinema(id)
);

CREATE TABLE public.movie (
	movie_id serial NOT NULL,
	movie_name varchar(255) NULL,
	format varchar(2) NOT NULL,
	duration int4 NOT NULL,
	CONSTRAINT movie_pkey PRIMARY KEY (movie_id)
);

CREATE TABLE public."session" (
	session_id serial NOT NULL,
	"data" date NULL,
	"start" time NULL,
	hall_id int4 NULL,
	movie_id int4 NULL,
	price money NOT NULL,
	CONSTRAINT session_pkey PRIMARY KEY (session_id),
	CONSTRAINT session_fk FOREIGN KEY (movie_id) REFERENCES movie(movie_id),
	CONSTRAINT session_fk_1 FOREIGN KEY (hall_id) REFERENCES hall(hall_id)
);




CREATE TABLE public.ticket (
	ticket_id serial NOT NULL,
	session_id int4 NULL,
	hall_row int4 NULL,
	hall_place int4 NULL,
	price money NOT NULL DEFAULT 0,
	CONSTRAINT ticket_pkey PRIMARY KEY (ticket_id),
	CONSTRAINT ticket_fk FOREIGN KEY (session_id) REFERENCES session(session_id)
);

-- самый прибыльный фильм
select movie.movie_name, sum("session".price) as sum from ticket
left join "session" ON "session".session_id = ticket.session_id
left join movie on movie.movie_id = "session".movie_id group by "movie".movie_id order by sum desc limit 1;