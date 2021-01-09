INSERT INTO public.films (id, title, duration_in_minutes, comment) VALUES (1, 'Кавказская пленница', 107, '');
INSERT INTO public.films (id, title, duration_in_minutes, comment) VALUES (2, 'Шурик', 100, '');
INSERT INTO public.films (id, title, duration_in_minutes, comment) VALUES (3, 'Джентлемены удачи', 97, '');

INSERT INTO public."filmAttributeTypes" (id, title, comment) VALUES (1, 'boolean', '');
INSERT INTO public."filmAttributeTypes" (id, title, comment) VALUES (2, 'number', '');
INSERT INTO public."filmAttributeTypes" (id, title, comment) VALUES (3, 'date', '');
INSERT INTO public."filmAttributeTypes" (id, title, comment) VALUES (4, 'text', '');

INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (1, 'субтитры на русском', 1);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (2, 'бюджет фильма, $', 2);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (3, 'важная дата', 3);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (4, 'служебная дата', 3);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (5, 'рецензия', 4);
INSERT INTO public."filmAttributes" (id, title, type_id) VALUES (6, 'премия', 4);

INSERT INTO public."filmAttributeValues" (film_id, attribute_id, val_bool, val_num, val_date, val_text, comment)
VALUES (1, 1, true, null, null, null, 'гоблинские');
INSERT INTO public."filmAttributeValues" (film_id, attribute_id, val_bool, val_num, val_date, val_text, comment)
VALUES (1, 2, null, 100000, null, null, 'в советское время рубль ложил болт на доллар');
INSERT INTO public."filmAttributeValues" (film_id, attribute_id, val_bool, val_num, val_date, val_text, comment)
VALUES (2, 3, null, null, '1963-10-01', null, 'фильм был показан по главному телеканалу СССР');
INSERT INTO public."filmAttributeValues" (film_id, attribute_id, val_bool, val_num, val_date, val_text, comment)
VALUES (2, 6, null, null, null, 'oscar - 1883', '');
