--
-- PostgreSQL database dump
--

-- Dumped from database version 11.4 (Debian 11.4-1.pgdg90+1)
-- Dumped by pg_dump version 11.4 (Debian 11.4-1.pgdg90+1)

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
-- Name: films_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.films_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.films_id_seq OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: allFilms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."allFilms" (
    id bigint DEFAULT nextval('public.films_id_seq'::regclass) NOT NULL,
    "filmName" character varying(254) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public."allFilms" OWNER TO postgres;

--
-- Name: allfilms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.allfilms_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.allfilms_id_seq OWNER TO postgres;

--
-- Name: cinemacustomer_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cinemacustomer_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cinemacustomer_id_seq OWNER TO postgres;

--
-- Name: cinemaCustomer; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."cinemaCustomer" (
    id integer DEFAULT nextval('public.cinemacustomer_id_seq'::regclass) NOT NULL,
    "customerName" text DEFAULT 'Guest'::text
);


ALTER TABLE public."cinemaCustomer" OWNER TO postgres;

--
-- Name: cinemahall_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cinemahall_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cinemahall_id_seq OWNER TO postgres;

--
-- Name: cinemaHall; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."cinemaHall" (
    id bigint DEFAULT nextval('public.cinemahall_id_seq'::regclass) NOT NULL,
    "idHall" integer DEFAULT 0 NOT NULL,
    "cinemaName" character varying(254) DEFAULT ''::character varying NOT NULL,
    "seatHall" integer DEFAULT 0 NOT NULL
);


ALTER TABLE public."cinemaHall" OWNER TO postgres;

--
-- Name: cinemaseance_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cinemaseance_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cinemaseance_id_seq OWNER TO postgres;

--
-- Name: cinemaSeance; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."cinemaSeance" (
    id integer DEFAULT nextval('public.cinemaseance_id_seq'::regclass) NOT NULL,
    "idCinemaHall" integer DEFAULT 0 NOT NULL,
    "idFilm" integer DEFAULT 0 NOT NULL,
    "seanceDateTime" timestamp without time zone,
    "seansePrice" numeric(11,2) DEFAULT 0.0 NOT NULL
);


ALTER TABLE public."cinemaSeance" OWNER TO postgres;

--
-- Name: filmattributestype_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.filmattributestype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filmattributestype_id_seq OWNER TO postgres;

--
-- Name: filmattributesvalues_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.filmattributesvalues_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filmattributesvalues_id_seq OWNER TO postgres;

--
-- Name: filmsattributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.filmsattributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filmsattributes_id_seq OWNER TO postgres;

--
-- Name: filmsAttributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."filmsAttributes" (
    id bigint DEFAULT nextval('public.filmsattributes_id_seq'::regclass) NOT NULL,
    "filmAttributesName" character varying(255) DEFAULT ''::character varying,
    "filmAttributesTypeId" bigint DEFAULT (0)::bigint NOT NULL
);


ALTER TABLE public."filmsAttributes" OWNER TO postgres;

--
-- Name: filmsattributeslist_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.filmsattributeslist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filmsattributeslist_id_seq OWNER TO postgres;

--
-- Name: filmsAttributesList; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."filmsAttributesList" (
    id bigint DEFAULT nextval('public.filmsattributeslist_id_seq'::regclass) NOT NULL,
    "filmId" bigint DEFAULT (0)::bigint NOT NULL,
    "filmAttributesValueId" bigint DEFAULT (0)::bigint NOT NULL,
    "filmAttributesId" bigint DEFAULT (0)::bigint NOT NULL
);


ALTER TABLE public."filmsAttributesList" OWNER TO postgres;

--
-- Name: filmsAttributesType; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."filmsAttributesType" (
    id bigint DEFAULT nextval('public.filmattributestype_id_seq'::regclass) NOT NULL,
    "filmAttributesType" character varying(255) DEFAULT ''::character varying
);


ALTER TABLE public."filmsAttributesType" OWNER TO postgres;

--
-- Name: filmsAttributesValues; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."filmsAttributesValues" (
    id bigint DEFAULT nextval('public.filmattributesvalues_id_seq'::regclass) NOT NULL,
    "integerValue" bigint DEFAULT (0)::bigint NOT NULL,
    "timeValue" time without time zone,
    "dateValue" date,
    "textValue" text,
    "booleanValue" boolean
);


ALTER TABLE public."filmsAttributesValues" OWNER TO postgres;

--
-- Name: filmmarketing; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.filmmarketing AS
 SELECT af."filmName" AS "Film Name",
    "filmsAttributesType"."filmAttributesType" AS "Attribute Type",
    "filmsAttributes"."filmAttributesName" AS "Attribute",
        CASE "filmsAttributesType"."filmAttributesType"
            WHEN 'integer'::text THEN ("filmsAttributesValues"."integerValue")::text
            WHEN 'date'::text THEN ("filmsAttributesValues"."dateValue")::text
            WHEN 'time'::text THEN ("filmsAttributesValues"."timeValue")::text
            WHEN 'text'::text THEN "filmsAttributesValues"."textValue"
            WHEN 'boolean'::text THEN ("filmsAttributesValues"."booleanValue")::text
            ELSE '-'::text
        END AS "Values"
   FROM ((((public."allFilms" af
     LEFT JOIN public."filmsAttributesList" ON ((af.id = "filmsAttributesList"."filmId")))
     JOIN public."filmsAttributes" ON (("filmsAttributesList"."filmAttributesId" = "filmsAttributes".id)))
     JOIN public."filmsAttributesType" ON (("filmsAttributes"."filmAttributesTypeId" = "filmsAttributesType".id)))
     JOIN public."filmsAttributesValues" ON (("filmsAttributesList"."filmAttributesValueId" = "filmsAttributesValues".id)))
  ORDER BY af."filmName";


ALTER TABLE public.filmmarketing OWNER TO postgres;

--
-- Name: filmsmarketing; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.filmsmarketing AS
 SELECT af."filmName" AS "Film Name",
    "filmsAttributesType"."filmAttributesType" AS "Attribute Type",
    "filmsAttributes"."filmAttributesName" AS "Attribute",
        CASE "filmsAttributesType"."filmAttributesType"
            WHEN 'integer'::text THEN ("filmsAttributesValues"."integerValue")::text
            WHEN 'date'::text THEN ("filmsAttributesValues"."dateValue")::text
            WHEN 'time'::text THEN ("filmsAttributesValues"."timeValue")::text
            WHEN 'text'::text THEN "filmsAttributesValues"."textValue"
            WHEN 'boolean'::text THEN ("filmsAttributesValues"."booleanValue")::text
            ELSE '-'::text
        END AS "Values"
   FROM ((((public."allFilms" af
     LEFT JOIN public."filmsAttributesList" ON ((af.id = "filmsAttributesList"."filmId")))
     JOIN public."filmsAttributes" ON (("filmsAttributesList"."filmAttributesId" = "filmsAttributes".id)))
     JOIN public."filmsAttributesType" ON (("filmsAttributes"."filmAttributesTypeId" = "filmsAttributesType".id)))
     JOIN public."filmsAttributesValues" ON (("filmsAttributesList"."filmAttributesValueId" = "filmsAttributesValues".id)))
  ORDER BY af."filmName";


ALTER TABLE public.filmsmarketing OWNER TO postgres;

--
-- Data for Name: allFilms; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."allFilms" (id, "filmName") FROM stdin;
1	Terminator
2	Game of Thrones
\.


--
-- Data for Name: cinemaCustomer; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."cinemaCustomer" (id, "customerName") FROM stdin;
1	Mark Twen
2	John Smith
\.


--
-- Data for Name: cinemaHall; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."cinemaHall" (id, "idHall", "cinemaName", "seatHall") FROM stdin;
2	1	Illuzion_room_1	70
3	1	Illuzion_room_2	30
27	1	New Active Record	120
28	1	New Active Record	120
29	1	New Active Record	120
30	1	New Active Record	120
31	1	New Active Record	120
5	1	New3	200
6	1	New3	200
7	1	New3	200
8	1	New3	200
9	1	New3	200
10	1	New3	200
12	1	New3	200
13	1	New3	200
1	1	New	112
\.


--
-- Data for Name: cinemaSeance; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."cinemaSeance" (id, "idCinemaHall", "idFilm", "seanceDateTime", "seansePrice") FROM stdin;
1	1	1	2019-01-01 10:00:00	900.00
2	2	2	2019-02-01 10:00:00	700.00
3	1	1	2019-01-01 12:00:00	900.00
4	2	2	2019-02-01 13:00:00	700.00
\.


--
-- Data for Name: filmsAttributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."filmsAttributes" (id, "filmAttributesName", "filmAttributesTypeId") FROM stdin;
1	рецензии	4
2	премия	4
3	важные даты	3
4	служебные даты	3
5	мировая премьера	3
6	начала сеанса	2
7	последний сеанс	2
8	Задача №1	4
9	Задача №2	4
10	Задача на 20 июня	4
11	Задача на 10 июля	4
\.


--
-- Data for Name: filmsAttributesList; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."filmsAttributesList" (id, "filmId", "filmAttributesValueId", "filmAttributesId") FROM stdin;
1	1	1	1
2	2	2	1
3	1	3	2
4	2	3	2
5	1	6	3
6	2	6	3
7	1	5	4
8	2	5	4
9	1	9	5
10	2	9	5
11	1	8	6
12	2	7	6
13	1	7	7
14	2	8	7
15	1	10	8
16	2	11	8
17	1	11	9
18	2	10	9
19	2	10	10
20	1	11	11
21	1	10	11
22	1	10	11
23	1	10	11
24	1	10	11
25	1	10	11
26	1	10	11
27	1	10	11
28	1	10	11
29	1	10	11
30	1	10	11
31	1	10	11
32	1	10	11
33	1	10	11
34	1	10	11
35	1	10	11
36	1	10	11
37	1	10	11
38	1	10	11
39	1	10	11
40	1	10	11
41	1	10	11
42	1	10	11
43	1	10	11
44	1	10	11
45	1	10	11
46	1	10	11
47	1	10	11
48	1	10	11
49	1	10	11
50	1	10	11
51	1	10	11
52	1	10	11
53	1	10	11
54	1	10	11
55	1	10	11
56	1	10	11
57	1	10	11
58	1	10	11
59	1	10	11
60	1	10	11
61	1	10	11
62	1	10	11
63	1	10	11
64	1	10	11
65	1	10	11
66	1	10	11
67	1	10	11
68	1	10	11
69	1	10	11
70	1	10	11
71	1	10	11
72	1	10	11
73	1	10	11
74	1	10	11
75	1	10	11
76	1	10	11
77	1	10	11
78	1	10	11
79	1	10	11
80	1	10	11
81	1	10	11
82	1	10	11
83	1	10	11
84	1	10	11
85	1	10	11
86	1	10	11
87	1	10	11
88	1	10	11
89	1	10	11
90	1	10	11
91	1	10	11
92	1	10	11
93	1	10	11
94	1	10	11
95	1	10	11
96	1	10	11
97	1	10	11
98	1	10	11
99	1	10	11
100	1	10	11
\.


--
-- Data for Name: filmsAttributesType; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."filmsAttributesType" (id, "filmAttributesType") FROM stdin;
1	integer
2	time
3	date
4	text
5	boolean
\.


--
-- Data for Name: filmsAttributesValues; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."filmsAttributesValues" (id, "integerValue", "timeValue", "dateValue", "textValue", "booleanValue") FROM stdin;
1	0	\N	\N	Рецензия на фильм Game of Thrones	\N
2	0	\N	\N	Рецензия на фильм Terminator	\N
3	0	\N	\N	Премия Золотой Фуфел	\N
4	0	\N	\N	Премия Грязный ботинок	\N
5	0	\N	2019-02-01	\N	\N
7	0	12:01:00	\N	\N	\N
8	0	11:11:00	\N	\N	\N
6	0	\N	2019-07-11	\N	\N
9	0	\N	2019-12-11	\N	\N
10	0	\N	\N	Проверить зал №1	\N
11	0	\N	\N	Протереть 3D очки	\N
\.


--
-- Name: allfilms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.allfilms_id_seq', 1, false);


--
-- Name: cinemacustomer_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cinemacustomer_id_seq', 2, true);


--
-- Name: cinemahall_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cinemahall_id_seq', 67, true);


--
-- Name: cinemaseance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cinemaseance_id_seq', 1, false);


--
-- Name: filmattributestype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.filmattributestype_id_seq', 1, false);


--
-- Name: filmattributesvalues_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.filmattributesvalues_id_seq', 1, false);


--
-- Name: films_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.films_id_seq', 1, false);


--
-- Name: filmsattributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.filmsattributes_id_seq', 1, false);


--
-- Name: filmsattributeslist_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.filmsattributeslist_id_seq', 1, true);


--
-- Name: allFilms allFilms_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."allFilms"
    ADD CONSTRAINT "allFilms_pkey" PRIMARY KEY (id);


--
-- Name: cinemaCustomer cinemaCustomer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."cinemaCustomer"
    ADD CONSTRAINT "cinemaCustomer_pkey" PRIMARY KEY (id);


--
-- Name: cinemaHall cinemaHall_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."cinemaHall"
    ADD CONSTRAINT "cinemaHall_pkey" PRIMARY KEY (id);


--
-- Name: cinemaSeance cinemaSeance_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."cinemaSeance"
    ADD CONSTRAINT "cinemaSeance_pkey" PRIMARY KEY (id);


--
-- Name: filmsAttributesList filmsAttributesList_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."filmsAttributesList"
    ADD CONSTRAINT "filmsAttributesList_pkey" PRIMARY KEY (id);


--
-- Name: filmsAttributesType filmsAttributesType_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."filmsAttributesType"
    ADD CONSTRAINT "filmsAttributesType_pkey" PRIMARY KEY (id);


--
-- Name: filmsAttributesValues filmsAttributesValues_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."filmsAttributesValues"
    ADD CONSTRAINT "filmsAttributesValues_pkey" PRIMARY KEY (id);


--
-- Name: filmsAttributes filmsAttributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."filmsAttributes"
    ADD CONSTRAINT "filmsAttributes_pkey" PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

