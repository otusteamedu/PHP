--
-- PostgreSQL database dump
--

-- Dumped from database version 10.13 (Debian 10.13-1.pgdg90+1)
-- Dumped by pg_dump version 10.14 (Ubuntu 10.14-0ubuntu0.18.04.1)

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
-- Data for Name: attr_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.attr_types (id, attr_type) FROM stdin;
1	Рецензии
2	премия
3	важные даты
4	служебные даты
\.


--
-- Data for Name: attrs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.attrs (id, attr_type, attr_name) FROM stdin;
1	1	рецензии критиков
2	1	отзыв киноакадемии
3	2	оскар
4	2	ника
5	3	мировая примьера
6	3	примьера в РФ
7	4	дата начала продаж билетов
8	4	дата запуска рекламы на ТВ
\.


--
-- Data for Name: films; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.films (id, name) FROM stdin;
1	Гари Поттер
2	Такси 3
\.


--
-- Data for Name: attr_values; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.attr_values (id, film, attr, attr_value) FROM stdin;
1	1	1	Супер фильм в своем жанре
2	2	1	собрали все худшее
3	1	7	2020-10-18
4	2	8	2020-11-07
\.


--
-- Name: attr_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attr_types_id_seq', 4, true);


--
-- Name: attr_values_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attr_values_id_seq', 4, true);


--
-- Name: attrs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attrs_id_seq', 8, true);


--
-- Name: films_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.films_id_seq', 2, true);


--
-- PostgreSQL database dump complete
--

