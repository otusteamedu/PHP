-- фильмы
create table if not exists films (
    id serial not null,
    name varchar(200) not null,
    primary key(id)
);
-- типы атрибутов
create table if not exists attr_types(
    id serial not null,
    attr_type varchar(200) not null,
    primary key(id)
);
-- атрибуты
create table if not exists attrs (
    id serial not null,
    attr_type int not null references attr_types(id),
    attr_name varchar(200) not null,
    primary key(id)
);
-- значения атрибутов
create table if not exists attr_values (
    id serial not null,
    film int not null references films(id) ,
    attr int not null references attrs(id),
    attr_value text,
    primary key(id)
);