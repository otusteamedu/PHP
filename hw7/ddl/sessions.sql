create table sessions
(
    id bigint not null primary key,
    start_date date not null,
    start_time time not null,
    hall_id bigint not null
        references halls on update cascade,
    film_id bigint not null
        references films on update cascade,
    price integer not null,
    unique (start_date, start_time, hall_id)
);