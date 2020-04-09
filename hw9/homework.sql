--
-- PostgreSQL database dump
--

-- Dumped from database version 12.2 (Debian 12.2-2.pgdg100+1)
-- Dumped by pg_dump version 12.2 (Debian 12.2-2.pgdg100+1)

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
-- Name: homework; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA homework;


ALTER SCHEMA homework OWNER TO postgres;

--
-- Name: string_agg_transfn(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.string_agg_transfn(text, text) RETURNS text
    LANGUAGE plpgsql IMMUTABLE COST 1
    AS $_$
        BEGIN
            IF $1 IS NULL THEN
                RETURN $2;
            ELSE
                RETURN $1 || $2;
            END IF;
        END;
    $_$;


ALTER FUNCTION public.string_agg_transfn(text, text) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cinemas; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.cinemas (
    id bigint NOT NULL,
    title character(255) NOT NULL
);


ALTER TABLE homework.cinemas OWNER TO postgres;

--
-- Name: cinemas_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.cinemas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.cinemas_id_seq OWNER TO postgres;

--
-- Name: cinemas_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.cinemas_id_seq OWNED BY homework.cinemas.id;


--
-- Name: client; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.client (
    id bigint NOT NULL,
    first_name character(255) NOT NULL,
    last_name character(255) NOT NULL
);


ALTER TABLE homework.client OWNER TO postgres;

--
-- Name: client_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.client_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.client_id_seq OWNER TO postgres;

--
-- Name: client_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.client_id_seq OWNED BY homework.client.id;


--
-- Name: halls; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.halls (
    id bigint NOT NULL,
    title character(255) NOT NULL,
    cinema_id bigint NOT NULL
);


ALTER TABLE homework.halls OWNER TO postgres;

--
-- Name: halls_cinema_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.halls_cinema_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.halls_cinema_id_seq OWNER TO postgres;

--
-- Name: halls_cinema_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.halls_cinema_id_seq OWNED BY homework.halls.cinema_id;


--
-- Name: halls_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.halls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.halls_id_seq OWNER TO postgres;

--
-- Name: halls_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.halls_id_seq OWNED BY homework.halls.id;


--
-- Name: movies; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.movies (
    id bigint NOT NULL,
    title character(255) NOT NULL,
    cost numeric NOT NULL
);


ALTER TABLE homework.movies OWNER TO postgres;

--
-- Name: movies_attributes; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.movies_attributes (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    type integer NOT NULL
);


ALTER TABLE homework.movies_attributes OWNER TO postgres;

--
-- Name: movies_attributes_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.movies_attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.movies_attributes_id_seq OWNER TO postgres;

--
-- Name: movies_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.movies_attributes_id_seq OWNED BY homework.movies_attributes.id;


--
-- Name: movies_attributes_types; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.movies_attributes_types (
    id integer NOT NULL,
    title character(255) NOT NULL
);


ALTER TABLE homework.movies_attributes_types OWNER TO postgres;

--
-- Name: movies_attributes_types_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.movies_attributes_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.movies_attributes_types_id_seq OWNER TO postgres;

--
-- Name: movies_attributes_types_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.movies_attributes_types_id_seq OWNED BY homework.movies_attributes_types.id;


--
-- Name: movies_attributes_values; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.movies_attributes_values (
    id bigint NOT NULL,
    movie_attribute_id bigint NOT NULL,
    movie_id bigint NOT NULL,
    val_bool smallint,
    val_text text,
    val_integer integer,
    val_real real,
    val_date date
);


ALTER TABLE homework.movies_attributes_values OWNER TO postgres;

--
-- Name: movies_attributes_values_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.movies_attributes_values_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.movies_attributes_values_id_seq OWNER TO postgres;

--
-- Name: movies_attributes_values_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.movies_attributes_values_id_seq OWNED BY homework.movies_attributes_values.id;


--
-- Name: movies_attributes_values_movie_attribute_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.movies_attributes_values_movie_attribute_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.movies_attributes_values_movie_attribute_id_seq OWNER TO postgres;

--
-- Name: movies_attributes_values_movie_attribute_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.movies_attributes_values_movie_attribute_id_seq OWNED BY homework.movies_attributes_values.movie_attribute_id;


--
-- Name: movies_attributes_values_movie_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.movies_attributes_values_movie_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.movies_attributes_values_movie_id_seq OWNER TO postgres;

--
-- Name: movies_attributes_values_movie_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.movies_attributes_values_movie_id_seq OWNED BY homework.movies_attributes_values.movie_id;


--
-- Name: movies_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.movies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.movies_id_seq OWNER TO postgres;

--
-- Name: movies_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.movies_id_seq OWNED BY homework.movies.id;


--
-- Name: seats_hall; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.seats_hall (
    id bigint NOT NULL,
    hall_id bigint NOT NULL,
    series character(255) NOT NULL,
    number bigint NOT NULL
);


ALTER TABLE homework.seats_hall OWNER TO postgres;

--
-- Name: seats_hall_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.seats_hall_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.seats_hall_id_seq OWNER TO postgres;

--
-- Name: seats_hall_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.seats_hall_id_seq OWNED BY homework.seats_hall.id;


--
-- Name: sessions; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.sessions (
    id bigint NOT NULL,
    title character(255) NOT NULL,
    movie_id bigint NOT NULL,
    hall_id bigint NOT NULL
);


ALTER TABLE homework.sessions OWNER TO postgres;

--
-- Name: sessions_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.sessions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.sessions_id_seq OWNER TO postgres;

--
-- Name: sessions_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.sessions_id_seq OWNED BY homework.sessions.id;


--
-- Name: tickets; Type: TABLE; Schema: homework; Owner: postgres
--

CREATE TABLE homework.tickets (
    id bigint NOT NULL,
    session_id bigint NOT NULL,
    client_id bigint NOT NULL,
    seat_hall_id bigint NOT NULL,
    cost numeric NOT NULL
);


ALTER TABLE homework.tickets OWNER TO postgres;

--
-- Name: tickets_id_seq; Type: SEQUENCE; Schema: homework; Owner: postgres
--

CREATE SEQUENCE homework.tickets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homework.tickets_id_seq OWNER TO postgres;

--
-- Name: tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: homework; Owner: postgres
--

ALTER SEQUENCE homework.tickets_id_seq OWNED BY homework.tickets.id;


--
-- Name: view_business_data; Type: VIEW; Schema: homework; Owner: postgres
--

CREATE VIEW homework.view_business_data AS
SELECT
    NULL::character(255) AS "фильм",
    NULL::text AS "Задачи на сегодня",
    NULL::text AS "Задачи через 20 дней";


ALTER TABLE homework.view_business_data OWNER TO postgres;

--
-- Name: view_marketing; Type: VIEW; Schema: homework; Owner: postgres
--

CREATE VIEW homework.view_marketing WITH (security_barrier='false') AS
 SELECT movies.title AS "Фильм",
    movies_attributes_types.title AS "тип атрибута",
    movies_attributes.title AS "атрибут",
        CASE
            WHEN (movies_attributes_types.id = 1) THEN (movies_attributes_values.val_bool)::text
            WHEN (movies_attributes_types.id = 2) THEN movies_attributes_values.val_text
            WHEN (movies_attributes_types.id = 6) THEN (movies_attributes_values.val_real)::text
            WHEN (movies_attributes_types.id = 5) THEN (movies_attributes_values.val_integer)::text
            WHEN (movies_attributes_types.id = ANY (ARRAY[7, 8, 9])) THEN (movies_attributes_values.val_date)::text
            ELSE NULL::text
        END AS "значение"
   FROM (((homework.movies
     LEFT JOIN homework.movies_attributes_values ON ((movies.id = movies_attributes_values.movie_id)))
     LEFT JOIN homework.movies_attributes ON ((movies_attributes_values.movie_attribute_id = movies_attributes.id)))
     LEFT JOIN homework.movies_attributes_types ON ((movies_attributes.type = movies_attributes_types.id)))
  WHERE (movies_attributes_values.id IS NOT NULL);


ALTER TABLE homework.view_marketing OWNER TO postgres;

--
-- Name: cinemas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cinemas (
    id bigint NOT NULL,
    title character(255) NOT NULL
);


ALTER TABLE public.cinemas OWNER TO postgres;

--
-- Name: cinemas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cinemas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cinemas_id_seq OWNER TO postgres;

--
-- Name: cinemas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cinemas_id_seq OWNED BY public.cinemas.id;


--
-- Name: cinemas id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.cinemas ALTER COLUMN id SET DEFAULT nextval('homework.cinemas_id_seq'::regclass);


--
-- Name: client id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.client ALTER COLUMN id SET DEFAULT nextval('homework.client_id_seq'::regclass);


--
-- Name: halls id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.halls ALTER COLUMN id SET DEFAULT nextval('homework.halls_id_seq'::regclass);


--
-- Name: halls cinema_id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.halls ALTER COLUMN cinema_id SET DEFAULT nextval('homework.halls_cinema_id_seq'::regclass);


--
-- Name: movies id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies ALTER COLUMN id SET DEFAULT nextval('homework.movies_id_seq'::regclass);


--
-- Name: movies_attributes id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes ALTER COLUMN id SET DEFAULT nextval('homework.movies_attributes_id_seq'::regclass);


--
-- Name: movies_attributes_types id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes_types ALTER COLUMN id SET DEFAULT nextval('homework.movies_attributes_types_id_seq'::regclass);


--
-- Name: movies_attributes_values id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes_values ALTER COLUMN id SET DEFAULT nextval('homework.movies_attributes_values_id_seq'::regclass);


--
-- Name: movies_attributes_values movie_attribute_id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes_values ALTER COLUMN movie_attribute_id SET DEFAULT nextval('homework.movies_attributes_values_movie_attribute_id_seq'::regclass);


--
-- Name: movies_attributes_values movie_id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes_values ALTER COLUMN movie_id SET DEFAULT nextval('homework.movies_attributes_values_movie_id_seq'::regclass);


--
-- Name: seats_hall id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.seats_hall ALTER COLUMN id SET DEFAULT nextval('homework.seats_hall_id_seq'::regclass);


--
-- Name: sessions id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.sessions ALTER COLUMN id SET DEFAULT nextval('homework.sessions_id_seq'::regclass);


--
-- Name: tickets id; Type: DEFAULT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.tickets ALTER COLUMN id SET DEFAULT nextval('homework.tickets_id_seq'::regclass);


--
-- Name: cinemas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinemas ALTER COLUMN id SET DEFAULT nextval('public.cinemas_id_seq'::regclass);


--
-- Data for Name: cinemas; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.cinemas (id, title) FROM stdin;
1	Кинотеатр 1                                                                                                                                                                                                                                                    
\.


--
-- Data for Name: client; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.client (id, first_name, last_name) FROM stdin;
1	Иван                                                                                                                                                                                                                                                           	Иванов                                                                                                                                                                                                                                                         
2	Андрей                                                                                                                                                                                                                                                         	Иванов                                                                                                                                                                                                                                                         
\.


--
-- Data for Name: halls; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.halls (id, title, cinema_id) FROM stdin;
10	Зал 1                                                                                                                                                                                                                                                          	1
11	Зал 2                                                                                                                                                                                                                                                          	1
\.


--
-- Data for Name: movies; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.movies (id, title, cost) FROM stdin;
1	Фильм 1                                                                                                                                                                                                                                                        	2000
2	Фильм 2                                                                                                                                                                                                                                                        	3000
3	Аватар                                                                                                                                                                                                                                                         	2500
4	Аватар 2                                                                                                                                                                                                                                                       	4000
5	Викинги                                                                                                                                                                                                                                                        	4000
\.


--
-- Data for Name: movies_attributes; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.movies_attributes (id, title, type) FROM stdin;
1	рецензии	2
2	премия	1
5	дата начала продажи билетов	9
6	когда запускать рекламу на ТВ	9
7	мировая премьера	8
8	премьера в РФ	8
9	Стоимость	5
10	средний процент интереса	6
\.


--
-- Data for Name: movies_attributes_types; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.movies_attributes_types (id, title) FROM stdin;
1	Логическое                                                                                                                                                                                                                                                     
2	Текстовое                                                                                                                                                                                                                                                      
5	Целое число                                                                                                                                                                                                                                                    
7	Дата                                                                                                                                                                                                                                                           
8	Важные даты                                                                                                                                                                                                                                                    
9	Служебные даты                                                                                                                                                                                                                                                 
6	Вещественное число                                                                                                                                                                                                                                             
\.


--
-- Data for Name: movies_attributes_values; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.movies_attributes_values (id, movie_attribute_id, movie_id, val_bool, val_text, val_integer, val_real, val_date) FROM stdin;
1	1	1	\N	Отзыв 1	\N	\N	\N
2	1	1	\N	Отзыв 2	\N	\N	\N
3	1	1	\N	Отзыв 3	\N	\N	\N
4	5	1	\N	\N	\N	\N	2020-04-08
5	6	1	\N	\N	\N	\N	2020-04-08
6	7	1	\N	\N	\N	\N	2020-04-20
7	8	1	\N	\N	\N	\N	2020-04-30
8	5	2	\N	\N	\N	\N	2020-04-28
9	6	2	\N	\N	\N	\N	2020-04-28
10	5	1	\N	\N	\N	\N	2020-04-08
11	5	1	\N	\N	\N	\N	2020-04-28
12	2	1	1	\N	\N	\N	\N
13	9	1	\N	\N	2000000	\N	\N
14	10	1	\N	\N	\N	50.5	\N
\.


--
-- Data for Name: seats_hall; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.seats_hall (id, hall_id, series, number) FROM stdin;
1	10	1                                                                                                                                                                                                                                                              	1
2	10	1                                                                                                                                                                                                                                                              	2
3	10	1                                                                                                                                                                                                                                                              	3
4	11	1                                                                                                                                                                                                                                                              	1
5	11	1                                                                                                                                                                                                                                                              	2
6	11	1                                                                                                                                                                                                                                                              	3
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.sessions (id, title, movie_id, hall_id) FROM stdin;
1	19:00-20:00                                                                                                                                                                                                                                                    	1	10
3	19:00-20:00                                                                                                                                                                                                                                                    	2	11
4	20:00-21:00                                                                                                                                                                                                                                                    	1	11
2	20:00-21:00                                                                                                                                                                                                                                                    	2	11
\.


--
-- Data for Name: tickets; Type: TABLE DATA; Schema: homework; Owner: postgres
--

COPY homework.tickets (id, session_id, client_id, seat_hall_id, cost) FROM stdin;
1	1	1	1	2000
2	2	1	1	3000
3	1	2	2	2000
4	2	2	3	3000
\.


--
-- Data for Name: cinemas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cinemas (id, title) FROM stdin;
\.


--
-- Name: cinemas_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.cinemas_id_seq', 1, true);


--
-- Name: client_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.client_id_seq', 2, true);


--
-- Name: halls_cinema_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.halls_cinema_id_seq', 1, false);


--
-- Name: halls_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.halls_id_seq', 11, true);


--
-- Name: movies_attributes_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.movies_attributes_id_seq', 8, true);


--
-- Name: movies_attributes_types_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.movies_attributes_types_id_seq', 9, true);


--
-- Name: movies_attributes_values_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.movies_attributes_values_id_seq', 11, true);


--
-- Name: movies_attributes_values_movie_attribute_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.movies_attributes_values_movie_attribute_id_seq', 1, false);


--
-- Name: movies_attributes_values_movie_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.movies_attributes_values_movie_id_seq', 1, false);


--
-- Name: movies_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.movies_id_seq', 5, true);


--
-- Name: seats_hall_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.seats_hall_id_seq', 6, true);


--
-- Name: sessions_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.sessions_id_seq', 4, true);


--
-- Name: tickets_id_seq; Type: SEQUENCE SET; Schema: homework; Owner: postgres
--

SELECT pg_catalog.setval('homework.tickets_id_seq', 4, true);


--
-- Name: cinemas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cinemas_id_seq', 1, false);


--
-- Name: cinemas cinemas_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.cinemas
    ADD CONSTRAINT cinemas_pkey PRIMARY KEY (id);


--
-- Name: client client_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id);


--
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (id);


--
-- Name: movies_attributes movies_attributes_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes
    ADD CONSTRAINT movies_attributes_pkey PRIMARY KEY (id);


--
-- Name: movies_attributes_types movies_attributes_types_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes_types
    ADD CONSTRAINT movies_attributes_types_pkey PRIMARY KEY (id);


--
-- Name: movies_attributes_values movies_attributes_values_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes_values
    ADD CONSTRAINT movies_attributes_values_pkey PRIMARY KEY (id);


--
-- Name: movies movies_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies
    ADD CONSTRAINT movies_pkey PRIMARY KEY (id);


--
-- Name: seats_hall seats_hall_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.seats_hall
    ADD CONSTRAINT seats_hall_pkey PRIMARY KEY (id);


--
-- Name: seats_hall seats_hall_series_number_hall_id_key; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.seats_hall
    ADD CONSTRAINT seats_hall_series_number_hall_id_key UNIQUE (series, number, hall_id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: tickets tickets_pkey; Type: CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.tickets
    ADD CONSTRAINT tickets_pkey PRIMARY KEY (id);


--
-- Name: cinemas cinemas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cinemas
    ADD CONSTRAINT cinemas_pkey PRIMARY KEY (id);


--
-- Name: view_business_data _RETURN; Type: RULE; Schema: homework; Owner: postgres
--

CREATE OR REPLACE VIEW homework.view_business_data AS
 SELECT movies.title AS "фильм",
    string_agg((
        CASE
            WHEN (movies_attributes_values.val_date = (now())::date) THEN movies_attributes.title
            ELSE NULL::character varying
        END)::text, '; '::text) AS "Задачи на сегодня",
    string_agg((
        CASE
            WHEN (movies_attributes_values.val_date = ((now() + '20 days'::interval))::date) THEN movies_attributes.title
            ELSE NULL::character varying
        END)::text, '; '::text) AS "Задачи через 20 дней"
   FROM (((homework.movies
     LEFT JOIN homework.movies_attributes_values ON ((movies.id = movies_attributes_values.movie_id)))
     LEFT JOIN homework.movies_attributes ON ((movies_attributes_values.movie_attribute_id = movies_attributes.id)))
     LEFT JOIN homework.movies_attributes_types ON ((movies_attributes.type = movies_attributes_types.id)))
  WHERE (movies_attributes_types.id = 9)
  GROUP BY movies.id;


--
-- Name: seats_hall fx-seats_hall-halls; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.seats_hall
    ADD CONSTRAINT "fx-seats_hall-halls" FOREIGN KEY (hall_id) REFERENCES homework.halls(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: halls halls_cinema_id_fkey; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.halls
    ADD CONSTRAINT halls_cinema_id_fkey FOREIGN KEY (cinema_id) REFERENCES homework.cinemas(id) NOT VALID;


--
-- Name: movies_attributes movies_attributes_type_fkey; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes
    ADD CONSTRAINT movies_attributes_type_fkey FOREIGN KEY (type) REFERENCES homework.movies_attributes_types(id) NOT VALID;


--
-- Name: movies_attributes_values movies_attributes_values_movie_attribute_id_fkey; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes_values
    ADD CONSTRAINT movies_attributes_values_movie_attribute_id_fkey FOREIGN KEY (movie_attribute_id) REFERENCES homework.movies_attributes(id);


--
-- Name: movies_attributes_values movies_attributes_values_movie_id_fkey; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.movies_attributes_values
    ADD CONSTRAINT movies_attributes_values_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES homework.movies(id);


--
-- Name: sessions sessions_hall_id_fkey; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.sessions
    ADD CONSTRAINT sessions_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES homework.halls(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sessions sessions_movie_id_fkey; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.sessions
    ADD CONSTRAINT sessions_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES homework.movies(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: tickets tickets_client_id_fkey; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.tickets
    ADD CONSTRAINT tickets_client_id_fkey FOREIGN KEY (client_id) REFERENCES homework.client(id);


--
-- Name: tickets tickets_seat_hall_id_fkey; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.tickets
    ADD CONSTRAINT tickets_seat_hall_id_fkey FOREIGN KEY (seat_hall_id) REFERENCES homework.seats_hall(id);


--
-- Name: tickets tickets_session_id_fkey; Type: FK CONSTRAINT; Schema: homework; Owner: postgres
--

ALTER TABLE ONLY homework.tickets
    ADD CONSTRAINT tickets_session_id_fkey FOREIGN KEY (session_id) REFERENCES homework.sessions(id);


--
-- PostgreSQL database dump complete
--

