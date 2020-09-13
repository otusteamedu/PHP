create table movie
(
	id serial not null
		constraint movie_pk
			primary key,
	title varchar(255) not null,
	length integer
);

alter table movie owner to postgres;

create unique index movie_id_uindex
	on movie (id);

