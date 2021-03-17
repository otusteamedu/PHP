create table tickets
(
    id bigint not null primary key,
    session_id bigint not null
        references sessions on update cascade,
    sale_date timestamp not null,
    price integer not null
);