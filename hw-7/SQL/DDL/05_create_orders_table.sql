CREATE TABLE orders
(
    id        serial        not null
        constraint orders_pkey primary key,
    user_id   integer       not null REFERENCES users,
    seance_id integer       not null REFERENCES seances,
    price     decimal(8, 2) not null
);
