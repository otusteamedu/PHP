create schema cinema;

comment on schema cinema is 'cinema schema';

alter schema cinema owner to postgres;

create table if not exists halls
(
	id serial not null
		constraint halls_pk
			primary key,
	name varchar,
	rows_count integer not null,
	seats_count integer not null
);

comment on column halls.rows_count is 'Количество рядов';

comment on column halls.seats_count is 'Количество мест';

alter table halls owner to postgres;

create unique index if not exists halls_name_uindex
	on halls (name);

create table if not exists movies
(
	id serial not null
		constraint films_pk
			primary key,
	title varchar not null,
	description text
);

comment on table movies is 'Фильмы';

comment on column movies.title is 'Название';

comment on column movies.description is 'Описание';

alter table movies owner to postgres;

create table if not exists seances
(
	id serial not null
		constraint seances_pk
			primary key,
	movie_id integer not null
		constraint seances_movies_id_fk
			references movies
				on update cascade on delete cascade,
	hall_id integer not null
		constraint seances_halls_id_fk
			references halls
				on update cascade on delete cascade,
	datetime timestamp not null,
	price integer,
	constraint seances_uk
		unique (movie_id, hall_id, datetime)
);

comment on table seances is 'Сеансы';

comment on column seances.movie_id is 'ID фильма';

comment on column seances.hall_id is 'ID зала';

comment on column seances.datetime is 'Дата и время начала';

comment on column seances.price is 'Цена билета';

alter table seances owner to postgres;

create table if not exists tickets
(
	id serial not null
		constraint tickets_pk
			primary key,
	seance_id integer not null
		constraint tickets_seances_id_fk
			references seances
				on update cascade on delete cascade,
	row integer not null,
	seat integer not null,
	price integer not null,
	constraint tickets_uk
		unique (seance_id, row, seat)
);

comment on table tickets is 'Билеты';

comment on column tickets.seance_id is 'ID сеанса';

comment on column tickets.row is 'Ряд';

comment on column tickets.seat is 'Место';

comment on column tickets.price is 'Цена';

alter table tickets owner to postgres;

create table if not exists movie_attributes
(
	id serial not null
		constraint movie_attributes_pk
			primary key,
	name varchar not null,
	type varchar not null,
	required boolean default false,
	variants json,
	sort integer
);

comment on table movie_attributes is 'Характеристики фильмов';

comment on column movie_attributes.name is 'Название';

comment on column movie_attributes.type is 'Тип';

comment on column movie_attributes.required is 'Обязателен для заполнения';

comment on column movie_attributes.variants is 'Возможные значения';

comment on column movie_attributes.sort is 'Позиция сортировки';

alter table movie_attributes owner to postgres;

create unique index if not exists movie_attributes_name_uindex
	on movie_attributes (name);

create unique index if not exists movie_attributes_sort_uindex
	on movie_attributes (sort);

create table if not exists movie_values
(
	movie_id integer not null
		constraint movie_values_movies_id_fk
			references movies
				on update cascade on delete cascade,
	attribute_id integer not null
		constraint movie_values_movie_attributes_id_fk
			references movie_attributes
				on update cascade on delete cascade,
	value varchar not null,
	constraint movie_values_pk
		primary key (movie_id, attribute_id)
);

comment on table movie_values is 'Значения характеристик фильмов';

comment on column movie_values.movie_id is 'ID фильма';

comment on column movie_values.attribute_id is 'ID характеристики';

comment on column movie_values.value is 'Значение атрибута';

alter table movie_values owner to postgres;

