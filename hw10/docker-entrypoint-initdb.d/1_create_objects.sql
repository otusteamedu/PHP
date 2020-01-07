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
-- Name: getsessionmonth(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.getsessionmonth(some_time timestamp with time zone) RETURNS double precision
    LANGUAGE plpgsql IMMUTABLE
    AS $$
	begin
		return extract(year from some_time);
	end;
$$;


ALTER FUNCTION public.getsessionmonth(some_time timestamp with time zone) OWNER TO postgres;

--
-- Name: getsessionyear(timestamp with time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.getsessionyear(some_time timestamp with time zone) RETURNS double precision
    LANGUAGE plpgsql IMMUTABLE
    AS $$
	begin
		return extract(year from some_time);
	end;
$$;


ALTER FUNCTION public.getsessionyear(some_time timestamp with time zone) OWNER TO postgres;

--
-- Name: myincrement(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.myincrement(i integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
        BEGIN
                RETURN extract(year from i);
        END;
$$;


ALTER FUNCTION public.myincrement(i integer) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: client; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.client (
    id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.client OWNER TO postgres;

--
-- Name: client_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.client_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.client_id_seq OWNER TO postgres;

--
-- Name: client_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.client_id_seq OWNED BY public.client.id;


--
-- Name: client_ticket; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.client_ticket (
    client_id integer NOT NULL,
    ticket_id bigint NOT NULL
);


ALTER TABLE public.client_ticket OWNER TO postgres;

--
-- Name: film; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film (
    id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.film OWNER TO postgres;

--
-- Name: film_all_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_all_attributes (
    id integer NOT NULL,
    film_id integer NOT NULL,
    film_attributes text
);


ALTER TABLE public.film_all_attributes OWNER TO postgres;

--
-- Name: film_all_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_all_attributes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.film_all_attributes_id_seq OWNER TO postgres;

--
-- Name: film_all_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_all_attributes_id_seq OWNED BY public.film_all_attributes.id;


--
-- Name: film_attribute; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_attribute (
    id integer NOT NULL,
    name text NOT NULL,
    type_id smallint NOT NULL,
    description text
);


ALTER TABLE public.film_attribute OWNER TO postgres;

--
-- Name: film_attribute_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_attribute_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.film_attribute_id_seq OWNER TO postgres;

--
-- Name: film_attribute_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_attribute_id_seq OWNED BY public.film_attribute.id;


--
-- Name: film_attribute_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_attribute_type (
    id smallint NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.film_attribute_type OWNER TO postgres;

--
-- Name: film_attribute_type_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_attribute_type_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.film_attribute_type_id_seq OWNER TO postgres;

--
-- Name: film_attribute_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_attribute_type_id_seq OWNED BY public.film_attribute_type.id;


--
-- Name: film_attribute_value; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_attribute_value (
    id integer NOT NULL,
    attribute_id integer NOT NULL,
    film_id integer NOT NULL,
    val_date date,
    val_text text,
    val_int integer,
    val_decimal numeric,
    val_bool boolean
);


ALTER TABLE public.film_attribute_value OWNER TO postgres;

--
-- Name: film_attribute_value_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_attribute_value_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.film_attribute_value_id_seq OWNER TO postgres;

--
-- Name: film_attribute_value_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_attribute_value_id_seq OWNED BY public.film_attribute_value.id;


--
-- Name: film_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.film_id_seq OWNER TO postgres;

--
-- Name: film_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_id_seq OWNED BY public.film.id;


--
-- Name: hall; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hall (
    id smallint NOT NULL,
    name text NOT NULL,
    size integer NOT NULL
);


ALTER TABLE public.hall OWNER TO postgres;

--
-- Name: hall_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.hall_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.hall_id_seq OWNER TO postgres;

--
-- Name: hall_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.hall_id_seq OWNED BY public.hall.id;


--
-- Name: marketing_data; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.marketing_data AS
 SELECT f.name AS film_name,
    fat.name AS attribute_type,
    fa.name AS attribute_name,
        CASE fat.id
            WHEN 1 THEN fav.val_text
            WHEN 2 THEN (fav.val_bool)::text
            WHEN 3 THEN (fav.val_date)::text
            WHEN 4 THEN (fav.val_int)::text
            WHEN 5 THEN (fav.val_decimal)::text
            WHEN 6 THEN (fav.val_date)::text
            ELSE NULL::text
        END AS attribute_value
   FROM (((public.film_attribute_value fav
     JOIN public.film_attribute fa ON ((fa.id = fav.attribute_id)))
     JOIN public.film_attribute_type fat ON ((fat.id = fa.type_id)))
     JOIN public.film f ON ((f.id = fav.film_id)));


ALTER TABLE public.marketing_data OWNER TO postgres;

--
-- Name: parted_sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions (
    id integer NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
)
PARTITION BY RANGE (start);


ALTER TABLE public.parted_sessions OWNER TO postgres;

--
-- Name: parted_sessions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.parted_sessions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parted_sessions_id_seq OWNER TO postgres;

--
-- Name: parted_sessions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.parted_sessions_id_seq OWNED BY public.parted_sessions.id;


--
-- Name: parted_sessions_2019_01; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_01 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_01 FOR VALUES FROM ('2018-12-31 19:00:00+00') TO ('2019-01-31 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_01 OWNER TO postgres;

--
-- Name: parted_sessions_2019_02; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_02 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_02 FOR VALUES FROM ('2019-01-31 19:00:00+00') TO ('2019-02-28 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_02 OWNER TO postgres;

--
-- Name: parted_sessions_2019_03; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_03 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_03 FOR VALUES FROM ('2019-02-28 19:00:00+00') TO ('2019-03-31 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_03 OWNER TO postgres;

--
-- Name: parted_sessions_2019_04; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_04 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_04 FOR VALUES FROM ('2019-03-31 19:00:00+00') TO ('2019-04-30 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_04 OWNER TO postgres;

--
-- Name: parted_sessions_2019_05; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_05 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_05 FOR VALUES FROM ('2019-04-30 19:00:00+00') TO ('2019-05-31 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_05 OWNER TO postgres;

--
-- Name: parted_sessions_2019_06; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_06 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_06 FOR VALUES FROM ('2019-05-31 19:00:00+00') TO ('2019-06-30 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_06 OWNER TO postgres;

--
-- Name: parted_sessions_2019_07; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_07 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_07 FOR VALUES FROM ('2019-06-30 19:00:00+00') TO ('2019-07-31 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_07 OWNER TO postgres;

--
-- Name: parted_sessions_2019_08; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_08 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_08 FOR VALUES FROM ('2019-07-31 19:00:00+00') TO ('2019-08-31 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_08 OWNER TO postgres;

--
-- Name: parted_sessions_2019_09; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_09 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_09 FOR VALUES FROM ('2019-08-31 19:00:00+00') TO ('2019-09-30 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_09 OWNER TO postgres;

--
-- Name: parted_sessions_2019_10; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_10 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_10 FOR VALUES FROM ('2019-09-30 19:00:00+00') TO ('2019-10-31 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_10 OWNER TO postgres;

--
-- Name: parted_sessions_2019_11; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_11 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_11 FOR VALUES FROM ('2019-10-31 19:00:00+00') TO ('2019-11-30 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_11 OWNER TO postgres;

--
-- Name: parted_sessions_2019_12; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_2019_12 (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_2019_12 FOR VALUES FROM ('2019-11-30 19:00:00+00') TO ('2019-12-31 19:00:00+00');


ALTER TABLE public.parted_sessions_2019_12 OWNER TO postgres;

--
-- Name: parted_sessions_newer; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_newer (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_newer FOR VALUES FROM ('2019-12-31 19:00:00+00') TO (MAXVALUE);


ALTER TABLE public.parted_sessions_newer OWNER TO postgres;

--
-- Name: parted_sessions_older; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parted_sessions_older (
    id integer DEFAULT nextval('public.parted_sessions_id_seq'::regclass) NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone NOT NULL
);
ALTER TABLE ONLY public.parted_sessions ATTACH PARTITION public.parted_sessions_older FOR VALUES FROM (MINVALUE) TO ('2018-12-31 19:00:00+00');


ALTER TABLE public.parted_sessions_older OWNER TO postgres;

--
-- Name: service_dates; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.service_dates AS
 SELECT f.name,
    current_dates.current_date_detail,
    future_dates.future_date_detail
   FROM ((( SELECT fav1.film_id,
            string_agg(concat(fa1.name, ': ', fav1.val_date), '; '::text) AS current_date_detail
           FROM ((public.film_attribute_value fav1
             JOIN public.film_attribute fa1 ON ((fa1.id = fav1.attribute_id)))
             JOIN public.film_attribute_type fat1 ON ((fat1.id = fa1.type_id)))
          WHERE ((fat1.id = 6) AND (fav1.val_date <= CURRENT_DATE))
          GROUP BY fav1.film_id) current_dates
     LEFT JOIN ( SELECT fav2.film_id,
            string_agg(concat(fa2.name, ': ', fav2.val_date), '; '::text) AS future_date_detail
           FROM ((public.film_attribute_value fav2
             JOIN public.film_attribute fa2 ON ((fa2.id = fav2.attribute_id)))
             JOIN public.film_attribute_type fat2 ON ((fat2.id = fa2.type_id)))
          WHERE ((fat2.id = 6) AND (fav2.val_date > (CURRENT_DATE + '20 days'::interval)))
          GROUP BY fav2.film_id) future_dates ON ((future_dates.film_id = current_dates.film_id)))
     JOIN public.film f ON (((f.id = current_dates.film_id) OR (f.id = future_dates.film_id))));


ALTER TABLE public.service_dates OWNER TO postgres;

--
-- Name: session; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.session (
    id integer NOT NULL,
    film_id integer NOT NULL,
    hall_id smallint NOT NULL,
    start timestamp with time zone
);


ALTER TABLE public.session OWNER TO postgres;

--
-- Name: session_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.session_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.session_id_seq OWNER TO postgres;

--
-- Name: session_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.session_id_seq OWNED BY public.session.id;


--
-- Name: ticket; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ticket (
    id bigint NOT NULL,
    session_id integer NOT NULL,
    place integer NOT NULL,
    price integer NOT NULL
);


ALTER TABLE public.ticket OWNER TO postgres;

--
-- Name: ticket_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ticket_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ticket_id_seq OWNER TO postgres;

--
-- Name: ticket_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ticket_id_seq OWNED BY public.ticket.id;


--
-- Name: ticket_v2; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ticket_v2 (
    id bigint NOT NULL,
    session_id integer NOT NULL,
    client_id integer NOT NULL,
    film_id integer NOT NULL,
    hall_id integer NOT NULL,
    place integer NOT NULL,
    price integer NOT NULL
);


ALTER TABLE public.ticket_v2 OWNER TO postgres;

--
-- Name: ticket_v2_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ticket_v2_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ticket_v2_id_seq OWNER TO postgres;

--
-- Name: ticket_v2_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ticket_v2_id_seq OWNED BY public.ticket_v2.id;


--
-- Name: client id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client ALTER COLUMN id SET DEFAULT nextval('public.client_id_seq'::regclass);


--
-- Name: film id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film ALTER COLUMN id SET DEFAULT nextval('public.film_id_seq'::regclass);


--
-- Name: film_all_attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_all_attributes ALTER COLUMN id SET DEFAULT nextval('public.film_all_attributes_id_seq'::regclass);


--
-- Name: film_attribute id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute ALTER COLUMN id SET DEFAULT nextval('public.film_attribute_id_seq'::regclass);


--
-- Name: film_attribute_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_type ALTER COLUMN id SET DEFAULT nextval('public.film_attribute_type_id_seq'::regclass);


--
-- Name: film_attribute_value id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_value ALTER COLUMN id SET DEFAULT nextval('public.film_attribute_value_id_seq'::regclass);


--
-- Name: hall id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hall ALTER COLUMN id SET DEFAULT nextval('public.hall_id_seq'::regclass);


--
-- Name: parted_sessions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions ALTER COLUMN id SET DEFAULT nextval('public.parted_sessions_id_seq'::regclass);


--
-- Name: session id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session ALTER COLUMN id SET DEFAULT nextval('public.session_id_seq'::regclass);


--
-- Name: ticket id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket ALTER COLUMN id SET DEFAULT nextval('public.ticket_id_seq'::regclass);


--
-- Name: ticket_v2 id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket_v2 ALTER COLUMN id SET DEFAULT nextval('public.ticket_v2_id_seq'::regclass);


--
-- Name: client client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id) INCLUDE (name);


--
-- Name: client_ticket client_ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_ticket
    ADD CONSTRAINT client_ticket_pkey PRIMARY KEY (client_id, ticket_id) INCLUDE (client_id, ticket_id);


--
-- Name: film_attribute film_attribute_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute
    ADD CONSTRAINT film_attribute_pkey PRIMARY KEY (id) INCLUDE (name, type_id);


--
-- Name: film_attribute_type film_attribute_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_type
    ADD CONSTRAINT film_attribute_type_pkey PRIMARY KEY (id) INCLUDE (name);


--
-- Name: film_attribute_value film_attribute_value_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_value
    ADD CONSTRAINT film_attribute_value_pkey PRIMARY KEY (id) INCLUDE (attribute_id, film_id, val_date, val_text, val_int, val_decimal, val_bool);


--
-- Name: film film_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film
    ADD CONSTRAINT film_pkey PRIMARY KEY (id) INCLUDE (name);


--
-- Name: hall hall_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hall
    ADD CONSTRAINT hall_pkey PRIMARY KEY (id) INCLUDE (name, size);


--
-- Name: parted_sessions parted_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions
    ADD CONSTRAINT parted_sessions_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_01 parted_sessions_2019_01_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_01
    ADD CONSTRAINT parted_sessions_2019_01_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_02 parted_sessions_2019_02_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_02
    ADD CONSTRAINT parted_sessions_2019_02_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_03 parted_sessions_2019_03_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_03
    ADD CONSTRAINT parted_sessions_2019_03_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_04 parted_sessions_2019_04_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_04
    ADD CONSTRAINT parted_sessions_2019_04_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_05 parted_sessions_2019_05_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_05
    ADD CONSTRAINT parted_sessions_2019_05_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_06 parted_sessions_2019_06_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_06
    ADD CONSTRAINT parted_sessions_2019_06_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_07 parted_sessions_2019_07_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_07
    ADD CONSTRAINT parted_sessions_2019_07_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_08 parted_sessions_2019_08_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_08
    ADD CONSTRAINT parted_sessions_2019_08_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_09 parted_sessions_2019_09_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_09
    ADD CONSTRAINT parted_sessions_2019_09_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_10 parted_sessions_2019_10_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_10
    ADD CONSTRAINT parted_sessions_2019_10_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_11 parted_sessions_2019_11_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_11
    ADD CONSTRAINT parted_sessions_2019_11_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_2019_12 parted_sessions_2019_12_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_2019_12
    ADD CONSTRAINT parted_sessions_2019_12_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_newer parted_sessions_newer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_newer
    ADD CONSTRAINT parted_sessions_newer_pkey PRIMARY KEY (id, start);


--
-- Name: parted_sessions_older parted_sessions_older_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parted_sessions_older
    ADD CONSTRAINT parted_sessions_older_pkey PRIMARY KEY (id, start);


--
-- Name: session session_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_pkey PRIMARY KEY (id) INCLUDE (film_id, hall_id, start);


--
-- Name: ticket ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_pkey PRIMARY KEY (id) INCLUDE (session_id, place, price);


--
-- Name: ticket_v2 ticket_v2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket_v2
    ADD CONSTRAINT ticket_v2_pkey PRIMARY KEY (id) INCLUDE (session_id, client_id, film_id, hall_id, place, price);


--
-- Name: session_date_part_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX session_date_part_idx ON public.session USING btree (date_part('year'::text, date(timezone('UTC'::text, start))));


--
-- Name: session_date_part_idx1; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX session_date_part_idx1 ON public.session USING btree (date_part('month'::text, date(timezone('UTC'::text, start))));


--
-- Name: session_start_id_film_id_hall_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX session_start_id_film_id_hall_id_idx ON public.session USING btree (start DESC NULLS LAST) INCLUDE (id, film_id, hall_id);


--
-- Name: ticket_session_id_id_place_price_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ticket_session_id_id_place_price_idx ON public.ticket USING btree (session_id) INCLUDE (id, place, price);


--
-- Name: ticket_v2_session_id_id_client_id_film_id_hall_id_place_pri_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ticket_v2_session_id_id_client_id_film_id_hall_id_place_pri_idx ON public.ticket_v2 USING btree (session_id) INCLUDE (id, client_id, film_id, hall_id, place, price);


--
-- Name: parted_sessions_2019_01_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_01_pkey;


--
-- Name: parted_sessions_2019_02_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_02_pkey;


--
-- Name: parted_sessions_2019_03_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_03_pkey;


--
-- Name: parted_sessions_2019_04_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_04_pkey;


--
-- Name: parted_sessions_2019_05_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_05_pkey;


--
-- Name: parted_sessions_2019_06_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_06_pkey;


--
-- Name: parted_sessions_2019_07_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_07_pkey;


--
-- Name: parted_sessions_2019_08_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_08_pkey;


--
-- Name: parted_sessions_2019_09_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_09_pkey;


--
-- Name: parted_sessions_2019_10_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_10_pkey;


--
-- Name: parted_sessions_2019_11_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_11_pkey;


--
-- Name: parted_sessions_2019_12_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_2019_12_pkey;


--
-- Name: parted_sessions_newer_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_newer_pkey;


--
-- Name: parted_sessions_older_pkey; Type: INDEX ATTACH; Schema: public; Owner: -
--

ALTER INDEX public.parted_sessions_pkey ATTACH PARTITION public.parted_sessions_older_pkey;


--
-- Name: client_ticket client_ticket_client_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_ticket
    ADD CONSTRAINT client_ticket_client_id_fkey FOREIGN KEY (client_id) REFERENCES public.client(id);


--
-- Name: client_ticket client_ticket_ticket_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_ticket
    ADD CONSTRAINT client_ticket_ticket_id_fkey FOREIGN KEY (ticket_id) REFERENCES public.ticket(id);


--
-- Name: film_attribute film_attribute_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute
    ADD CONSTRAINT film_attribute_type_id_fkey FOREIGN KEY (type_id) REFERENCES public.film_attribute_type(id);


--
-- Name: film_attribute_value film_attribute_value_attribute_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_value
    ADD CONSTRAINT film_attribute_value_attribute_id_fkey FOREIGN KEY (attribute_id) REFERENCES public.film_attribute(id);


--
-- Name: film_attribute_value film_attribute_value_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_value
    ADD CONSTRAINT film_attribute_value_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.film(id);


--
-- Name: session session_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.film(id);


--
-- Name: session session_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.hall(id);


--
-- Name: ticket ticket_session_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_session_id_fkey FOREIGN KEY (session_id) REFERENCES public.session(id);


--
-- Name: ticket_v2 ticket_v2_client_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket_v2
    ADD CONSTRAINT ticket_v2_client_id_fkey FOREIGN KEY (client_id) REFERENCES public.client(id);


--
-- Name: ticket_v2 ticket_v2_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket_v2
    ADD CONSTRAINT ticket_v2_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.film(id);


--
-- Name: ticket_v2 ticket_v2_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket_v2
    ADD CONSTRAINT ticket_v2_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.hall(id);


--
-- Name: ticket_v2 ticket_v2_session_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket_v2
    ADD CONSTRAINT ticket_v2_session_id_fkey FOREIGN KEY (session_id) REFERENCES public.session(id);


--
-- PostgreSQL database dump complete
--

