create table hall_movie
(
	id serial not null
		constraint hall_movie_pk
			primary key,
	date timestamp not null,
	hall_id integer not null,
	movie_id integer not null,
	cost integer not null
);

alter table hall_movie owner to postgres;

create unique index hall_movie_id_uindex
	on hall_movie (id);

