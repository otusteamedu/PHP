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
-- Name: attribute_movie_values; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.attribute_movie_values (
    id integer NOT NULL,
    movie_id integer NOT NULL,
    attribute_id integer NOT NULL,
    text_value text,
    string_value text,
    integer_value integer,
    money_value numeric(10,2),
    float_value double precision,
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
-- Name: movies; Type: TABLE; Schema: public; Owner: chelout
--

CREATE TABLE public.movies (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.movies OWNER TO chelout;

--
-- Name: marketing_view; Type: VIEW; Schema: public; Owner: chelout
--

CREATE VIEW public.marketing_view AS
 SELECT movies.name AS movie_name,
    attribute_types.name AS attribute_type,
    attributes.name AS attribute_name,
    COALESCE(attribute_movie_values.text_value, attribute_movie_values.string_value, (attribute_movie_values.integer_value)::text, (attribute_movie_values.money_value)::text, (attribute_movie_values.float_value)::text, (attribute_movie_values.date_value)::text, (attribute_movie_values.boolean_value)::text) AS attribute_value
   FROM (((public.movies
     LEFT JOIN public.attribute_movie_values ON ((attribute_movie_values.movie_id = movies.id)))
     LEFT JOIN public.attributes ON ((attributes.id = attribute_movie_values.attribute_id)))
     LEFT JOIN public.attribute_types ON ((attribute_types.id = attributes.type_id)))
  ORDER BY movies.id;


ALTER TABLE public.marketing_view OWNER TO chelout;

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
-- Name: service_view; Type: VIEW; Schema: public; Owner: chelout
--

CREATE VIEW public.service_view AS
 SELECT movies.name,
        CASE
            WHEN (attribute_movie_values.date_value = CURRENT_DATE) THEN attributes.name
            ELSE NULL::character varying
        END AS today,
        CASE
            WHEN ((attribute_movie_values.date_value >= (CURRENT_DATE + 10)) AND (attribute_movie_values.date_value <= (CURRENT_DATE + 30))) THEN attributes.name
            ELSE NULL::character varying
        END AS other_day
   FROM ((public.movies
     LEFT JOIN public.attribute_movie_values ON ((attribute_movie_values.movie_id = movies.id)))
     LEFT JOIN public.attributes ON ((attributes.id = attribute_movie_values.attribute_id)))
  WHERE ((attribute_movie_values.date_value = CURRENT_DATE) OR ((attribute_movie_values.date_value >= (CURRENT_DATE + 10)) AND (attribute_movie_values.date_value <= (CURRENT_DATE + 30))))
  ORDER BY movies.id;


ALTER TABLE public.service_view OWNER TO chelout;

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
-- Name: movies id; Type: DEFAULT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.movies ALTER COLUMN id SET DEFAULT nextval('public.movies_id_seq'::regclass);


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
-- Name: movies movies_pkey; Type: CONSTRAINT; Schema: public; Owner: chelout
--

ALTER TABLE ONLY public.movies
    ADD CONSTRAINT movies_pkey PRIMARY KEY (id);


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
-- PostgreSQL database dump complete
--

