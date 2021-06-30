create table requests
(
    id varchar(36) not null
        constraint requests_pk
            primary key,
    name varchar(255),
    creation_date timestamp not null,
    status integer not null
);