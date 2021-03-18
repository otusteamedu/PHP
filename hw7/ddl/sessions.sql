create table sessions
(
    id bigint not null primary key,
    start_date timestamp not null,
    hall_id bigint not null
        references halls on update cascade,
    film_id bigint not null
        references films on update cascade,
    price integer not null,
    unique (start_date, hall_id)
);