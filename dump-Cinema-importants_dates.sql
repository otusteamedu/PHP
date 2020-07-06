--
-- PostgreSQL database dump
--

-- Dumped from database version 12.3 (Ubuntu 12.3-1.pgdg20.04+1)
-- Dumped by pg_dump version 12.2 (Ubuntu 12.2-4)

-- Started on 2020-07-06 15:05:08 MSK

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
-- TOC entry 243 (class 1259 OID 32798)
-- Name: film_imp_dates; Type: VIEW; Schema: public; Owner: aleksei
--

CREATE VIEW public.film_imp_dates AS
 SELECT movies.name AS movie_name,
    a.name AS today_task,
    (v.value)::timestamp without time zone AS tms
   FROM ((((public.movies
     RIGHT JOIN public.movie_attributes a ON ((a.movie_attribute_group_id = 2)))
     RIGHT JOIN public.movie_attributes_groups g ON ((g.id = 2)))
     RIGHT JOIN public.movie_attributes_types t ON ((t.id = g.movie_attribute_type_id)))
     RIGHT JOIN public.movie_attribute_values v ON ((movies.id = v.movie_id)))
  WHERE ((v.movie_attribute_id = a.id) AND (((v.value)::text >= ((now())::character varying)::text) AND ((v.value)::text <= (((now() + '1 day'::interval))::character varying)::text)));


ALTER TABLE public.film_imp_dates OWNER TO aleksei;

-- Completed on 2020-07-06 15:05:08 MSK

--
-- PostgreSQL database dump complete
--

