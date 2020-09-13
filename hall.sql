create table if not exists hall
(
	id serial not null
		constraint cinema_hall_pk
			primary key,
	title varchar(100) not null
);

comment on table hall is 'Зал кинотетра';

alter table hall owner to postgres;

create unique index if not exists cinema_hall_id_uindex
	on hall (id);

