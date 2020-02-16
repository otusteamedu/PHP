CREATE TABLE public.users (
    id serial NOT NULL,
    username varchar(64) NOT NULL,
    first_name varchar(255) NOT NULL,
    last_name varchar(64) NOT NULL,
    city varchar(64),
    created_at timestamp NOT NULL,
    updated_at timestamp,
    password varchar(64) NOT NULL,
    CONSTRAINT users_pk PRIMARY KEY (id)
);

CREATE INDEX user_username_idx ON public.users (lower("username"));
