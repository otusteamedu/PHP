--
-- PostgreSQL database dump
--

-- Dumped from database version 12.1 (Debian 12.1-1.pgdg100+1)
-- Dumped by pg_dump version 12.1 (Debian 12.1-1.pgdg100+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: client; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.client (id, name) FROM stdin;
1	Василий Петрович
2	Иван Петрович Борисов
3	Инна Васильевна 
4	Анна Ивановна
\.


--
-- Data for Name: film; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film (id, name) FROM stdin;
1	Новый фильм 
2	Старая хорошая комедия
3	Боевик на все времена
\.


--
-- Data for Name: hall; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hall (id, name, size) FROM stdin;
1	Большой зал	2000
2	Средний зал	1000
3	Малый зал	500
\.


--
-- Data for Name: session; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.session (id, film_id, hall_id, start) FROM stdin;
3	2	2	2019-12-30 12:00:00+00
4	3	3	2019-12-01 13:00:00+00
2	1	1	2020-01-01 13:00:00+00
\.


--
-- Data for Name: ticket; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ticket (id, session_id, place, price) FROM stdin;
2	2	1	300
3	2	2	300
4	2	3	300
5	2	11	200
6	2	12	200
7	2	13	200
8	3	1	150
9	3	2	150
10	3	3	150
11	3	11	100
12	3	12	100
13	3	13	100
14	4	1	100
15	4	2	100
16	4	3	100
17	4	11	80
18	4	12	80
19	4	13	80
\.


--
-- Data for Name: client_ticket; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.client_ticket (client_id, ticket_id) FROM stdin;
1	2
1	3
1	4
2	5
3	6
4	7
2	8
3	9
4	10
1	11
2	12
3	13
4	14
1	15
2	16
3	17
4	18
1	19
\.


--
-- Data for Name: film_attribute_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_attribute_type (id, name) FROM stdin;
6	Служебные даты
1	Рецензии
2	Премия
3	Важные даты
4	Просмотры
5	Рейтинги
\.


--
-- Data for Name: film_attribute; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_attribute (id, name, type_id, description) FROM stdin;
1	Рецензии критиков	1	рецензии
2	Отзывы	1	отзывы зрителей
3	Премия Оскар	2	печать изображения награды
4	Премия Ника 	2	печать изображения награды
5	Мировая премьера	3	при печати - наименование атрибута и значение даты
6	Премьера в РФ	3	при печати - наименование атрибута и значение даты
7	Дата начала продажи билетов	6	\N
8	Дата запуска рекламы на ТВ	6	\N
9	Дата окончания показа	6	\N
10	Дата начала показа в онлайн кинотеатрах	6	\N
11	Количество просмотров за неделю	4	\N
12	Количество просмотров за месяц	4	\N
13	Рейтинг IMDB 	5	\N
14	Рейтинг kinopoisk.ru 	5	\N
15	Количество проданных билетов	4	\N
16	Количество просмотров за все время	4	\N
17	Дата установки скидочного баннера на сайт	6	\N
\.


--
-- Data for Name: film_attribute_value; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_attribute_value (id, attribute_id, film_id, val_date, val_text, val_int, val_decimal, val_bool) FROM stdin;
1	1	1	\N	Достойный фильм	\N	\N	\N
2	3	1	\N	\N	\N	\N	t
3	6	1	2020-01-01	\N	\N	\N	\N
4	7	1	2020-01-01	\N	\N	\N	\N
5	8	1	2019-12-01	\N	\N	\N	\N
6	9	1	2020-02-10	\N	\N	\N	\N
7	10	1	2020-02-11	\N	\N	\N	\N
8	14	1	\N	\N	\N	8.5	\N
9	15	1	\N	\N	3000	\N	\N
10	2	2	\N	Старая отличная комедия	\N	\N	\N
11	5	2	1994-12-01	\N	\N	\N	\N
12	13	2	\N	\N	\N	9.4	\N
13	16	2	\N	\N	55000000	\N	\N
15	10	2	2020-01-21	\N	\N	\N	\N
16	1	3	\N	Боевик на все времена	\N	\N	\N
18	5	3	1990-01-01	\N	\N	\N	\N
48	17	1	2019-12-01	\N	\N	\N	\N
49	10	2	2019-09-01	\N	\N	\N	\N
17	4	3	\N	\N	\N	\N	f
\.


--
-- Name: client_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.client_id_seq', 4, true);


--
-- Name: film_attribute_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_attribute_id_seq', 17, true);


--
-- Name: film_attribute_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_attribute_type_id_seq', 6, true);


--
-- Name: film_attribute_value_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_attribute_value_id_seq', 49, true);


--
-- Name: film_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_id_seq', 3, true);


--
-- Name: hall_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hall_id_seq', 3, true);


--
-- Name: session_film_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.session_film_seq', 1, false);


--
-- Name: session_hall_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.session_hall_seq', 1, false);


--
-- Name: session_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.session_id_seq', 4, true);


--
-- Name: ticket_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ticket_id_seq', 19, true);


--
-- Name: ticket_session_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ticket_session_id_seq', 1, false);


--
-- PostgreSQL database dump complete
--

