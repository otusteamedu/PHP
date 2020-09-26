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

--
-- Name: gen(); Type: FUNCTION; Schema: public; Owner: chelout
--

CREATE FUNCTION public.gen() RETURNS void
    LANGUAGE plpgsql
    AS $$
  declare
    count constant int = 10;
  begin

    select
        left(md5(i::text), 10),
        md5(random()::text),
        md5(random()::text),
        left(md5(random()::text), 4)
    from generate_series(1, 10) s(i);

  end $$;


ALTER FUNCTION public.gen() OWNER TO chelout;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: attribute_movie_values; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.attribute_movie_values (
    id integer NOT NULL,
    movie_id integer NOT NULL,
    attribute_id integer NOT NULL,
    text_value text,
    string_value character varying(255),
    integer_value integer,
    money_value numeric(10,2),
    date_value date,
    boolean_value boolean
);


ALTER TABLE public.attribute_movie_values OWNER TO chelout;

--
-- Name: attribute_movie_values_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.attribute_movie_values_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attribute_movie_values_id_seq OWNER TO chelout;

--
-- Name: attribute_movie_values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.attribute_movie_values_id_seq OWNED BY public.attribute_movie_values.id;


--
-- Name: attribute_types; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.attribute_types (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.attribute_types OWNER TO chelout;

--
-- Name: attribute_types_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.attribute_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attribute_types_id_seq OWNER TO chelout;

--
-- Name: attribute_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.attribute_types_id_seq OWNED BY public.attribute_types.id;


--
-- Name: attributes; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.attributes (
    id integer NOT NULL,
    type_id smallint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.attributes OWNER TO chelout;

--
-- Name: attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.attributes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attributes_id_seq OWNER TO chelout;

--
-- Name: attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.attributes_id_seq OWNED BY public.attributes.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO chelout;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO chelout;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


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
-- Name: migrations; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO chelout;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO chelout;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


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
-- Name: password_resets; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO chelout;

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
-- Name: seat_types; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.seat_types (
    id smallint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.seat_types OWNER TO chelout;

--
-- Name: seat_types_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.seat_types_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seat_types_id_seq OWNER TO chelout;

--
-- Name: seat_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.seat_types_id_seq OWNED BY public.seat_types.id;


--
-- Name: seats; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.seats (
    id smallint NOT NULL,
    row_id smallint NOT NULL,
    type_id smallint NOT NULL,
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
-- Name: ticket_discounts; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.ticket_discounts (
    id integer NOT NULL,
    type_id smallint NOT NULL,
    discount numeric(5,4) NOT NULL
);


ALTER TABLE public.ticket_discounts OWNER TO chelout;

--
-- Name: ticket_discounts_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.ticket_discounts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ticket_discounts_id_seq OWNER TO chelout;

--
-- Name: ticket_discounts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.ticket_discounts_id_seq OWNED BY public.ticket_discounts.id;


--
-- Name: tickets; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.tickets (
    id bigint NOT NULL,
    session_id integer NOT NULL,
    seat_id smallint NOT NULL,
    cost numeric(10,2) NOT NULL,
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
-- Name: users; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO chelout;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: chelout
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO chelout;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chelout
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: attribute_movie_values id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.attribute_movie_values ALTER COLUMN id SET DEFAULT nextval('public.attribute_movie_values_id_seq'::regclass);


--
-- Name: attribute_types id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.attribute_types ALTER COLUMN id SET DEFAULT nextval('public.attribute_types_id_seq'::regclass);


--
-- Name: attributes id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.attributes ALTER COLUMN id SET DEFAULT nextval('public.attributes_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: halls id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.halls ALTER COLUMN id SET DEFAULT nextval('public.halls_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: movies id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.movies ALTER COLUMN id SET DEFAULT nextval('public.movies_id_seq'::regclass);


--
-- Name: rows id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.rows ALTER COLUMN id SET DEFAULT nextval('public.rows_id_seq'::regclass);


--
-- Name: seat_types id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.seat_types ALTER COLUMN id SET DEFAULT nextval('public.seat_types_id_seq'::regclass);


--
-- Name: seats id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.seats ALTER COLUMN id SET DEFAULT nextval('public.seats_id_seq'::regclass);


--
-- Name: sessions id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.sessions ALTER COLUMN id SET DEFAULT nextval('public.sessions_id_seq'::regclass);


--
-- Name: ticket_discounts id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.ticket_discounts ALTER COLUMN id SET DEFAULT nextval('public.ticket_discounts_id_seq'::regclass);


--
-- Name: tickets id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.tickets ALTER COLUMN id SET DEFAULT nextval('public.tickets_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: attribute_movie_values attribute_movie_values_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.attribute_movie_values
    ADD CONSTRAINT attribute_movie_values_pkey PRIMARY KEY (id);


--
-- Name: attribute_types attribute_types_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.attribute_types
    ADD CONSTRAINT attribute_types_pkey PRIMARY KEY (id);


--
-- Name: attributes attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


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
-- Name: seat_types seat_types_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.seat_types
    ADD CONSTRAINT seat_types_pkey PRIMARY KEY (id);


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
-- Name: ticket_discounts ticket_discounts_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.ticket_discounts
    ADD CONSTRAINT ticket_discounts_pkey PRIMARY KEY (id);


--
-- Name: tickets tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: chelout
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: attribute_movie_values attribute_movie_values_attribute_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.attribute_movie_values
    ADD CONSTRAINT attribute_movie_values_attribute_id_foreign FOREIGN KEY (attribute_id) REFERENCES public.attributes(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: attribute_movie_values attribute_movie_values_movie_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.attribute_movie_values
    ADD CONSTRAINT attribute_movie_values_movie_id_foreign FOREIGN KEY (movie_id) REFERENCES public.movies(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: attributes attributes_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_type_id_foreign FOREIGN KEY (type_id) REFERENCES public.attribute_types(id) ON UPDATE CASCADE ON DELETE CASCADE;


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
-- Name: seats seats_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT seats_type_id_foreign FOREIGN KEY (type_id) REFERENCES public.seat_types(id) ON UPDATE CASCADE ON DELETE CASCADE;


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
-- Name: ticket_discounts ticket_discounts_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.ticket_discounts
    ADD CONSTRAINT ticket_discounts_type_id_foreign FOREIGN KEY (type_id) REFERENCES public.seat_types(id) ON UPDATE CASCADE ON DELETE CASCADE;


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

