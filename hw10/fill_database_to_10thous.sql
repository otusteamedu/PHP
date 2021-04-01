INSERT INTO public.attr_types (id, name) VALUES (1, 'Рецензии');
INSERT INTO public.attr_types (id, name) VALUES (3, 'Важные даты');
INSERT INTO public.attr_types (id, name) VALUES (4, 'Служебные даты');
INSERT INTO public.attr_types (id, name) VALUES (2, 'Премии');
INSERT INTO public.attr_types (id, name) VALUES (5, 'Сборы');
INSERT INTO public.attr_types (id, name) VALUES (6, 'Целочисленные атрибуты');

CALL insert_records(1, 10000);