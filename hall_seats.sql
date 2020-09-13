create table hall_seats
(
	id serial not null
		constraint hall_seats_pk
			primary key,
	hall_id integer not null,
	row_number integer,
	seat_count integer not null,
	constraint hall_seats_pk_2
		unique (hall_id, row_number)
);

alter table hall_seats owner to postgres;

create unique index hall_seats_id_uindex
	on hall_seats (id);

