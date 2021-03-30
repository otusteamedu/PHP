drop table if exists airplanes;
drop sequence if exists airplanes_id_seq;

drop table if exists airlines;
drop sequence if exists airlines_id_seq;


create table airlines
(
    id           serial primary key,
    name         varchar not null unique,
    abbreviation varchar not null unique,
    description  text    not null
);

create table airplanes
(
    id          serial primary key,
    name        varchar not null,
    number      int not null unique,
    seats_count smallint not null,
    build_date  date not null,
    airline_id  int default null,
    foreign key (airline_id) references airlines (id)
        on update cascade
);
