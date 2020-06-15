create type genre as enum ('аниме', 'биографический', 'боевик', 'вестерн', 'военный', 'детектив', 'детский', 'документальный', 'драма', 'исторический', 'кинокомикс', 'комедия', 'концерт', 'короткометражный', 'криминал', 'мелодрама', 'мистика', 'музыка', 'мультфильм', 'мюзикл', 'научный', 'приключения', 'реалити-шоу', 'семейный', 'спорт', 'ток-шоу', 'триллер', 'ужасы', 'фантастика', 'фильм-нуар', 'фэнтези', 'эротика');
create type types as enum ('bool', 'string', 'int', 'numeric', 'date', 'text', 'genre');

create table if not exists public.movie (
        id serial,
        name varchar(255) not null,
        CONSTRAINT movie_pkey PRIMARY KEY (id)
);

create table if not exists public.attribute_type (
         id serial,
         name varchar(255) not null,
         type types,
         CONSTRAINT attribute_type_pkey PRIMARY KEY (id)
);

create table if not exists public.attribute (
        id serial,
        name varchar(255) not null,
        type_id int not null,
        CONSTRAINT attribute_pkey PRIMARY KEY (id),
        CONSTRAINT fk_1 FOREIGN KEY (type_id) REFERENCES attribute_type(id) ON DELETE restrict
);

create table if not exists public.value (
        id serial,
        attribute_id int not null,
        movie_id int not null,
        bool_value bool,
        string_value varchar(255),
        int_value int,
        numeric_value numeric(17,4),
        date_value timestamp,
        text_value text,
        genre genre,
        CONSTRAINT value_pkey PRIMARY KEY (id),
        CONSTRAINT fk_2 FOREIGN KEY (attribute_id) REFERENCES attribute(id) ON DELETE restrict,
        CONSTRAINT fk_3 FOREIGN KEY (movie_id) REFERENCES movie(id) ON DELETE restrict
);

CREATE index if not exists idx_2 ON public.value USING btree (bool_value);
CREATE index if not exists idx_3 ON public.value USING btree (string_value);
CREATE index if not exists idx_4 ON public.value USING btree (int_value);
CREATE index if not exists idx_5 ON public.value USING btree (numeric_value);
CREATE index if not exists idx_6 ON public.value USING btree (date_value);
CREATE index if not exists idx_7 ON public.value USING GIN (to_tsvector('russian', text_value));
CREATE index if not exists idx_8 ON public.value USING btree (movie_id);
CREATE index if not exists idx_8 ON public.value USING btree (genre);
