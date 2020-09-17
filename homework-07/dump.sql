--
-- PostgreSQL database dump
--

-- Dumped from database version 12.4
-- Dumped by pg_dump version 12.4

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
-- Name: halls; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.halls (
    id smallint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.halls OWNER TO chelout;

--
-- Name: halls_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.halls_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.halls_id_seq OWNER TO chelout;

--
-- Name: halls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.halls_id_seq OWNED BY public.halls.id;


--
-- Name: movies; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.movies (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.movies OWNER TO chelout;

--
-- Name: movies_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.movies_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movies_id_seq OWNER TO chelout;

--
-- Name: movies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.movies_id_seq OWNED BY public.movies.id;


--
-- Name: rows; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.rows (
    id smallint NOT NULL,
    hall_id smallint NOT NULL,
    number smallint NOT NULL
);


ALTER TABLE public.rows OWNER TO chelout;

--
-- Name: rows_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.rows_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rows_id_seq OWNER TO chelout;

--
-- Name: rows_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.rows_id_seq OWNED BY public.rows.id;


--
-- Name: seats; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.seats (
    id smallint NOT NULL,
    row_id smallint NOT NULL,
    number smallint NOT NULL
);


ALTER TABLE public.seats OWNER TO chelout;

--
-- Name: seats_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.seats_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seats_id_seq OWNER TO chelout;

--
-- Name: seats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.seats_id_seq OWNED BY public.seats.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.sessions (
    id integer NOT NULL,
    hall_id smallint NOT NULL,
    movie_id integer NOT NULL,
    price numeric(10,2) NOT NULL,
    starts_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.sessions OWNER TO chelout;

--
-- Name: sessions_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.sessions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sessions_id_seq OWNER TO chelout;

--
-- Name: sessions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.sessions_id_seq OWNED BY public.sessions.id;


--
-- Name: tickets; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.tickets (
    id bigint NOT NULL,
    session_id integer NOT NULL,
    seat_id smallint NOT NULL,
    created_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.tickets OWNER TO chelout;

--
-- Name: tickets_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.tickets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tickets_id_seq OWNER TO chelout;

--
-- Name: tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.tickets_id_seq OWNED BY public.tickets.id;


--
-- Name: halls id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.halls ALTER COLUMN id SET DEFAULT nextval('public.halls_id_seq'::regclass);


--
-- Name: movies id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.movies ALTER COLUMN id SET DEFAULT nextval('public.movies_id_seq'::regclass);


--
-- Name: rows id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.rows ALTER COLUMN id SET DEFAULT nextval('public.rows_id_seq'::regclass);


--
-- Name: seats id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.seats ALTER COLUMN id SET DEFAULT nextval('public.seats_id_seq'::regclass);


--
-- Name: sessions id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.sessions ALTER COLUMN id SET DEFAULT nextval('public.sessions_id_seq'::regclass);


--
-- Name: tickets id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.tickets ALTER COLUMN id SET DEFAULT nextval('public.tickets_id_seq'::regclass);


--
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (id);


--
-- Name: movies movies_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.movies
    ADD CONSTRAINT movies_pkey PRIMARY KEY (id);


--
-- Name: rows rows_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.rows
    ADD CONSTRAINT rows_pkey PRIMARY KEY (id);


--
-- Name: seats seats_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT seats_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: tickets tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_pkey PRIMARY KEY (id);


--
-- Name: rows rows_hall_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.rows
    ADD CONSTRAINT rows_hall_id_foreign FOREIGN KEY (hall_id) REFERENCES public.halls(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: seats seats_row_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT seats_row_id_foreign FOREIGN KEY (row_id) REFERENCES public.rows(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sessions sessions_hall_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_hall_id_foreign FOREIGN KEY (hall_id) REFERENCES public.halls(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sessions sessions_movie_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_movie_id_foreign FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: tickets tickets_seat_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_seat_id_foreign FOREIGN KEY (seat_id) REFERENCES public.seats(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: tickets tickets_session_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_session_id_foreign FOREIGN KEY (session_id) REFERENCES public.sessions(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

