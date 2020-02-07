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
-- Name: session_film_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.session_film_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.session_film_seq OWNER TO postgres;

--
-- Name: session_film_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.session_film_seq OWNED BY public.session.film_id;


--
-- Name: session_hall_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.session_hall_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.session_hall_seq OWNER TO postgres;

--
-- Name: session_hall_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.session_hall_seq OWNED BY public.session.hall_id;


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
-- Name: ticket_session_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ticket_session_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ticket_session_id_seq OWNER TO postgres;

--
-- Name: ticket_session_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ticket_session_id_seq OWNED BY public.ticket.session_id;


--
-- Name: client id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client ALTER COLUMN id SET DEFAULT nextval('public.client_id_seq'::regclass);


--
-- Name: film id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film ALTER COLUMN id SET DEFAULT nextval('public.film_id_seq'::regclass);


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
-- Name: session id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session ALTER COLUMN id SET DEFAULT nextval('public.session_id_seq'::regclass);


--
-- Name: session film_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session ALTER COLUMN film_id SET DEFAULT nextval('public.session_film_seq'::regclass);


--
-- Name: session hall_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session ALTER COLUMN hall_id SET DEFAULT nextval('public.session_hall_seq'::regclass);


--
-- Name: ticket id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket ALTER COLUMN id SET DEFAULT nextval('public.ticket_id_seq'::regclass);


--
-- Name: ticket session_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket ALTER COLUMN session_id SET DEFAULT nextval('public.ticket_session_id_seq'::regclass);


--
-- Name: client client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id);


--
-- Name: client_ticket client_ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_ticket
    ADD CONSTRAINT client_ticket_pkey PRIMARY KEY (client_id, ticket_id);


--
-- Name: film_attribute film_attribute_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute
    ADD CONSTRAINT film_attribute_pkey PRIMARY KEY (id);


--
-- Name: film_attribute_type film_attribute_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_type
    ADD CONSTRAINT film_attribute_type_pkey PRIMARY KEY (id);


--
-- Name: film_attribute_value film_attribute_value_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_value
    ADD CONSTRAINT film_attribute_value_pkey PRIMARY KEY (id);


--
-- Name: film film_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film
    ADD CONSTRAINT film_pkey PRIMARY KEY (id);


--
-- Name: hall hall_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hall
    ADD CONSTRAINT hall_pkey PRIMARY KEY (id);


--
-- Name: session session_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_pkey PRIMARY KEY (id);


--
-- Name: ticket ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_pkey PRIMARY KEY (id);


--
-- Name: film_attribute_type_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX film_attribute_type_id_idx ON public.film_attribute USING btree (type_id);


--
-- Name: film_attribute_value_attribute_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX film_attribute_value_attribute_id_idx ON public.film_attribute_value USING btree (attribute_id);


--
-- Name: film_attribute_value_film_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX film_attribute_value_film_id_idx ON public.film_attribute_value USING btree (film_id);


--
-- Name: session_film_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX session_film_id_idx ON public.session USING btree (film_id);


--
-- Name: session_hall_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX session_hall_id_idx ON public.session USING btree (hall_id);


--
-- Name: ticket_session_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ticket_session_id_idx ON public.ticket USING btree (session_id);


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
-- Name: session session_film_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_film_fkey FOREIGN KEY (film_id) REFERENCES public.film(id);


--
-- Name: session session_hall_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_hall_fkey FOREIGN KEY (hall_id) REFERENCES public.hall(id);


--
-- Name: ticket ticket_session_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_session_id_fkey FOREIGN KEY (session_id) REFERENCES public.session(id);


--
-- PostgreSQL database dump complete
--

