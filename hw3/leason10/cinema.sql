-- зал

create table if not exists hall
(
    id   serial      not null,
    name varchar(50) not null,
    primary key (id)
);

-- фильм
create table if not exists film
(
    id   serial       not null,
    name varchar(100) not null,
    primary key (id)
);

-- сеанс
create table if not exists seanse
(
    id         serial not null,
    hall       int    not null references hall (id),
    film       int    not null references film (id),
    start_show time   not null,
    primary key (id)
);

-- билет
create table if not exists ticket
(
    id     serial not null,
    seanse int    not null references seanse (id),
    row    int    not null,
    col    int    not null,
    coast  numeric(6, 2),
    primary key (id)
);

-- типы атрибутов
create table if not exists attr_types
(
    id        serial       not null,
    attr_type varchar(200) not null,
    primary key (id)
);
-- атрибуты
create table if not exists attrs
(
    id        serial       not null,
    attr_type int          not null references attr_types (id),
    attr_name varchar(200) not null,
    primary key (id)
);
-- значения атрибутов
create table if not exists attr_values
(
    id         serial not null,
    film       int    not null references film (id),
    attr       int    not null references attrs (id),
    attr_value text,
    primary key (id)
);

