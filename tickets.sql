create table tickets
(
	id serial not null
		constraint tickets_pk
			primary key,
	hall_movie_id integer not null,
	row integer not null,
	seat integer not null
);

alter table tickets owner to postgres;

create unique index tickets_id_uindex
	on tickets (id);

