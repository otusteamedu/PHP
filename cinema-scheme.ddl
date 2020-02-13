create table if not exists genres
(
    id   int auto_increment primary key,
    name varchar(255) null,
    constraint genres_name_uindex unique (name)

) charset = utf8;

create table if not exists movies
(
    id       int auto_increment primary key,
    title    varchar(255)  null,
    duration int default 0 null
) charset = utf8;
create table if not exists movies_genres
(
    movie_id int null,
    genre_id int not null,
    constraint movies_genres_genres_id_fk foreign key (genre_id) references genres (id) on update cascade on delete cascade,
    constraint movies_genres_movies_id_fk foreign key (movie_id) references movies (id) on update cascade on delete cascade
) charset = utf8;