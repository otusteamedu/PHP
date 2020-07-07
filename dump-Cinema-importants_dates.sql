--
-- PostgreSQL database dump
--

-- Dumped from database version 12.3 (Ubuntu 12.3-1.pgdg20.04+1)
-- Dumped by pg_dump version 12.2 (Ubuntu 12.2-4)

-- Started on 2020-07-07 12:59:17 MSK

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
-- TOC entry 243 (class 1259 OID 32831)
-- Name: film_imp_dates_view; Type: VIEW; Schema: public; Owner: aleksei
--

CREATE VIEW public.film_imp_dates_view AS
 SELECT movies.name AS movie_name,
    today.name AS today_task,
    future.name AS future_task,
    (v.value)::timestamp without time zone AS tms
   FROM (((((public.movie_attribute_values v
     LEFT JOIN public.movie_attributes today ON (((v.movie_attribute_id = today.id) AND ((v.value)::text >= ((now())::character varying)::text) AND ((v.value)::text <= (((now() + '1 day'::interval))::character varying)::text))))
     LEFT JOIN public.movie_attributes future ON (((v.movie_attribute_id = future.id) AND ((v.value)::text >= ((now())::character varying)::text) AND ((v.value)::text >= (((now() + '20 days'::interval))::character varying)::text))))
     LEFT JOIN public.movies ON ((v.movie_id = movies.id)))
  WHERE ((today.movie_attribute_group_id = 2) OR (future.movie_attribute_group_id = 2));


ALTER TABLE public.film_imp_dates_view OWNER TO aleksei;

-- Completed on 2020-07-07 12:59:17 MSK

--
-- PostgreSQL database dump complete
--

