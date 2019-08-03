--
-- PostgreSQL database dump
--

-- Dumped from database version 11.4 (Debian 11.4-1.pgdg90+1)
-- Dumped by pg_dump version 11.4 (Debian 11.4-1.pgdg90+1)

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
-- Name: allFilms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.feedback_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public.feedback_id_seq OWNER TO postgres;

CREATE TABLE public."feedback" (
    id bigint DEFAULT nextval('public.feedback_id_seq'::regclass) NOT NULL,
    "msgText" text DEFAULT ''::text,
    "msgDate" timestamp without time zone,
    "msgAnswer" text DEFAULT ''::text,
    "msgStatus" int DEFAULT '0',
    "msgUnique"  character varying(254) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public."feedback" OWNER TO postgres;

--
-- PostgreSQL database dump complete
--

