create table if not exists movies (
	id serial primary key,
	name char(255) not null,
	duration int,
	age_limit int not null,
	description text
);

create index movies_index on movies(name);

create table if not exists attribute_types (
	id serial primary key,
	name char(60) unique not null,
	comment char(250)
);

create index attribute_types_index on attribute_types(name);

create table if not exists attributes (
	id serial primary key,
	name char(60) unique not null,
	type_id int references attribute_types
);

create index attributes_index on attributes(name)

create table if not exists attribute_values (
	id serial primary key,
	movie_id int not null references movies,
	attribute_id int not null references attributes,
	value_date date,
    value_text text,
    value_number numeric,
    value_bool bool
);

create index attribute_values_index_text on attribute_values(value_text);
create index attribute_values_index_date on attribute_values(value_date);
create index attribute_values_index_number on attribute_values(value_number);
create index attribute_values_index_bool on attribute_values(value_bool);

insert into movies(name,duration,age_limit,description) values ('tenet-1',5400,16,'some_text');
insert into movies(name,duration,age_limit,description) values ('tenet-2',5400,16,'some_text');
insert into movies(name,duration,age_limit,description) values ('tenet-3',5400,16,'some_text');

insert into attribute_types(name) values ('текст');
insert into attribute_types(name) values ('дата');
insert into attribute_types(name) values ('логическое значение');
insert into attribute_types(name) values ('число');

insert into attributes(name,type_id) values ('cюжет', 1);
insert into attributes(name,type_id) values ('рецензия', 1);
insert into attributes(name,type_id) values ('дата выхода', 2);
insert into attributes(name,type_id) values ('премия', 3); -- премия есть/нет
insert into attributes(name,type_id) values ('сбор', 4);

insert into attribute_values(movie_id, attribute_id, value_text) values (1,1,'сюжет tenet-1');
insert into attribute_values(movie_id, attribute_id, value_text) values (1,2,'рецензия tenet-1');
insert into attribute_values(movie_id, attribute_id, value_date) values (1,3,'2021-05-10');

insert into attribute_values(movie_id, attribute_id, value_text) values (2,1,'сюжет tenet-2');
insert into attribute_values(movie_id, attribute_id, value_text) values (2,2,'рецензия tenet-2');
insert into attribute_values(movie_id, attribute_id, value_date) values (2,3,'2020-11-10');
insert into attribute_values(movie_id, attribute_id, value_bool) values (2,4, true);
insert into attribute_values(movie_id, attribute_id, value_number) values (2,5, 70000000);

insert into attribute_values(movie_id, attribute_id, value_text) values (3,1,'сюжет tenet-3');
insert into attribute_values(movie_id, attribute_id, value_text) values (3,2,'рецензия tenet-3');
insert into attribute_values(movie_id, attribute_id, value_date) values (3,3,'2020-08-10');
insert into attribute_values(movie_id, attribute_id, value_bool) values (3,4, true);
insert into attribute_values(movie_id, attribute_id, value_number) values (3,5, 70000000);


-- select movies.name, a.name, av.value_date,av.value_text,av.value_number,av.value_bool from movies
--     inner join attribute_values av on movies.id = av.movie_id
--     inner join attributes a on av.attribute_id = a.id
--     inner join attribute_types t on a.type_id = t.id

create or replace view otus_view as
    select movies.name as movie_name, a.name as attr_name, av.value_date,av.value_text,av.value_number,av.value_bool from movies
    inner join attribute_values av on movies.id = av.movie_id
    inner join attributes a on av.attribute_id = a.id
    inner join attribute_types t on a.type_id = t.id;




