\connect movie_eav;

TRUNCATE TABLE 
    attribute_type, 
    movie, 
    movie_attribute, 
    movie_attribute_dict_value, 
    movie_attribute_value
RESTART IDENTITY;

INSERT INTO attribute_type (code, name) VALUES
    ('date', 'Дата'),
    ('datetime', 'Дата и время'),
    ('integer', 'Целое число'),
    ('numeric', 'Число'),
    ('text', 'Текст'),
    ('dict', 'Справочник');

INSERT INTO movie_attribute (code, name, is_required, is_multi, attribute_type_id) VALUES
    ('images', 'Изображения', true, true, 5),
    ('year', 'Год выпуска', true, false, 3),
    ('rating', 'Возрастное ограничение', true , false, 6),
    ('actors', 'Актеры', false, true, 5),
    ('time', 'Длительность (мин)', true, false, 3),
    ('description', 'Описание', false, false, 5),
    ('date_start', 'Дата выхода в прокат', true, false, 1),
    ('date_print_posters', 'Дата печати постеров', true, false, 1),
    ('date_adv', 'Дата старта рекламы', true, false, 1);

INSERT INTO movie_attribute_dict_value (code, value, movie_attribute_id) VALUES
    ('0', '0+', 3),
    ('12', '12+', 3),
    ('16', '16+', 3),
    ('18', '18+', 3);

INSERT INTO movie (title) VALUES 
    ('Форсаж: Хоббс и Шоу'),
    ('Человек-паук: Вдали от дома');

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, value_date, value_text, value_int, value_real) VALUES
    (1, 1, NULL, '/upload/img1.png', NULL, NULL),
    (1, 1, NULL, '/upload/img2.png', NULL, NULL),
    (1, 1, NULL, '/upload/img3.png', NULL, NULL),
    (1, 2, NULL, NULL, 2019, NULL),
    (1, 3, NULL, NULL, 2, NULL),
    (1, 4, NULL, 'Дуэйн Джонсон', NULL, NULL),
    (1, 4, NULL, 'Джейсон Стэйтем', NULL, NULL),
    (1, 4, NULL, 'Ванесса Кирби', NULL, NULL),
    (1, 4, NULL, 'Эйса Гонсалес', NULL, NULL),
    (1, 4, NULL, 'Идрис Эльба', NULL, NULL),
    (1, 5, NULL, NULL, 134, NULL),
    (1, 6, NULL, 'Люк Хоббс – американский элитный спецагент, он любит удобную спортивную одежду, большие пикапы и здоровое питание. Декард Шоу – британский пижон, бывший сотрудник разведки, предпочитает дорогие костюмы, спортивные авто и длинноногих красоток.

 Эти двое ненавидят друг друга. Но если кто-то угрожает их семьям, они готовы пойти на все. Даже на работу в команде.', NULL, NULL),
    (1, 7, current_date + interval '30' day, NULL, NULL, NULL),
    (1, 8, current_date, NULL, NULL, NULL),
    (1, 9, current_date + interval '20' day, NULL, NULL, NULL);