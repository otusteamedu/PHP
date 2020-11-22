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
-- Data for Name: film; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film (id, name) FROM stdin;
1	Гарри Поттер
2	Такси 2
3	Терминатор
\.


--
-- Data for Name: hall; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hall (id, name) FROM stdin;
1	Малый зал
2	Большой зал
\.


--
-- Data for Name: seanse; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seanse (id, hall, film, start_show) FROM stdin;
1	1	1	09:00:00
2	1	2	11:00:00
3	1	3	13:00:00
4	2	3	09:00:00
5	2	1	11:00:00
6	3	2	13:00:00
\.


--
-- Data for Name: ticket; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ticket (id, seanse, "row", col, coast) FROM stdin;
1	1	3	4	1.00
2	1	3	5	1.00
3	1	3	6	1.00
4	1	4	5	1.00
5	1	4	6	1.00
6	2	3	4	1.00
7	2	3	5	1.00
8	2	3	6	1.00
9	3	4	5	1.00
10	3	4	6	1.00
11	4	3	4	1.00
12	4	3	5	1.00
13	5	4	3	1.00
14	5	4	4	1.00
15	5	4	5	1.00
16	5	4	6	1.00
17	6	4	4	1.00
18	7	4	6	1.00
\.


--
-- Name: film_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_id_seq', 1, false);


--
-- Name: hall_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hall_id_seq', 1, false);


--
-- Name: seanse_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seanse_id_seq', 1, false);


--
-- Name: ticket_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ticket_id_seq', 1, false);


--
-- PostgreSQL database dump complete
--

