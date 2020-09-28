CREATE TABLE halls
(
    id           serial not null
        constraint halls_pkey primary key,
    name         varchar(40),
    max_visitors integer
);
