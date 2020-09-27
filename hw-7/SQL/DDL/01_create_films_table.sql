CREATE TABLE films
(
    id          serial      not null
        constraint films_pkey primary key,
    name        varchar(60) not null,
    description text        not null,
    duration    integer     not null,
    age_limit   smallint
);
