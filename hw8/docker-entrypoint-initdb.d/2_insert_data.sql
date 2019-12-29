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

COPY public.film (id, name, year) FROM stdin;
1	Новый фильм 	2020-01-01
2	Старая хорошая комедия	1994-01-01
3	Боевик на все времена	1980-01-01
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
-- Name: client_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.client_id_seq', 4, true);


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

