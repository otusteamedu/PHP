create database cinema with owner cinema;

create table if not exists films
(
	id serial not null
		constraint films_pk
			primary key,
	name varchar not null
);

alter table films owner to cinema;

create unique index if not exists films_id_uindex
	on films (id);

create table if not exists halls
(
	id serial not null
		constraint halls_pk
			primary key,
	rows_count integer not null,
	seats_count integer not null
);

alter table halls owner to cinema;

create table if not exists seances
(
	id serial not null
		constraint seances_pk
			primary key,
	film_id integer not null
		constraint seances_films_id_fk
			references films
				on update cascade on delete cascade,
	hall_id integer not null
		constraint seances_halls_id_fk
			references halls
				on update cascade on delete cascade,
	starts_at timestamp not null,
	price money
);

alter table seances owner to cinema;

create unique index if not exists seances_film_id_hall_id_starts_at_uindex
	on seances (film_id, hall_id, starts_at);

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
	price money
);

alter table tickets owner to cinema;

create unique index if not exists tickets_seance_id_row_seat_uindex
	on tickets (seance_id, row, seat);

create table if not exists film_attribute_types
(
	id serial not null
		constraint film_attribute_types_pk
			primary key,
	name varchar not null
);

alter table film_attribute_types owner to cinema;

create table if not exists film_attributes
(
	id serial not null
		constraint film_attributes_pk
			primary key,
	name varchar not null,
	type_id integer not null
		constraint film_attributes_film_attribute_types_id_fk
			references film_attribute_types
				on update cascade on delete cascade,
	description varchar
);

alter table film_attributes owner to cinema;

create unique index if not exists film_attributes_name_uindex
	on film_attributes (name);

create table if not exists film_attribute_values
(
	film_id integer not null
		constraint film_attribute_values_films_id_fk
			references films
				on update cascade on delete cascade,
	attribute_id integer not null
		constraint film_attribute_values_film_attributes_id_fk
			references film_attributes
				on update cascade on delete cascade,
	string_value varchar,
	integer_value integer,
	boolean_value boolean,
	date_value date,
	text_value text,
	float_value double precision,
	constraint film_attribute_values_pk
		primary key (film_id, attribute_id)
);

alter table film_attribute_values owner to cinema;

create unique index if not exists film_attribute_types_name_uindex on film_attribute_types (name);

create or replace view tasks(film, current_tasks, future_tasks) as
SELECT films.name AS film,
       json_agg(json_build_object('name', current_tasks.attr, 'value', current_tasks.date_value)) AS current_tasks,
       json_agg(json_build_object('name', future_tasks.attr, 'value', future_tasks.date_value)) AS future_tasks
FROM ((films
    JOIN (SELECT attr_values.film_id,
                 attrs.description AS attr,
                 attr_values.date_value
          FROM (film_attribute_values attr_values
            JOIN film_attributes attrs ON (((attr_values.attribute_id = attrs.id) AND ((attrs.name)::text = ANY ((ARRAY ['advert_start_date'::character varying, 'ticket_start_date'::character varying])::text[])))))
          WHERE ((attr_values.date_value >= to_timestamp(to_char(now(), 'yyyy-mm-dd 00:00:00'::text), 'yyyy-mm-dd HH24:MI:SS'::text))
                AND (attr_values.date_value <= to_timestamp(to_char(now(), 'yyyy-mm-dd 23:59:59'::text), 'yyyy-mm-dd HH24:MI:SS'::text)))) current_tasks
                ON ((current_tasks.film_id = films.id)))
    JOIN (SELECT attr_values.film_id,
                 attrs.description AS attr,
                 attr_values.date_value
          FROM (film_attribute_values attr_values
            JOIN film_attributes attrs ON (((attr_values.attribute_id = attrs.id) AND ((attrs.name)::text = ANY ((ARRAY ['advert_start_date'::character varying, 'ticket_start_date'::character varying])::text[])))))
          WHERE ((attr_values.date_value >= to_timestamp(to_char((now() + '20 days'::interval), 'yyyy-mm-dd 00:00:00'::text), 'yyyy-mm-dd HH24:MI:SS'::text)) AND (attr_values.date_value <= to_timestamp(to_char((now() + '20 days'::interval), 'yyyy-mm-dd 23:59:59'::text),
                 'yyyy-mm-dd HH24:MI:SS'::text)))) future_tasks ON ((future_tasks.film_id = films.id)))
GROUP BY films.name;

alter table tasks owner to cinema;

create or replace view marketing_data(film, name, attr, value) as
SELECT films.name AS film,
       types.name,
       attrs.name AS attr,
       CASE
           WHEN ((types.name)::text = 'string'::text) THEN "values".string_value
           WHEN ((types.name)::text = 'integer'::text) THEN ("values".integer_value)::character varying(255)
           WHEN ((types.name)::text = 'boolean'::text) THEN ("values".boolean_value)::character varying(255)
           WHEN ((types.name)::text = 'date'::text) THEN (to_char(("values".date_value)::timestamp with time zone,
                                                                  'dd-mm-yyyy'::text))::character varying
           WHEN ((types.name)::text = 'text'::text) THEN ("values".text_value)::character varying
           WHEN ((types.name)::text = 'float'::text) THEN (btrim(
                   to_char("values".float_value, '99 999 999 999 999 990'::text)))::character varying
           ELSE ''::character varying
           END    AS value
FROM (((films
    JOIN film_attribute_values "values" ON ((films.id = "values".film_id)))
    JOIN film_attributes attrs ON ((("values".attribute_id = attrs.id) AND ((attrs.name)::text <> ALL
                                                                            ((ARRAY ['advert_start_date'::character varying, 'ticket_start_date'::character varying])::text[])))))
         JOIN film_attribute_types types ON ((attrs.type_id = types.id)));

alter table marketing_data owner to cinema;