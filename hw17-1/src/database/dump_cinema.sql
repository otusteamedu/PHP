--
-- PostgreSQL database dump
--

-- Dumped from database version 11.3
-- Dumped by pg_dump version 11.3

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

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: hall; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hall (
    hall_id integer NOT NULL,
    name character varying(50),
    size integer
);


ALTER TABLE public.hall OWNER TO postgres;

--
-- Name: hall_hall_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.hall_hall_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.hall_hall_id_seq OWNER TO postgres;

--
-- Name: hall_hall_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.hall_hall_id_seq OWNED BY public.hall.hall_id;


--
-- Name: movie; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movie (
    movie_id integer NOT NULL,
    name character varying(50)
);


ALTER TABLE public.movie OWNER TO postgres;

--
-- Name: movie_attribute; Type: TABLE; Schema: public; Owner: timofey
--

CREATE TABLE public.movie_attribute (
    attribute_id integer NOT NULL,
    attribute_name character varying(50),
    attribute_class_id integer,
    attribute_type_id integer
);


ALTER TABLE public.movie_attribute OWNER TO timofey;

--
-- Name: movie_attribute_attribute_id_seq; Type: SEQUENCE; Schema: public; Owner: timofey
--

CREATE SEQUENCE public.movie_attribute_attribute_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_attribute_attribute_id_seq OWNER TO timofey;

--
-- Name: movie_attribute_attribute_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: timofey
--

ALTER SEQUENCE public.movie_attribute_attribute_id_seq OWNED BY public.movie_attribute.attribute_id;


--
-- Name: movie_attribute_class; Type: TABLE; Schema: public; Owner: timofey
--

CREATE TABLE public.movie_attribute_class (
    attribute_class_id integer NOT NULL,
    attribute_class_name character varying(50)
);


ALTER TABLE public.movie_attribute_class OWNER TO timofey;

--
-- Name: movie_attribute_class_attribute_class_id_seq; Type: SEQUENCE; Schema: public; Owner: timofey
--

CREATE SEQUENCE public.movie_attribute_class_attribute_class_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_attribute_class_attribute_class_id_seq OWNER TO timofey;

--
-- Name: movie_attribute_class_attribute_class_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: timofey
--

ALTER SEQUENCE public.movie_attribute_class_attribute_class_id_seq OWNED BY public.movie_attribute_class.attribute_class_id;


--
-- Name: movie_attribute_type; Type: TABLE; Schema: public; Owner: timofey
--

CREATE TABLE public.movie_attribute_type (
    attribute_type_id integer NOT NULL,
    attribute_type_name character varying(50),
    attribute_type character varying(50)
);


ALTER TABLE public.movie_attribute_type OWNER TO timofey;

--
-- Name: movie_attribute_type_attribute_type_id_seq; Type: SEQUENCE; Schema: public; Owner: timofey
--

CREATE SEQUENCE public.movie_attribute_type_attribute_type_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_attribute_type_attribute_type_id_seq OWNER TO timofey;

--
-- Name: movie_attribute_type_attribute_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: timofey
--

ALTER SEQUENCE public.movie_attribute_type_attribute_type_id_seq OWNED BY public.movie_attribute_type.attribute_type_id;


--
-- Name: movie_attribute_value; Type: TABLE; Schema: public; Owner: timofey
--

CREATE TABLE public.movie_attribute_value (
    attribute_value_id integer NOT NULL,
    movie_id integer,
    attribute_id integer,
    text_value text,
    date_value timestamp without time zone,
    bool_value boolean,
    int_value integer
);


ALTER TABLE public.movie_attribute_value OWNER TO timofey;

--
-- Name: movie_attribute_value_attribute_value_id_seq; Type: SEQUENCE; Schema: public; Owner: timofey
--

CREATE SEQUENCE public.movie_attribute_value_attribute_value_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_attribute_value_attribute_value_id_seq OWNER TO timofey;

--
-- Name: movie_attribute_value_attribute_value_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: timofey
--

ALTER SEQUENCE public.movie_attribute_value_attribute_value_id_seq OWNED BY public.movie_attribute_value.attribute_value_id;


--
-- Name: movie_marketing_view; Type: VIEW; Schema: public; Owner: timofey
--

CREATE VIEW public.movie_marketing_view AS
 SELECT m.name,
    mac.attribute_class_name,
    ma.attribute_name,
        CASE mat.attribute_type
            WHEN 'text'::text THEN mav.text_value
            WHEN 'boolean'::text THEN (mav.bool_value)::text
            WHEN 'timestamp'::text THEN (mav.date_value)::text
            WHEN 'integer'::text THEN (mav.int_value)::text
            ELSE NULL::text
        END AS value
   FROM ((((public.movie m
     JOIN public.movie_attribute_value mav ON ((mav.movie_id = m.movie_id)))
     JOIN public.movie_attribute ma ON ((ma.attribute_id = mav.attribute_id)))
     JOIN public.movie_attribute_type mat ON ((mat.attribute_type_id = ma.attribute_type_id)))
     JOIN public.movie_attribute_class mac ON ((mac.attribute_class_id = ma.attribute_class_id)));


ALTER TABLE public.movie_marketing_view OWNER TO timofey;

--
-- Name: movie_movie_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.movie_movie_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_movie_id_seq OWNER TO postgres;

--
-- Name: movie_movie_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.movie_movie_id_seq OWNED BY public.movie.movie_id;


--
-- Name: movie_service_view; Type: VIEW; Schema: public; Owner: timofey
--

CREATE VIEW public.movie_service_view AS
 SELECT movie.name,
    today_tasks.attribute_name AS today_task,
    future_tasks.attribute_name AS future_task,
    future_tasks.date_value AS future_task_date
   FROM ((public.movie
     LEFT JOIN ( SELECT m.name,
            ma.attribute_name,
            mav.date_value
           FROM ((public.movie m
             JOIN public.movie_attribute_value mav ON ((mav.movie_id = m.movie_id)))
             JOIN public.movie_attribute ma ON ((ma.attribute_id = mav.attribute_id)))
          WHERE ((ma.attribute_class_id = 4) AND (mav.date_value = CURRENT_DATE))) today_tasks ON (((today_tasks.name)::text = (movie.name)::text)))
     LEFT JOIN ( SELECT m.name,
            ma.attribute_name,
            mav.date_value
           FROM ((public.movie m
             JOIN public.movie_attribute_value mav ON ((mav.movie_id = m.movie_id)))
             JOIN public.movie_attribute ma ON ((ma.attribute_id = mav.attribute_id)))
          WHERE ((ma.attribute_class_id = 4) AND ((mav.date_value >= (CURRENT_DATE + '1 day'::interval day)) AND (mav.date_value <= (CURRENT_DATE + '20 days'::interval day))))) future_tasks ON (((future_tasks.name)::text = (movie.name)::text)));


ALTER TABLE public.movie_service_view OWNER TO timofey;

--
-- Name: schedule; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.schedule (
    schedule_id integer NOT NULL,
    movie_id integer,
    begin_time timestamp without time zone,
    hall_id integer,
    price numeric
);


ALTER TABLE public.schedule OWNER TO postgres;

--
-- Name: schedule_schedule_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.schedule_schedule_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schedule_schedule_id_seq OWNER TO postgres;

--
-- Name: schedule_schedule_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.schedule_schedule_id_seq OWNED BY public.schedule.schedule_id;


--
-- Name: seat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seat (
    seat_id integer NOT NULL,
    hall_id integer,
    num integer,
    "row" integer
);


ALTER TABLE public.seat OWNER TO postgres;

--
-- Name: seat_seat_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seat_seat_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seat_seat_id_seq OWNER TO postgres;

--
-- Name: seat_seat_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.seat_seat_id_seq OWNED BY public.seat.seat_id;


--
-- Name: ticket; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ticket (
    ticket_id integer NOT NULL,
    ticket_status_id integer,
    schedule_id integer,
    seat_id integer
);


ALTER TABLE public.ticket OWNER TO postgres;

--
-- Name: ticket_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ticket_status (
    ticket_status_id integer NOT NULL,
    ticket_status character varying(50)
);


ALTER TABLE public.ticket_status OWNER TO postgres;

--
-- Name: ticket_ticket_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ticket_ticket_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ticket_ticket_id_seq OWNER TO postgres;

--
-- Name: ticket_ticket_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ticket_ticket_id_seq OWNED BY public.ticket.ticket_id;


--
-- Name: hall hall_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hall ALTER COLUMN hall_id SET DEFAULT nextval('public.hall_hall_id_seq'::regclass);


--
-- Name: movie movie_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie ALTER COLUMN movie_id SET DEFAULT nextval('public.movie_movie_id_seq'::regclass);


--
-- Name: movie_attribute attribute_id; Type: DEFAULT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute ALTER COLUMN attribute_id SET DEFAULT nextval('public.movie_attribute_attribute_id_seq'::regclass);


--
-- Name: movie_attribute_class attribute_class_id; Type: DEFAULT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute_class ALTER COLUMN attribute_class_id SET DEFAULT nextval('public.movie_attribute_class_attribute_class_id_seq'::regclass);


--
-- Name: movie_attribute_type attribute_type_id; Type: DEFAULT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute_type ALTER COLUMN attribute_type_id SET DEFAULT nextval('public.movie_attribute_type_attribute_type_id_seq'::regclass);


--
-- Name: movie_attribute_value attribute_value_id; Type: DEFAULT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute_value ALTER COLUMN attribute_value_id SET DEFAULT nextval('public.movie_attribute_value_attribute_value_id_seq'::regclass);


--
-- Name: schedule schedule_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schedule ALTER COLUMN schedule_id SET DEFAULT nextval('public.schedule_schedule_id_seq'::regclass);


--
-- Name: seat seat_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seat ALTER COLUMN seat_id SET DEFAULT nextval('public.seat_seat_id_seq'::regclass);


--
-- Name: ticket ticket_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket ALTER COLUMN ticket_id SET DEFAULT nextval('public.ticket_ticket_id_seq'::regclass);


--
-- Data for Name: hall; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hall (hall_id, name, size) FROM stdin;
1	Alpha	25
2	Beta	50
3	Gamma	100
\.


--
-- Data for Name: movie; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.movie (movie_id, name) FROM stdin;
6	Venom
7	Avengers
\.


--
-- Data for Name: movie_attribute; Type: TABLE DATA; Schema: public; Owner: timofey
--

COPY public.movie_attribute (attribute_id, attribute_name, attribute_class_id, attribute_type_id) FROM stdin;
1	Обзоры критиков	1	3
2	Обзоры зрителей	1	3
3	Оскар	2	2
4	Ника	2	2
5	Премьера в мире	3	1
6	Премьера в Росии	3	1
7	Старт продажи билетов	4	1
8	Старт рекламы	4	1
9	Продано билетов	5	4
\.


--
-- Data for Name: movie_attribute_class; Type: TABLE DATA; Schema: public; Owner: timofey
--

COPY public.movie_attribute_class (attribute_class_id, attribute_class_name) FROM stdin;
1	Обзоры
2	Премии
3	Важные даты
4	Служебные даты
5	Служебные показатели
\.


--
-- Data for Name: movie_attribute_type; Type: TABLE DATA; Schema: public; Owner: timofey
--

COPY public.movie_attribute_type (attribute_type_id, attribute_type_name, attribute_type) FROM stdin;
1	Date of event	timestamp
3	Review	text
2	Award	boolean
4	Counter	integer
\.


--
-- Data for Name: movie_attribute_value; Type: TABLE DATA; Schema: public; Owner: timofey
--

COPY public.movie_attribute_value (attribute_value_id, movie_id, attribute_id, text_value, date_value, bool_value, int_value) FROM stdin;
\.


--
-- Data for Name: schedule; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.schedule (schedule_id, movie_id, begin_time, hall_id, price) FROM stdin;
125	6	2019-08-16 10:00:00	1	150
126	6	2019-08-16 12:00:00	1	200
127	7	2019-08-16 10:00:00	2	150
128	7	2019-08-16 12:00:00	2	200
\.


--
-- Data for Name: seat; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seat (seat_id, hall_id, num, "row") FROM stdin;
1	1	1	1
2	1	2	1
3	1	3	1
4	1	4	1
5	1	5	1
6	1	1	2
7	1	2	2
8	1	3	2
9	1	4	2
10	1	5	2
11	1	1	3
12	1	2	3
13	1	3	3
14	1	4	3
15	1	5	3
16	1	1	4
17	1	2	4
18	1	3	4
19	1	4	4
20	1	5	4
21	1	1	5
22	1	2	5
23	1	3	5
24	1	4	5
25	1	5	5
26	2	1	1
27	2	2	1
28	2	3	1
29	2	4	1
30	2	5	1
31	2	1	2
32	2	2	2
33	2	3	2
34	2	4	2
35	2	5	2
36	2	1	3
37	2	2	3
38	2	3	3
39	2	4	3
40	2	5	3
41	2	1	4
42	2	2	4
43	2	3	4
44	2	4	4
45	2	5	4
46	2	1	5
47	2	2	5
48	2	3	5
49	2	4	5
50	2	5	5
51	2	1	6
52	2	2	6
53	2	3	6
54	2	4	6
55	2	5	6
56	2	1	7
57	2	2	7
58	2	3	7
59	2	4	7
60	2	5	7
61	2	1	8
62	2	2	8
63	2	3	8
64	2	4	8
65	2	5	8
66	2	1	9
67	2	2	9
68	2	3	9
69	2	4	9
70	2	5	9
71	2	1	10
72	2	2	10
73	2	3	10
74	2	4	10
75	2	5	10
76	3	1	1
77	3	2	1
78	3	3	1
79	3	4	1
80	3	5	1
81	3	6	1
82	3	7	1
83	3	8	1
84	3	9	1
85	3	10	1
86	3	1	2
87	3	2	2
88	3	3	2
89	3	4	2
90	3	5	2
91	3	6	2
92	3	7	2
93	3	8	2
94	3	9	2
95	3	10	2
96	3	1	3
97	3	2	3
98	3	3	3
99	3	4	3
100	3	5	3
101	3	6	3
102	3	7	3
103	3	8	3
104	3	9	3
105	3	10	3
106	3	1	4
107	3	2	4
108	3	3	4
109	3	4	4
110	3	5	4
111	3	6	4
112	3	7	4
113	3	8	4
114	3	9	4
115	3	10	4
116	3	1	5
117	3	2	5
118	3	3	5
119	3	4	5
120	3	5	5
121	3	6	5
122	3	7	5
123	3	8	5
124	3	9	5
125	3	10	5
126	3	1	6
127	3	2	6
128	3	3	6
129	3	4	6
130	3	5	6
131	3	6	6
132	3	7	6
133	3	8	6
134	3	9	6
135	3	10	6
136	3	1	7
137	3	2	7
138	3	3	7
139	3	4	7
140	3	5	7
141	3	6	7
142	3	7	7
143	3	8	7
144	3	9	7
145	3	10	7
146	3	1	8
147	3	2	8
148	3	3	8
149	3	4	8
150	3	5	8
151	3	6	8
152	3	7	8
153	3	8	8
154	3	9	8
155	3	10	8
156	3	1	9
157	3	2	9
158	3	3	9
159	3	4	9
160	3	5	9
161	3	6	9
162	3	7	9
163	3	8	9
164	3	9	9
165	3	10	9
166	3	1	10
167	3	2	10
168	3	3	10
169	3	4	10
170	3	5	10
171	3	6	10
172	3	7	10
173	3	8	10
174	3	9	10
175	3	10	10
\.


--
-- Data for Name: ticket; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ticket (ticket_id, ticket_status_id, schedule_id, seat_id) FROM stdin;
\.


--
-- Data for Name: ticket_status; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ticket_status (ticket_status_id, ticket_status) FROM stdin;
1	available
2	sold
\.


--
-- Name: hall_hall_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hall_hall_id_seq', 3, true);


--
-- Name: movie_attribute_attribute_id_seq; Type: SEQUENCE SET; Schema: public; Owner: timofey
--

SELECT pg_catalog.setval('public.movie_attribute_attribute_id_seq', 9, true);


--
-- Name: movie_attribute_class_attribute_class_id_seq; Type: SEQUENCE SET; Schema: public; Owner: timofey
--

SELECT pg_catalog.setval('public.movie_attribute_class_attribute_class_id_seq', 5, true);


--
-- Name: movie_attribute_type_attribute_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: timofey
--

SELECT pg_catalog.setval('public.movie_attribute_type_attribute_type_id_seq', 4, true);


--
-- Name: movie_attribute_value_attribute_value_id_seq; Type: SEQUENCE SET; Schema: public; Owner: timofey
--

SELECT pg_catalog.setval('public.movie_attribute_value_attribute_value_id_seq', 22, true);


--
-- Name: movie_movie_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.movie_movie_id_seq', 7, true);


--
-- Name: schedule_schedule_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.schedule_schedule_id_seq', 128, true);


--
-- Name: seat_seat_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seat_seat_id_seq', 175, true);


--
-- Name: ticket_ticket_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ticket_ticket_id_seq', 1, false);


--
-- Name: hall hall_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hall
    ADD CONSTRAINT hall_pkey PRIMARY KEY (hall_id);


--
-- Name: movie_attribute_class movie_attribute_class_pk; Type: CONSTRAINT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute_class
    ADD CONSTRAINT movie_attribute_class_pk PRIMARY KEY (attribute_class_id);


--
-- Name: movie_attribute movie_attribute_pkey; Type: CONSTRAINT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute
    ADD CONSTRAINT movie_attribute_pkey PRIMARY KEY (attribute_id);


--
-- Name: movie_attribute_type movie_attribute_type_pkey; Type: CONSTRAINT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute_type
    ADD CONSTRAINT movie_attribute_type_pkey PRIMARY KEY (attribute_type_id);


--
-- Name: movie_attribute_value movie_attribute_value_pkey; Type: CONSTRAINT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute_value
    ADD CONSTRAINT movie_attribute_value_pkey PRIMARY KEY (attribute_value_id);


--
-- Name: movie movie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie
    ADD CONSTRAINT movie_pkey PRIMARY KEY (movie_id);


--
-- Name: schedule schedule_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schedule
    ADD CONSTRAINT schedule_pkey PRIMARY KEY (schedule_id);


--
-- Name: seat seat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seat
    ADD CONSTRAINT seat_pkey PRIMARY KEY (seat_id);


--
-- Name: ticket ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_pkey PRIMARY KEY (ticket_id);


--
-- Name: ticket_status ticket_status_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket_status
    ADD CONSTRAINT ticket_status_pkey PRIMARY KEY (ticket_status_id);


--
-- Name: movie_name_first_letter_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX movie_name_first_letter_idx ON public.movie USING btree ("left"((name)::text, 1));


--
-- Name: movie_name_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX movie_name_idx ON public.movie USING btree (name);


--
-- Name: schedule_begin_time_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX schedule_begin_time_idx ON public.schedule USING btree (begin_time);


--
-- Name: schedule_movie_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX schedule_movie_id_idx ON public.schedule USING btree (movie_id);


--
-- Name: ticket_schedule_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ticket_schedule_id_idx ON public.ticket USING btree (schedule_id);


--
-- Name: ticket_seat_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ticket_seat_id_idx ON public.ticket USING btree (seat_id, ticket_status_id);


--
-- Name: movie_attribute fk_movie_attribute-movie_attribute_class-attribute_class_id; Type: FK CONSTRAINT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute
    ADD CONSTRAINT "fk_movie_attribute-movie_attribute_class-attribute_class_id" FOREIGN KEY (attribute_type_id) REFERENCES public.movie_attribute_type(attribute_type_id);


--
-- Name: movie_attribute fk_movie_attribute-movie_attribute_type-attribute_type_id; Type: FK CONSTRAINT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute
    ADD CONSTRAINT "fk_movie_attribute-movie_attribute_type-attribute_type_id" FOREIGN KEY (attribute_class_id) REFERENCES public.movie_attribute_class(attribute_class_id);


--
-- Name: movie_attribute_value fk_movie_attribute_value-movie-movie_id; Type: FK CONSTRAINT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute_value
    ADD CONSTRAINT "fk_movie_attribute_value-movie-movie_id" FOREIGN KEY (movie_id) REFERENCES public.movie(movie_id);


--
-- Name: movie_attribute_value fk_movie_attribute_value-movie_attribute-attribute_id; Type: FK CONSTRAINT; Schema: public; Owner: timofey
--

ALTER TABLE ONLY public.movie_attribute_value
    ADD CONSTRAINT "fk_movie_attribute_value-movie_attribute-attribute_id" FOREIGN KEY (attribute_id) REFERENCES public.movie_attribute(attribute_id);


--
-- Name: schedule fk_schedule-hall-hall_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schedule
    ADD CONSTRAINT "fk_schedule-hall-hall_id" FOREIGN KEY (hall_id) REFERENCES public.hall(hall_id);


--
-- Name: schedule fk_schedule-movie-movie_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schedule
    ADD CONSTRAINT "fk_schedule-movie-movie_id" FOREIGN KEY (movie_id) REFERENCES public.movie(movie_id);


--
-- Name: seat fk_seat-hall-hall_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seat
    ADD CONSTRAINT "fk_seat-hall-hall_id" FOREIGN KEY (hall_id) REFERENCES public.hall(hall_id);


--
-- Name: ticket fk_ticket-schedule-schedule_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT "fk_ticket-schedule-schedule_id" FOREIGN KEY (schedule_id) REFERENCES public.schedule(schedule_id);


--
-- Name: ticket fk_ticket-seat-seat_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT "fk_ticket-seat-seat_id" FOREIGN KEY (seat_id) REFERENCES public.seat(seat_id);


--
-- Name: ticket fk_ticket-ticket_status-ticket_status_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT "fk_ticket-ticket_status-ticket_status_id" FOREIGN KEY (ticket_status_id) REFERENCES public.ticket_status(ticket_status_id);


--
-- Name: TABLE hall; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON TABLE public.hall TO readonly;


--
-- Name: SEQUENCE hall_hall_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON SEQUENCE public.hall_hall_id_seq TO readonly;


--
-- Name: TABLE movie; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON TABLE public.movie TO readonly;


--
-- Name: SEQUENCE movie_movie_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON SEQUENCE public.movie_movie_id_seq TO readonly;


--
-- Name: TABLE schedule; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON TABLE public.schedule TO readonly;


--
-- Name: SEQUENCE schedule_schedule_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON SEQUENCE public.schedule_schedule_id_seq TO readonly;


--
-- Name: TABLE seat; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON TABLE public.seat TO readonly;


--
-- Name: SEQUENCE seat_seat_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON SEQUENCE public.seat_seat_id_seq TO readonly;


--
-- Name: TABLE ticket; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON TABLE public.ticket TO readonly;


--
-- Name: TABLE ticket_status; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON TABLE public.ticket_status TO readonly;


--
-- Name: SEQUENCE ticket_ticket_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT ON SEQUENCE public.ticket_ticket_id_seq TO readonly;


--
-- PostgreSQL database dump complete
--

