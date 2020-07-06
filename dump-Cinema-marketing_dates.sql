--
-- PostgreSQL database dump
--

-- Dumped from database version 12.3 (Ubuntu 12.3-1.pgdg20.04+1)
-- Dumped by pg_dump version 12.2 (Ubuntu 12.2-4)

-- Started on 2020-07-06 15:05:52 MSK

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

-- Completed on 2020-07-06 15:05:52 MSK

--
-- PostgreSQL database dump complete
--

