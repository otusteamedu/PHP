CREATE TABLE users
(
    id            serial not null
        constraint users_pkey primary key,
    email         varchar(50) unique,
    date_birthday date
);
