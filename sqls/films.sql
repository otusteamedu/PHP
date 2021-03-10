CREATE TABLE public.films (
      id serial NOT NULL,
      "name" varchar(100) NOT NULL,
      description varchar(255) NULL,
      age_restrict int2 NOT NULL,
      created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      duration time NOT NULL,
      CONSTRAINT films_pkey PRIMARY KEY (id)
);