insert into movies(id, title, duration)
values (1, 'Люди в чёрном', 120),
       (2, 'Матрица', 160),
       (3, 'Проект: Альф', 95),
       (4, 'Кошмар на улице Вязов', 130);
insert into genres (id, name)
values (1, 'Комедия'),
       (2, 'Боевик'),
       (3, 'Фантастика'),
       (4, 'Ужасы');
insert into movies_genres (movie_id, genre_id)
values (1, 1),
       (1, 2),
       (1, 3),
       (2, 2),
       (2, 3),
       (3, 1),
       (3, 3),
       (4, 4);