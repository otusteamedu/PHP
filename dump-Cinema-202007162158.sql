--
-- PostgreSQL database dump
--

-- Dumped from database version 12.3 (Ubuntu 12.3-1.pgdg20.04+1)
-- Dumped by pg_dump version 12.2 (Ubuntu 12.2-4)

-- Started on 2020-07-16 21:58:11 MSK

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

SET default_table_access_method = heap;

--
-- TOC entry 211 (class 1259 OID 24630)
-- Name: actor_types; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.actor_types (
    id smallint NOT NULL,
    type_name character varying(255)
);


ALTER TABLE public.actor_types OWNER TO aleksei;

--
-- TOC entry 213 (class 1259 OID 24638)
-- Name: actor_types_added; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.actor_types_added (
    id integer NOT NULL,
    actor_type_id smallint,
    actor_id integer
);


ALTER TABLE public.actor_types_added OWNER TO aleksei;

--
-- TOC entry 212 (class 1259 OID 24636)
-- Name: actor_types_added_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.actor_types_added_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.actor_types_added_id_seq OWNER TO aleksei;

--
-- TOC entry 3189 (class 0 OID 0)
-- Dependencies: 212
-- Name: actor_types_added_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.actor_types_added_id_seq OWNED BY public.actor_types_added.id;


--
-- TOC entry 210 (class 1259 OID 24628)
-- Name: actor_types_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.actor_types_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.actor_types_id_seq OWNER TO aleksei;

--
-- TOC entry 3190 (class 0 OID 0)
-- Dependencies: 210
-- Name: actor_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.actor_types_id_seq OWNED BY public.actor_types.id;


--
-- TOC entry 218 (class 1259 OID 24689)
-- Name: countries; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.countries (
    id integer NOT NULL,
    ru_name character varying(255),
    en_name character varying(255)
);


ALTER TABLE public.countries OWNER TO aleksei;

--
-- TOC entry 220 (class 1259 OID 24700)
-- Name: countries_added; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.countries_added (
    id integer NOT NULL,
    movie_id integer,
    country_id integer
);


ALTER TABLE public.countries_added OWNER TO aleksei;

--
-- TOC entry 219 (class 1259 OID 24698)
-- Name: countries_added_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.countries_added_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.countries_added_id_seq OWNER TO aleksei;

--
-- TOC entry 3191 (class 0 OID 0)
-- Dependencies: 219
-- Name: countries_added_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.countries_added_id_seq OWNED BY public.countries_added.id;


--
-- TOC entry 217 (class 1259 OID 24687)
-- Name: countries_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.countries_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.countries_id_seq OWNER TO aleksei;

--
-- TOC entry 3192 (class 0 OID 0)
-- Dependencies: 217
-- Name: countries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.countries_id_seq OWNED BY public.countries.id;


--
-- TOC entry 240 (class 1259 OID 24858)
-- Name: movie_attribute_values; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.movie_attribute_values (
    id smallint NOT NULL,
    movie_attribute_id smallint,
    movie_id integer,
    value character varying
);


ALTER TABLE public.movie_attribute_values OWNER TO aleksei;

--
-- TOC entry 234 (class 1259 OID 24811)
-- Name: movie_attributes; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.movie_attributes (
    id smallint NOT NULL,
    name character varying(255),
    movie_attribute_group_id smallint
);


ALTER TABLE public.movie_attributes OWNER TO aleksei;

--
-- TOC entry 238 (class 1259 OID 24840)
-- Name: movie_attributes_groups; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.movie_attributes_groups (
    id smallint NOT NULL,
    name character varying(255),
    movie_attribute_type_id smallint
);


ALTER TABLE public.movie_attributes_groups OWNER TO aleksei;

--
-- TOC entry 236 (class 1259 OID 24824)
-- Name: movie_attributes_types; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.movie_attributes_types (
    id smallint NOT NULL,
    type character varying(255)
);


ALTER TABLE public.movie_attributes_types OWNER TO aleksei;

--
-- TOC entry 241 (class 1259 OID 24877)
-- Name: film_attributes_view; Type: VIEW; Schema: public; Owner: aleksei
--

CREATE VIEW public.film_attributes_view AS
 SELECT m.name AS movie_name,
    v.value AS attr_value,
    a.name AS attr_name,
    g.name AS group_name,
    t.type AS attr_type
   FROM ((((public.movies m
     LEFT JOIN public.movie_attribute_values v ON ((v.movie_id = m.id)))
     LEFT JOIN public.movie_attributes a ON ((a.id = v.movie_attribute_id)))
     LEFT JOIN public.movie_attributes_groups g ON ((g.id = a.movie_attribute_group_id)))
     LEFT JOIN public.movie_attributes_types t ON ((g.movie_attribute_type_id = t.id)));


ALTER TABLE public.film_attributes_view OWNER TO aleksei;

--
-- TOC entry 243 (class 1259 OID 32831)
-- Name: film_imp_dates_view; Type: VIEW; Schema: public; Owner: aleksei
--

CREATE VIEW public.film_imp_dates_view AS
 SELECT movies.name AS movie_name,
    today.name AS today_task,
    future.name AS future_task,
    (v.value)::timestamp without time zone AS tms
   FROM (((public.movie_attribute_values v
     LEFT JOIN public.movie_attributes today ON (((v.movie_attribute_id = today.id) AND ((v.value)::text >= ((now())::character varying)::text) AND ((v.value)::text <= (((now() + '1 day'::interval))::character varying)::text))))
     LEFT JOIN public.movie_attributes future ON (((v.movie_attribute_id = future.id) AND ((v.value)::text >= ((now())::character varying)::text) AND ((v.value)::text >= (((now() + '20 days'::interval))::character varying)::text))))
     LEFT JOIN public.movies ON ((v.movie_id = movies.id)))
  WHERE ((today.movie_attribute_group_id = 2) OR (future.movie_attribute_group_id = 2));


ALTER TABLE public.film_imp_dates_view OWNER TO aleksei;

--
-- TOC entry 242 (class 1259 OID 32770)
-- Name: film_marketing_dates; Type: VIEW; Schema: public; Owner: aleksei
--

CREATE VIEW public.film_marketing_dates AS
 SELECT movies.name AS movie_name,
    t.type AS attr_type,
    a.name AS today_task,
    v.value AS attr_value
   FROM ((((public.movie_attribute_values v
     LEFT JOIN public.movies ON ((movies.id = v.movie_id)))
     LEFT JOIN public.movie_attributes a ON ((a.id = v.movie_attribute_id)))
     LEFT JOIN public.movie_attributes_groups g ON ((g.id = a.movie_attribute_group_id)))
     LEFT JOIN public.movie_attributes_types t ON ((t.id = g.movie_attribute_type_id)))
  WHERE ((a.movie_attribute_group_id = 1) AND (((v.value)::text >= ((now())::character varying)::text) AND ((v.value)::text <= (((now() + '1 day'::interval))::character varying)::text)));


ALTER TABLE public.film_marketing_dates OWNER TO aleksei;

--
-- TOC entry 205 (class 1259 OID 24593)
-- Name: genres; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.genres (
    id smallint NOT NULL,
    name character varying(255)
);


ALTER TABLE public.genres OWNER TO aleksei;

--
-- TOC entry 207 (class 1259 OID 24601)
-- Name: genres_added; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.genres_added (
    id integer NOT NULL,
    movie_id integer,
    genre_id smallint
);


ALTER TABLE public.genres_added OWNER TO aleksei;

--
-- TOC entry 206 (class 1259 OID 24599)
-- Name: genres_added_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.genres_added_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.genres_added_id_seq OWNER TO aleksei;

--
-- TOC entry 3193 (class 0 OID 0)
-- Dependencies: 206
-- Name: genres_added_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.genres_added_id_seq OWNED BY public.genres_added.id;


--
-- TOC entry 204 (class 1259 OID 24591)
-- Name: genres_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.genres_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.genres_id_seq OWNER TO aleksei;

--
-- TOC entry 3194 (class 0 OID 0)
-- Dependencies: 204
-- Name: genres_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.genres_id_seq OWNED BY public.genres.id;


--
-- TOC entry 222 (class 1259 OID 24718)
-- Name: halls; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.halls (
    id integer NOT NULL,
    number smallint,
    name character varying(255),
    space smallint
);


ALTER TABLE public.halls OWNER TO aleksei;

--
-- TOC entry 221 (class 1259 OID 24716)
-- Name: halls_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.halls_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.halls_id_seq OWNER TO aleksei;

--
-- TOC entry 3195 (class 0 OID 0)
-- Dependencies: 221
-- Name: halls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.halls_id_seq OWNED BY public.halls.id;


--
-- TOC entry 244 (class 1259 OID 41030)
-- Name: hello; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.hello (
    film_name character varying(100)
);


ALTER TABLE public.hello OWNER TO aleksei;

--
-- TOC entry 239 (class 1259 OID 24856)
-- Name: movie_attribute_values_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.movie_attribute_values_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_attribute_values_id_seq OWNER TO aleksei;

--
-- TOC entry 3196 (class 0 OID 0)
-- Dependencies: 239
-- Name: movie_attribute_values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.movie_attribute_values_id_seq OWNED BY public.movie_attribute_values.id;


--
-- TOC entry 237 (class 1259 OID 24838)
-- Name: movie_attributes_groups_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.movie_attributes_groups_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_attributes_groups_id_seq OWNER TO aleksei;

--
-- TOC entry 3197 (class 0 OID 0)
-- Dependencies: 237
-- Name: movie_attributes_groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.movie_attributes_groups_id_seq OWNED BY public.movie_attributes_groups.id;


--
-- TOC entry 233 (class 1259 OID 24809)
-- Name: movie_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.movie_attributes_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_attributes_id_seq OWNER TO aleksei;

--
-- TOC entry 3198 (class 0 OID 0)
-- Dependencies: 233
-- Name: movie_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.movie_attributes_id_seq OWNED BY public.movie_attributes.id;


--
-- TOC entry 235 (class 1259 OID 24822)
-- Name: movie_attributes_types_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.movie_attributes_types_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_attributes_types_id_seq OWNER TO aleksei;

--
-- TOC entry 3199 (class 0 OID 0)
-- Dependencies: 235
-- Name: movie_attributes_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.movie_attributes_types_id_seq OWNED BY public.movie_attributes_types.id;


--
-- TOC entry 230 (class 1259 OID 24770)
-- Name: pay_types; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.pay_types (
    id smallint NOT NULL,
    name character varying(255)
);


ALTER TABLE public.pay_types OWNER TO aleksei;

--
-- TOC entry 229 (class 1259 OID 24768)
-- Name: newtable_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.newtable_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.newtable_id_seq OWNER TO aleksei;

--
-- TOC entry 3200 (class 0 OID 0)
-- Dependencies: 229
-- Name: newtable_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.newtable_id_seq OWNED BY public.pay_types.id;


--
-- TOC entry 232 (class 1259 OID 24788)
-- Name: order_items; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.order_items (
    id integer NOT NULL,
    timetable_id integer,
    price numeric(6,2),
    tickets_amount smallint,
    order_id integer,
    price_total numeric(6,2)
);


ALTER TABLE public.order_items OWNER TO aleksei;

--
-- TOC entry 231 (class 1259 OID 24776)
-- Name: orders; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.orders (
    id integer NOT NULL,
    pay_type_id smallint,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.orders OWNER TO aleksei;

--
-- TOC entry 226 (class 1259 OID 24744)
-- Name: price_category; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.price_category (
    id integer NOT NULL,
    name character varying(255)
);


ALTER TABLE public.price_category OWNER TO aleksei;

--
-- TOC entry 225 (class 1259 OID 24742)
-- Name: price_category_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.price_category_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.price_category_id_seq OWNER TO aleksei;

--
-- TOC entry 3201 (class 0 OID 0)
-- Dependencies: 225
-- Name: price_category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.price_category_id_seq OWNED BY public.price_category.id;


--
-- TOC entry 228 (class 1259 OID 24752)
-- Name: prices; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.prices (
    id integer NOT NULL,
    timetable_id integer,
    price_category_id integer,
    price numeric(6,2)
);


ALTER TABLE public.prices OWNER TO aleksei;

--
-- TOC entry 227 (class 1259 OID 24750)
-- Name: prices_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.prices_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.prices_id_seq OWNER TO aleksei;

--
-- TOC entry 3202 (class 0 OID 0)
-- Dependencies: 227
-- Name: prices_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.prices_id_seq OWNED BY public.prices.id;


--
-- TOC entry 216 (class 1259 OID 24672)
-- Name: producers_in_movies; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.producers_in_movies (
    id integer NOT NULL,
    actor_id integer,
    movie_id integer
);


ALTER TABLE public.producers_in_movies OWNER TO aleksei;

--
-- TOC entry 224 (class 1259 OID 24726)
-- Name: timetable; Type: TABLE; Schema: public; Owner: aleksei
--

CREATE TABLE public.timetable (
    id integer NOT NULL,
    movie_id integer,
    hall_id integer,
    time_start time without time zone,
    time_finish time without time zone,
    date date
);


ALTER TABLE public.timetable OWNER TO aleksei;

--
-- TOC entry 223 (class 1259 OID 24724)
-- Name: timetable_id_seq; Type: SEQUENCE; Schema: public; Owner: aleksei
--

CREATE SEQUENCE public.timetable_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.timetable_id_seq OWNER TO aleksei;


-- Drop table

-- DROP TABLE public.actors;

CREATE TABLE public.actors (
	id serial NOT NULL,
	"name" varchar(255) NULL,
	surname varchar(255) NULL,
	about_text text NULL,
	photo varchar(255) NULL,
	date_of_birth date NULL,
	CONSTRAINT actors_pk PRIMARY KEY (id)
);

ALTER TABLE public.actors OWNER TO aleksei;

ALTER TABLE ONLY public.actors ALTER COLUMN id SET DEFAULT nextval('public.actors_id_seq'::regclass);



-- Drop table

-- DROP TABLE public.actors_in_movies;

CREATE TABLE public.actors_in_movies (
	id serial NOT NULL,
	actor_id int4 NULL,
	movie_id int4 NULL,
	CONSTRAINT actors_in_movies_pk PRIMARY KEY (id),
	CONSTRAINT actors_in_movies_fk FOREIGN KEY (actor_id) REFERENCES actors(id) ON DELETE CASCADE,
	CONSTRAINT actors_in_movies_fk_1 FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);
CREATE INDEX actors_in_movies_actor_id_idx ON public.actors_in_movies USING btree (actor_id);
CREATE INDEX actors_in_movies_movie_id_idx ON public.actors_in_movies USING btree (movie_id);



ALTER TABLE public.actors_in_movies OWNER TO aleksei;

ALTER TABLE ONLY public.actors_in_movies ALTER COLUMN id SET DEFAULT nextval('public.actors_in_movies_id_seq'::regclass);



-- Drop table

-- DROP TABLE public.movies;

CREATE TABLE public.movies (
	id serial NOT NULL,
	"name" varchar(255) NULL,
	creation_date timestamp NULL,
	trailer varchar(255) NULL,
	image_folder varchar(255) NULL,
	description text NULL,
	duration time NULL DEFAULT CURRENT_TIME,
	censor int2 NULL,
	CONSTRAINT movies_pk PRIMARY KEY (id)
);
CREATE INDEX movies_creation_date_idx ON public.movies USING btree (creation_date);


ALTER TABLE public.movies OWNER TO aleksei;

ALTER TABLE ONLY public.movies ALTER COLUMN id SET DEFAULT nextval('public.movies_id_seq'::regclass);






--
-- TOC entry 3203 (class 0 OID 0)
-- Dependencies: 223
-- Name: timetable_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: aleksei
--

ALTER SEQUENCE public.timetable_id_seq OWNED BY public.timetable.id;


--
-- TOC entry 2952 (class 2604 OID 24633)
-- Name: actor_types id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.actor_types ALTER COLUMN id SET DEFAULT nextval('public.actor_types_id_seq'::regclass);


--
-- TOC entry 2953 (class 2604 OID 24641)
-- Name: actor_types_added id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.actor_types_added ALTER COLUMN id SET DEFAULT nextval('public.actor_types_added_id_seq'::regclass);


--
-- TOC entry 2954 (class 2604 OID 24692)
-- Name: countries id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.countries ALTER COLUMN id SET DEFAULT nextval('public.countries_id_seq'::regclass);


--
-- TOC entry 2955 (class 2604 OID 24703)
-- Name: countries_added id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.countries_added ALTER COLUMN id SET DEFAULT nextval('public.countries_added_id_seq'::regclass);


--
-- TOC entry 2950 (class 2604 OID 24596)
-- Name: genres id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.genres ALTER COLUMN id SET DEFAULT nextval('public.genres_id_seq'::regclass);


--
-- TOC entry 2951 (class 2604 OID 24604)
-- Name: genres_added id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.genres_added ALTER COLUMN id SET DEFAULT nextval('public.genres_added_id_seq'::regclass);


--
-- TOC entry 2956 (class 2604 OID 24721)
-- Name: halls id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.halls ALTER COLUMN id SET DEFAULT nextval('public.halls_id_seq'::regclass);


--
-- TOC entry 2965 (class 2604 OID 24861)
-- Name: movie_attribute_values id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attribute_values ALTER COLUMN id SET DEFAULT nextval('public.movie_attribute_values_id_seq'::regclass);


--
-- TOC entry 2962 (class 2604 OID 24814)
-- Name: movie_attributes id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attributes ALTER COLUMN id SET DEFAULT nextval('public.movie_attributes_id_seq'::regclass);


--
-- TOC entry 2964 (class 2604 OID 24843)
-- Name: movie_attributes_groups id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attributes_groups ALTER COLUMN id SET DEFAULT nextval('public.movie_attributes_groups_id_seq'::regclass);


--
-- TOC entry 2963 (class 2604 OID 24827)
-- Name: movie_attributes_types id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attributes_types ALTER COLUMN id SET DEFAULT nextval('public.movie_attributes_types_id_seq'::regclass);


--
-- TOC entry 2960 (class 2604 OID 24773)
-- Name: pay_types id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.pay_types ALTER COLUMN id SET DEFAULT nextval('public.newtable_id_seq'::regclass);


--
-- TOC entry 2958 (class 2604 OID 24747)
-- Name: price_category id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.price_category ALTER COLUMN id SET DEFAULT nextval('public.price_category_id_seq'::regclass);


--
-- TOC entry 2959 (class 2604 OID 24755)
-- Name: prices id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.prices ALTER COLUMN id SET DEFAULT nextval('public.prices_id_seq'::regclass);


--
-- TOC entry 2957 (class 2604 OID 24729)
-- Name: timetable id; Type: DEFAULT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.timetable ALTER COLUMN id SET DEFAULT nextval('public.timetable_id_seq'::regclass);


--
-- TOC entry 3155 (class 0 OID 24630)
-- Dependencies: 211
-- Data for Name: actor_types; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.actor_types (id, type_name) FROM stdin;
\.


--
-- TOC entry 3157 (class 0 OID 24638)
-- Dependencies: 213
-- Data for Name: actor_types_added; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.actor_types_added (id, actor_type_id, actor_id) FROM stdin;
\.


--
-- TOC entry 3160 (class 0 OID 24689)
-- Dependencies: 218
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.countries (id, ru_name, en_name) FROM stdin;
\.


--
-- TOC entry 3162 (class 0 OID 24700)
-- Dependencies: 220
-- Data for Name: countries_added; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.countries_added (id, movie_id, country_id) FROM stdin;
\.


--
-- TOC entry 3151 (class 0 OID 24593)
-- Dependencies: 205
-- Data for Name: genres; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.genres (id, name) FROM stdin;
1	фантастика
\.


--
-- TOC entry 3153 (class 0 OID 24601)
-- Dependencies: 207
-- Data for Name: genres_added; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.genres_added (id, movie_id, genre_id) FROM stdin;
\.


--
-- TOC entry 3164 (class 0 OID 24718)
-- Dependencies: 222
-- Data for Name: halls; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.halls (id, number, name, space) FROM stdin;
\.


--
-- TOC entry 3183 (class 0 OID 41030)
-- Dependencies: 244
-- Data for Name: hello; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.hello (film_name) FROM stdin;
 $1 
 $1 
 $1 
 $1 
 $1 
 $1 
 $1 
 $1 
 $1 
 $1 
qoPi9jqNrJ
9jSmrctJSO
rWumqoA06t
YD8eoZJqF8
H5f6JKrB03
9FXYOwkX3b
mCsGZzdoYn
juy1r3cRs9
XI9RjnEQSn
bQ6ZEVaLGT
m
j
u
"U"
g
"V"
g
u
"C"
t
"G"
"J"
"7"
q
i
"0"
"D"
a
"I"
"K"
\.


--
-- TOC entry 3182 (class 0 OID 24858)
-- Dependencies: 240
-- Data for Name: movie_attribute_values; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.movie_attribute_values (id, movie_attribute_id, movie_id, value) FROM stdin;
\.


--
-- TOC entry 3176 (class 0 OID 24811)
-- Dependencies: 234
-- Data for Name: movie_attributes; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.movie_attributes (id, name, movie_attribute_group_id) FROM stdin;
1	Мировая премьера	1
2	Премьера в РФ	1
3	Старт продаж билетов	2
4	Старт рекламы	2
5	оскар	3
6	ника	3
7	тефи	3
8	рецензии критиков	4
9	отзывы неизвестной киноакадемии	4
10	отзывы людей	4
\.


--
-- TOC entry 3180 (class 0 OID 24840)
-- Dependencies: 238
-- Data for Name: movie_attributes_groups; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.movie_attributes_groups (id, name, movie_attribute_type_id) FROM stdin;
1	важные даты	1
2	служебные даты	2
3	премии	3
4	рецензии	4
\.


--
-- TOC entry 3178 (class 0 OID 24824)
-- Dependencies: 236
-- Data for Name: movie_attributes_types; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.movie_attributes_types (id, type) FROM stdin;
1	date
2	timestamp
3	boolean
4	text
\.


--
-- TOC entry 3174 (class 0 OID 24788)
-- Dependencies: 232
-- Data for Name: order_items; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.order_items (id, timetable_id, price, tickets_amount, order_id, price_total) FROM stdin;
\.


--
-- TOC entry 3173 (class 0 OID 24776)
-- Dependencies: 231
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.orders (id, pay_type_id, created_at) FROM stdin;
\.


--
-- TOC entry 3172 (class 0 OID 24770)
-- Dependencies: 230
-- Data for Name: pay_types; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.pay_types (id, name) FROM stdin;
\.


--
-- TOC entry 3168 (class 0 OID 24744)
-- Dependencies: 226
-- Data for Name: price_category; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.price_category (id, name) FROM stdin;
\.


--
-- TOC entry 3170 (class 0 OID 24752)
-- Dependencies: 228
-- Data for Name: prices; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.prices (id, timetable_id, price_category_id, price) FROM stdin;
\.


--
-- TOC entry 3158 (class 0 OID 24672)
-- Dependencies: 216
-- Data for Name: producers_in_movies; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.producers_in_movies (id, actor_id, movie_id) FROM stdin;
\.


--
-- TOC entry 3166 (class 0 OID 24726)
-- Dependencies: 224
-- Data for Name: timetable; Type: TABLE DATA; Schema: public; Owner: aleksei
--

COPY public.timetable (id, movie_id, hall_id, time_start, time_finish, date) FROM stdin;
\.


--
-- TOC entry 3204 (class 0 OID 0)
-- Dependencies: 212
-- Name: actor_types_added_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.actor_types_added_id_seq', 1, false);


--
-- TOC entry 3205 (class 0 OID 0)
-- Dependencies: 210
-- Name: actor_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.actor_types_id_seq', 1, false);


--
-- TOC entry 3206 (class 0 OID 0)
-- Dependencies: 219
-- Name: countries_added_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.countries_added_id_seq', 1, false);


--
-- TOC entry 3207 (class 0 OID 0)
-- Dependencies: 217
-- Name: countries_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.countries_id_seq', 1, false);


--
-- TOC entry 3208 (class 0 OID 0)
-- Dependencies: 206
-- Name: genres_added_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.genres_added_id_seq', 1, true);


--
-- TOC entry 3209 (class 0 OID 0)
-- Dependencies: 204
-- Name: genres_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.genres_id_seq', 1, true);


--
-- TOC entry 3210 (class 0 OID 0)
-- Dependencies: 221
-- Name: halls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.halls_id_seq', 1, false);


--
-- TOC entry 3211 (class 0 OID 0)
-- Dependencies: 239
-- Name: movie_attribute_values_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.movie_attribute_values_id_seq', 10, true);


--
-- TOC entry 3212 (class 0 OID 0)
-- Dependencies: 237
-- Name: movie_attributes_groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.movie_attributes_groups_id_seq', 4, true);


--
-- TOC entry 3213 (class 0 OID 0)
-- Dependencies: 233
-- Name: movie_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.movie_attributes_id_seq', 10, true);


--
-- TOC entry 3214 (class 0 OID 0)
-- Dependencies: 235
-- Name: movie_attributes_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.movie_attributes_types_id_seq', 4, true);


--
-- TOC entry 3215 (class 0 OID 0)
-- Dependencies: 229
-- Name: newtable_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.newtable_id_seq', 1, false);


--
-- TOC entry 3216 (class 0 OID 0)
-- Dependencies: 225
-- Name: price_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.price_category_id_seq', 1, false);


--
-- TOC entry 3217 (class 0 OID 0)
-- Dependencies: 227
-- Name: prices_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.prices_id_seq', 1, false);


--
-- TOC entry 3218 (class 0 OID 0)
-- Dependencies: 223
-- Name: timetable_id_seq; Type: SEQUENCE SET; Schema: public; Owner: aleksei
--

SELECT pg_catalog.setval('public.timetable_id_seq', 1, false);


--
-- TOC entry 2973 (class 2606 OID 24643)
-- Name: actor_types_added actor_types_added_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.actor_types_added
    ADD CONSTRAINT actor_types_added_pk PRIMARY KEY (id);


--
-- TOC entry 2971 (class 2606 OID 24635)
-- Name: actor_types actor_types_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.actor_types
    ADD CONSTRAINT actor_types_pk PRIMARY KEY (id);


--
-- TOC entry 2979 (class 2606 OID 24705)
-- Name: countries_added countries_added_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.countries_added
    ADD CONSTRAINT countries_added_pk PRIMARY KEY (id);


--
-- TOC entry 2977 (class 2606 OID 24697)
-- Name: countries countries_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_pk PRIMARY KEY (id);


--
-- TOC entry 2969 (class 2606 OID 24606)
-- Name: genres_added genres_added_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.genres_added
    ADD CONSTRAINT genres_added_pk PRIMARY KEY (id);


--
-- TOC entry 2967 (class 2606 OID 24598)
-- Name: genres genres_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.genres
    ADD CONSTRAINT genres_pk PRIMARY KEY (id);


--
-- TOC entry 2981 (class 2606 OID 24723)
-- Name: halls halls_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pk PRIMARY KEY (id);


--
-- TOC entry 3001 (class 2606 OID 24866)
-- Name: movie_attribute_values movie_attribute_values_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attribute_values
    ADD CONSTRAINT movie_attribute_values_pk PRIMARY KEY (id);


--
-- TOC entry 2999 (class 2606 OID 24845)
-- Name: movie_attributes_groups movie_attributes_groups_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attributes_groups
    ADD CONSTRAINT movie_attributes_groups_pk PRIMARY KEY (id);


--
-- TOC entry 2995 (class 2606 OID 24816)
-- Name: movie_attributes movie_attributes_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attributes
    ADD CONSTRAINT movie_attributes_pk PRIMARY KEY (id);


--
-- TOC entry 2997 (class 2606 OID 24829)
-- Name: movie_attributes_types movie_attributes_types_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attributes_types
    ADD CONSTRAINT movie_attributes_types_pk PRIMARY KEY (id);


--
-- TOC entry 2991 (class 2606 OID 24781)
-- Name: orders newtable_1_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT newtable_1_pk PRIMARY KEY (id);


--
-- TOC entry 2989 (class 2606 OID 24775)
-- Name: pay_types newtable_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.pay_types
    ADD CONSTRAINT newtable_pk PRIMARY KEY (id);


--
-- TOC entry 2993 (class 2606 OID 24792)
-- Name: order_items order_items_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_pk PRIMARY KEY (id);


--
-- TOC entry 2985 (class 2606 OID 24749)
-- Name: price_category price_category_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.price_category
    ADD CONSTRAINT price_category_pk PRIMARY KEY (id);


--
-- TOC entry 2987 (class 2606 OID 24757)
-- Name: prices prices_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.prices
    ADD CONSTRAINT prices_pk PRIMARY KEY (id);


--
-- TOC entry 2975 (class 2606 OID 24676)
-- Name: producers_in_movies producers_in_movies_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.producers_in_movies
    ADD CONSTRAINT producers_in_movies_pk PRIMARY KEY (id);


--
-- TOC entry 2983 (class 2606 OID 24731)
-- Name: timetable timetable_pk; Type: CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.timetable
    ADD CONSTRAINT timetable_pk PRIMARY KEY (id);


--
-- TOC entry 3004 (class 2606 OID 24644)
-- Name: actor_types_added actor_types_added_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.actor_types_added
    ADD CONSTRAINT actor_types_added_fk FOREIGN KEY (actor_id) REFERENCES public.actors(id) ON DELETE CASCADE;


--
-- TOC entry 3005 (class 2606 OID 24649)
-- Name: actor_types_added actor_types_added_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.actor_types_added
    ADD CONSTRAINT actor_types_added_fk_1 FOREIGN KEY (actor_type_id) REFERENCES public.actor_types(id) ON DELETE CASCADE;


--
-- TOC entry 3008 (class 2606 OID 24706)
-- Name: countries_added countries_added_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.countries_added
    ADD CONSTRAINT countries_added_fk FOREIGN KEY (country_id) REFERENCES public.countries(id) ON DELETE CASCADE;


--
-- TOC entry 3009 (class 2606 OID 24711)
-- Name: countries_added countries_added_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.countries_added
    ADD CONSTRAINT countries_added_fk_1 FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON DELETE CASCADE;


--
-- TOC entry 3002 (class 2606 OID 24607)
-- Name: genres_added genres_added_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.genres_added
    ADD CONSTRAINT genres_added_fk FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON DELETE CASCADE;


--
-- TOC entry 3003 (class 2606 OID 24612)
-- Name: genres_added genres_added_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.genres_added
    ADD CONSTRAINT genres_added_fk_1 FOREIGN KEY (genre_id) REFERENCES public.genres(id) ON DELETE CASCADE;


--
-- TOC entry 3019 (class 2606 OID 24867)
-- Name: movie_attribute_values movie_attribute_values_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attribute_values
    ADD CONSTRAINT movie_attribute_values_fk FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON DELETE CASCADE;


--
-- TOC entry 3020 (class 2606 OID 24872)
-- Name: movie_attribute_values movie_attribute_values_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attribute_values
    ADD CONSTRAINT movie_attribute_values_fk_1 FOREIGN KEY (movie_attribute_id) REFERENCES public.movie_attributes(id) ON DELETE CASCADE;


--
-- TOC entry 3017 (class 2606 OID 24851)
-- Name: movie_attributes movie_attributes_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attributes
    ADD CONSTRAINT movie_attributes_fk FOREIGN KEY (movie_attribute_group_id) REFERENCES public.movie_attributes_groups(id);


--
-- TOC entry 3018 (class 2606 OID 24893)
-- Name: movie_attributes_groups movie_attributes_groups_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.movie_attributes_groups
    ADD CONSTRAINT movie_attributes_groups_fk FOREIGN KEY (movie_attribute_type_id) REFERENCES public.movie_attributes_types(id);


--
-- TOC entry 3014 (class 2606 OID 24782)
-- Name: orders newtable_1_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT newtable_1_fk FOREIGN KEY (pay_type_id) REFERENCES public.pay_types(id);


--
-- TOC entry 3015 (class 2606 OID 24793)
-- Name: order_items order_items_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_fk FOREIGN KEY (timetable_id) REFERENCES public.timetable(id);


--
-- TOC entry 3016 (class 2606 OID 24798)
-- Name: order_items order_items_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_fk_1 FOREIGN KEY (order_id) REFERENCES public.orders(id) ON DELETE CASCADE;


--
-- TOC entry 3012 (class 2606 OID 24758)
-- Name: prices prices_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.prices
    ADD CONSTRAINT prices_fk FOREIGN KEY (timetable_id) REFERENCES public.timetable(id) ON DELETE CASCADE;


--
-- TOC entry 3013 (class 2606 OID 24763)
-- Name: prices prices_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.prices
    ADD CONSTRAINT prices_fk_1 FOREIGN KEY (price_category_id) REFERENCES public.price_category(id) ON DELETE CASCADE;


--
-- TOC entry 3006 (class 2606 OID 24677)
-- Name: producers_in_movies producers_in_movies_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.producers_in_movies
    ADD CONSTRAINT producers_in_movies_fk FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON DELETE CASCADE;


--
-- TOC entry 3007 (class 2606 OID 24682)
-- Name: producers_in_movies producers_in_movies_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.producers_in_movies
    ADD CONSTRAINT producers_in_movies_fk_1 FOREIGN KEY (actor_id) REFERENCES public.actors(id) ON DELETE CASCADE;


--
-- TOC entry 3010 (class 2606 OID 24732)
-- Name: timetable timetable_fk; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.timetable
    ADD CONSTRAINT timetable_fk FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON DELETE CASCADE;


--
-- TOC entry 3011 (class 2606 OID 24737)
-- Name: timetable timetable_fk_1; Type: FK CONSTRAINT; Schema: public; Owner: aleksei
--

ALTER TABLE ONLY public.timetable
    ADD CONSTRAINT timetable_fk_1 FOREIGN KEY (hall_id) REFERENCES public.halls(id);


-- Completed on 2020-07-16 21:58:12 MSK

--
-- PostgreSQL database dump complete
--

