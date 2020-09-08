--
-- PostgreSQL database dump
--

-- Dumped from database version 12.2 (Ubuntu 12.2-2.pgdg18.04+1)
-- Dumped by pg_dump version 12.2 (Ubuntu 12.2-2.pgdg18.04+1)

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
-- Name: films; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    duration time without time zone NOT NULL
);


ALTER TABLE public.films OWNER TO postgres;

--
-- Name: films_attrs_vals; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films_attrs_vals (
    id integer NOT NULL,
    film_id integer,
    attrs_id smallint,
    int_val integer,
    date_val timestamp without time zone,
    text_val text,
    float_val numeric
);


ALTER TABLE public.films_attrs_vals OWNER TO postgres;

--
-- Name: films_attr_vals_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.films_attr_vals_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.films_attr_vals_id_seq OWNER TO postgres;

--
-- Name: films_attr_vals_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.films_attr_vals_id_seq OWNED BY public.films_attrs_vals.id;


--
-- Name: films_attrs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films_attrs (
    id smallint NOT NULL,
    type_id smallint,
    name character varying(255)
);


ALTER TABLE public.films_attrs OWNER TO postgres;

--
-- Name: films_attrs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.films_attrs_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.films_attrs_id_seq OWNER TO postgres;

--
-- Name: films_attrs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.films_attrs_id_seq OWNED BY public.films_attrs.id;


--
-- Name: films_attrs_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films_attrs_types (
    id smallint NOT NULL,
    descr character varying(500),
    type character varying(20) NOT NULL
);


ALTER TABLE public.films_attrs_types OWNER TO postgres;

--
-- Name: films_attrs_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.films_attrs_types_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.films_attrs_types_id_seq OWNER TO postgres;

--
-- Name: films_attrs_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.films_attrs_types_id_seq OWNED BY public.films_attrs_types.id;


--
-- Name: films_attrs_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.films_attrs_view AS
 SELECT f.name AS film,
    ft.descr AS attr_type,
    fa.name AS attr_name,
    COALESCE((fv.int_val)::text, (fv.date_val)::text, fv.text_val, (fv.float_val)::text) AS attr_value
   FROM (((public.films f
     JOIN public.films_attrs_vals fv ON ((f.id = fv.film_id)))
     LEFT JOIN public.films_attrs fa ON ((fv.attrs_id = fa.id)))
     LEFT JOIN public.films_attrs_types ft ON ((fa.type_id = ft.id)));


ALTER TABLE public.films_attrs_view OWNER TO postgres;

--
-- Name: films_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.films_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.films_id_seq OWNER TO postgres;

--
-- Name: films_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.films_id_seq OWNED BY public.films.id;


--
-- Name: halls; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.halls (
    id smallint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.halls OWNER TO postgres;

--
-- Name: halls_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.halls_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.halls_id_seq OWNER TO postgres;

--
-- Name: halls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.halls_id_seq OWNED BY public.halls.id;


--
-- Name: rows_seats; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rows_seats (
    id smallint NOT NULL,
    hall_id smallint NOT NULL,
    "row" smallint NOT NULL
);


ALTER TABLE public.rows_seats OWNER TO postgres;

--
-- Name: rows_seats_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.rows_seats_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rows_seats_id_seq OWNER TO postgres;

--
-- Name: rows_seats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.rows_seats_id_seq OWNED BY public.rows_seats.id;


--
-- Name: seats; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seats (
    id smallint NOT NULL,
    row_id smallint NOT NULL,
    number smallint NOT NULL,
    price_coef numeric(2,0) DEFAULT 1 NOT NULL
);


ALTER TABLE public.seats OWNER TO postgres;

--
-- Name: seats_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seats_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seats_id_seq OWNER TO postgres;

--
-- Name: seats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.seats_id_seq OWNED BY public.seats.id;


--
-- Name: service_tasks; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.service_tasks AS
 SELECT f.name AS film,
    fa.name AS today,
    NULL::character varying AS tw_days
   FROM ((public.films f
     LEFT JOIN public.films_attrs_vals fv ON ((f.id = fv.film_id)))
     JOIN public.films_attrs fa ON ((fa.id = fv.attrs_id)))
  WHERE ((fa.type_id = 7) AND (fv.date_val >= CURRENT_DATE) AND (fv.date_val < (CURRENT_DATE + '1 day'::interval)))
UNION ALL
 SELECT f.name AS film,
    NULL::character varying AS today,
    fa.name AS tw_days
   FROM ((public.films f
     LEFT JOIN public.films_attrs_vals fv ON ((f.id = fv.film_id)))
     JOIN public.films_attrs fa ON ((fa.id = fv.attrs_id)))
  WHERE ((fa.type_id = 7) AND (fv.date_val >= (CURRENT_DATE + '20 days'::interval)) AND (fv.date_val < (CURRENT_DATE + '21 days'::interval)));


ALTER TABLE public.service_tasks OWNER TO postgres;

--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id integer NOT NULL,
    hall_id smallint NOT NULL,
    film_id integer NOT NULL,
    price money NOT NULL,
    date timestamp without time zone
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: sessions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sessions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sessions_id_seq OWNER TO postgres;

--
-- Name: sessions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sessions_id_seq OWNED BY public.sessions.id;


--
-- Name: tickets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tickets (
    id bigint NOT NULL,
    seat_id smallint NOT NULL,
    session_id bigint NOT NULL,
    created timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    cost money NOT NULL
);


ALTER TABLE public.tickets OWNER TO postgres;

--
-- Name: tickets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tickets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tickets_id_seq OWNER TO postgres;

--
-- Name: tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tickets_id_seq OWNED BY public.tickets.id;


--
-- Name: films id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films ALTER COLUMN id SET DEFAULT nextval('public.films_id_seq'::regclass);


--
-- Name: films_attrs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_attrs ALTER COLUMN id SET DEFAULT nextval('public.films_attrs_id_seq'::regclass);


--
-- Name: films_attrs_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_attrs_types ALTER COLUMN id SET DEFAULT nextval('public.films_attrs_types_id_seq'::regclass);


--
-- Name: films_attrs_vals id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_attrs_vals ALTER COLUMN id SET DEFAULT nextval('public.films_attr_vals_id_seq'::regclass);


--
-- Name: halls id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls ALTER COLUMN id SET DEFAULT nextval('public.halls_id_seq'::regclass);


--
-- Name: rows_seats id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rows_seats ALTER COLUMN id SET DEFAULT nextval('public.rows_seats_id_seq'::regclass);


--
-- Name: seats id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seats ALTER COLUMN id SET DEFAULT nextval('public.seats_id_seq'::regclass);


--
-- Name: sessions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions ALTER COLUMN id SET DEFAULT nextval('public.sessions_id_seq'::regclass);


--
-- Name: tickets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets ALTER COLUMN id SET DEFAULT nextval('public.tickets_id_seq'::regclass);


--
-- Name: films_attrs_vals films_attr_vals_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_attrs_vals
    ADD CONSTRAINT films_attr_vals_pkey PRIMARY KEY (id);


--
-- Name: films_attrs films_attrs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_attrs
    ADD CONSTRAINT films_attrs_pkey PRIMARY KEY (id);


--
-- Name: films_attrs_types films_attrs_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_attrs_types
    ADD CONSTRAINT films_attrs_types_pkey PRIMARY KEY (id);


--
-- Name: films films_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_pkey PRIMARY KEY (id);


--
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (id);


--
-- Name: rows_seats rows_seats_hall_id_row_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rows_seats
    ADD CONSTRAINT rows_seats_hall_id_row_key UNIQUE (hall_id, "row");


--
-- Name: rows_seats rows_seats_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rows_seats
    ADD CONSTRAINT rows_seats_pkey PRIMARY KEY (id);


--
-- Name: seats seats_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT seats_pkey PRIMARY KEY (id);


--
-- Name: seats seats_row_id_number_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT seats_row_id_number_key UNIQUE (row_id, number);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: tickets tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_pkey PRIMARY KEY (id);


--
-- Name: tickets tickets_seat_id_session_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_seat_id_session_id_key UNIQUE (seat_id, session_id);


--
-- Name: films_attrs_vals films_attr_vals_attrs_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_attrs_vals
    ADD CONSTRAINT films_attr_vals_attrs_id_fkey FOREIGN KEY (attrs_id) REFERENCES public.films_attrs(id);


--
-- Name: films_attrs_vals films_attr_vals_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_attrs_vals
    ADD CONSTRAINT films_attr_vals_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.films(id);


--
-- Name: films_attrs films_attrs_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_attrs
    ADD CONSTRAINT films_attrs_type_id_fkey FOREIGN KEY (type_id) REFERENCES public.films_attrs_types(id);


--
-- Name: rows_seats rows_seats_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rows_seats
    ADD CONSTRAINT rows_seats_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id);


--
-- Name: seats seats_row_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT seats_row_id_fkey FOREIGN KEY (row_id) REFERENCES public.rows_seats(id);


--
-- Name: sessions sessions_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.films(id);


--
-- Name: sessions sessions_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id);


--
-- Name: tickets tickets_seat_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_seat_id_fkey FOREIGN KEY (seat_id) REFERENCES public.seats(id);


--
-- Name: tickets tickets_session_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_session_id_fkey FOREIGN KEY (session_id) REFERENCES public.sessions(id);


--
-- Name: TABLE films; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.films TO cinema;


--
-- Name: TABLE films_attrs_vals; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.films_attrs_vals TO cinema;


--
-- Name: SEQUENCE films_attr_vals_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.films_attr_vals_id_seq TO cinema;


--
-- Name: TABLE films_attrs; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.films_attrs TO cinema;


--
-- Name: SEQUENCE films_attrs_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.films_attrs_id_seq TO cinema;


--
-- Name: TABLE films_attrs_types; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.films_attrs_types TO cinema;


--
-- Name: SEQUENCE films_attrs_types_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.films_attrs_types_id_seq TO cinema;


--
-- Name: SEQUENCE films_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.films_id_seq TO cinema;


--
-- Name: TABLE halls; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.halls TO cinema;


--
-- Name: SEQUENCE halls_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.halls_id_seq TO cinema;


--
-- Name: TABLE rows_seats; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.rows_seats TO cinema;


--
-- Name: SEQUENCE rows_seats_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.rows_seats_id_seq TO cinema;


--
-- Name: TABLE seats; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.seats TO cinema;


--
-- Name: SEQUENCE seats_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.seats_id_seq TO cinema;


--
-- Name: TABLE sessions; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.sessions TO cinema;


--
-- Name: SEQUENCE sessions_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.sessions_id_seq TO cinema;


--
-- Name: TABLE tickets; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.tickets TO cinema;


--
-- Name: SEQUENCE tickets_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE public.tickets_id_seq TO cinema;


--
-- PostgreSQL database dump complete
--

