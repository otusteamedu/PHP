-- fill attribute_type table
INSERT INTO public.attribute_type (id, "name", "type") VALUES(1, 'award', 'bool');
INSERT INTO public.attribute_type (id, "name", "type") VALUES(2, 'person', 'string');
INSERT INTO public.attribute_type (id, "name", "type") VALUES(3, 'simple_int', 'int');
INSERT INTO public.attribute_type (id, "name", "type") VALUES(4, 'simple_string', 'string');
INSERT INTO public.attribute_type (id, "name", "type") VALUES(5, 'cash', 'float');
INSERT INTO public.attribute_type (id, "name", "type") VALUES(6, 'review', 'text');
INSERT INTO public.attribute_type (id, "name", "type") VALUES(7, 'genre', 'genre');
INSERT INTO public.attribute_type (id, "name", "type") VALUES(8, 'service_date', 'date');
INSERT INTO public.attribute_type (id, "name", "type") VALUES(9, 'premiere', 'date');

-- fill attribute table
INSERT INTO public."attribute" (id, "name", type_id) VALUES(1, 'Оскар', 1);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(2, 'Ника', 1);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(3, 'Золотой глобус', 1);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(4, 'Премия Гильдии актёров', 1);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(5, 'Сатурн', 1);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(6, 'Режиссёр', 2);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(7, 'Сценарист', 2);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(8, 'Продолжительность', 3);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(9, 'Слоган', 4);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(10, 'Бюджет', 5);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(11, 'Кассовые сборы в Мире', 5);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(12, 'Кассовые сборы в России', 6);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(13, 'Зрители', 3);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(14, 'Композитор', 2);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(15, 'Жанр', 7);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(16, 'Премьера в России', 9);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(17, 'Премьера в Мире', 9);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(18, 'Релиз на DVD', 9);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(19, 'Дата продажи билетов онлайн', 8);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(20, 'Дата расклейки афиш', 8);
INSERT INTO public."attribute" (id, "name", type_id) VALUES(21, 'Год выпуска', 3);
