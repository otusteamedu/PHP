-- Database generated with pgModeler (PostgreSQL Database Modeler).
-- pgModeler  version: 0.9.2
-- PostgreSQL version: 12.0
-- Project Site: pgmodeler.io
-- Model Author: NickoLaz

SET check_function_bodies = false;
-- ddl-end --


-- Database creation must be done outside a multicommand file.
-- These commands were put in this file only as a convenience.
-- -- object: cinema_hw8 | type: DATABASE --
-- -- DROP DATABASE IF EXISTS cinema_hw8;
-- CREATE DATABASE cinema_hw8
-- 	ENCODING = 'UTF8'
-- 	LC_COLLATE = 'ru_RU.UTF-8'
-- 	LC_CTYPE = 'ru_RU.UTF-8'
-- 	TABLESPACE = pg_default
-- 	OWNER = postgres;
-- -- ddl-end --
-- 

-- object: public.halls | type: TABLE --
-- DROP TABLE IF EXISTS public.halls CASCADE;
CREATE TABLE public.halls (
	id smallserial NOT NULL,
	name varchar NOT NULL,
	comment varchar,
	CONSTRAINT hall_pk PRIMARY KEY (id)

);
-- ddl-end --
-- ALTER TABLE public.halls OWNER TO postgres;
-- ddl-end --

-- object: public.films | type: TABLE --
-- DROP TABLE IF EXISTS public.films CASCADE;
CREATE TABLE public.films (
	id serial NOT NULL,
	name varchar NOT NULL,
	duration smallint NOT NULL,
	comment varchar,
	CONSTRAINT films_pk PRIMARY KEY (id)

);
-- ddl-end --
COMMENT ON COLUMN public.films.duration IS E'В минутах';
-- ddl-end --
-- ALTER TABLE public.films OWNER TO postgres;
-- ddl-end --

-- -- object: pg_catalog.int4eq | type: FUNCTION --
-- -- DROP FUNCTION IF EXISTS pg_catalog.int4eq(integer,integer) CASCADE;
-- CREATE FUNCTION pg_catalog.int4eq ( _param1 integer,  _param2 integer)
-- 	RETURNS boolean
-- 	LANGUAGE internal
-- 	IMMUTABLE LEAKPROOF
-- 	STRICT
-- 	SECURITY INVOKER
-- 	COST 1
-- 	AS $$
-- int4eq
-- $$;
-- -- ddl-end --
-- -- ALTER FUNCTION pg_catalog.int4eq(integer,integer) OWNER TO postgres;
-- -- ddl-end --
-- COMMENT ON FUNCTION pg_catalog.int4eq(integer,integer) IS E'implementation of = operator';
-- -- ddl-end --
-- 
-- object: public.tickets | type: TABLE --
-- DROP TABLE IF EXISTS public.tickets CASCADE;
CREATE TABLE public.tickets (
	uuid uuid NOT NULL,
	id_operators smallint,
	datetime timestamp NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (uuid)

);
-- ddl-end --
-- ALTER TABLE public.tickets OWNER TO postgres;
-- ddl-end --

-- -- object: pg_catalog.eqsel | type: FUNCTION --
-- -- DROP FUNCTION IF EXISTS pg_catalog.eqsel(internal,oid,internal,integer) CASCADE;
-- CREATE FUNCTION pg_catalog.eqsel ( _param1 internal,  _param2 oid,  _param3 internal,  _param4 integer)
-- 	RETURNS double precision
-- 	LANGUAGE internal
-- 	STABLE 
-- 	STRICT
-- 	SECURITY INVOKER
-- 	COST 1
-- 	AS $$
-- eqsel
-- $$;
-- -- ddl-end --
-- -- ALTER FUNCTION pg_catalog.eqsel(internal,oid,internal,integer) OWNER TO postgres;
-- -- ddl-end --
-- COMMENT ON FUNCTION pg_catalog.eqsel(internal,oid,internal,integer) IS E'restriction selectivity of = and related operators';
-- -- ddl-end --
-- 
-- -- object: pg_catalog.eqjoinsel | type: FUNCTION --
-- -- DROP FUNCTION IF EXISTS pg_catalog.eqjoinsel(internal,oid,internal,smallint,internal) CASCADE;
-- CREATE FUNCTION pg_catalog.eqjoinsel ( _param1 internal,  _param2 oid,  _param3 internal,  _param4 smallint,  _param5 internal)
-- 	RETURNS double precision
-- 	LANGUAGE internal
-- 	STABLE 
-- 	STRICT
-- 	SECURITY INVOKER
-- 	COST 1
-- 	AS $$
-- eqjoinsel
-- $$;
-- -- ddl-end --
-- -- ALTER FUNCTION pg_catalog.eqjoinsel(internal,oid,internal,smallint,internal) OWNER TO postgres;
-- -- ddl-end --
-- COMMENT ON FUNCTION pg_catalog.eqjoinsel(internal,oid,internal,smallint,internal) IS E'join selectivity of = and related operators';
-- -- ddl-end --
-- 
-- -- object: pg_catalog.= | type: OPERATOR --
-- -- DROP OPERATOR IF EXISTS pg_catalog.=(integer,integer) CASCADE;
-- CREATE OPERATOR pg_catalog.= (
-- 	PROCEDURE = pg_catalog.int4eq
-- 	, LEFTARG = integer
-- 	, RIGHTARG = integer
-- 	, RESTRICT = pg_catalog.eqsel
-- 	, JOIN = pg_catalog.eqjoinsel);
-- -- ddl-end --
-- -- ALTER OPERATOR pg_catalog.=(integer,integer) OWNER TO postgres;
-- -- ddl-end --
-- COMMENT ON OPERATOR pg_catalog.=(integer,integer) IS E'equal';
-- -- ddl-end --
-- 
-- -- object: pg_catalog.range_overlaps | type: FUNCTION --
-- -- DROP FUNCTION IF EXISTS pg_catalog.range_overlaps(anyrange,anyrange) CASCADE;
-- CREATE FUNCTION pg_catalog.range_overlaps ( _param1 anyrange,  _param2 anyrange)
-- 	RETURNS boolean
-- 	LANGUAGE internal
-- 	IMMUTABLE 
-- 	STRICT
-- 	SECURITY INVOKER
-- 	COST 1
-- 	AS $$
-- range_overlaps
-- $$;
-- -- ddl-end --
-- -- ALTER FUNCTION pg_catalog.range_overlaps(anyrange,anyrange) OWNER TO postgres;
-- -- ddl-end --
-- COMMENT ON FUNCTION pg_catalog.range_overlaps(anyrange,anyrange) IS E'implementation of && operator';
-- -- ddl-end --
-- 
-- -- object: pg_catalog.rangesel | type: FUNCTION --
-- -- DROP FUNCTION IF EXISTS pg_catalog.rangesel(internal,oid,internal,integer) CASCADE;
-- CREATE FUNCTION pg_catalog.rangesel ( _param1 internal,  _param2 oid,  _param3 internal,  _param4 integer)
-- 	RETURNS double precision
-- 	LANGUAGE internal
-- 	STABLE 
-- 	STRICT
-- 	SECURITY INVOKER
-- 	COST 1
-- 	AS $$
-- rangesel
-- $$;
-- -- ddl-end --
-- -- ALTER FUNCTION pg_catalog.rangesel(internal,oid,internal,integer) OWNER TO postgres;
-- -- ddl-end --
-- COMMENT ON FUNCTION pg_catalog.rangesel(internal,oid,internal,integer) IS E'restriction selectivity for range operators';
-- -- ddl-end --
-- 
-- -- object: pg_catalog.areajoinsel | type: FUNCTION --
-- -- DROP FUNCTION IF EXISTS pg_catalog.areajoinsel(internal,oid,internal,smallint,internal) CASCADE;
-- CREATE FUNCTION pg_catalog.areajoinsel ( _param1 internal,  _param2 oid,  _param3 internal,  _param4 smallint,  _param5 internal)
-- 	RETURNS double precision
-- 	LANGUAGE internal
-- 	STABLE 
-- 	STRICT
-- 	SECURITY INVOKER
-- 	COST 1
-- 	AS $$
-- areajoinsel
-- $$;
-- -- ddl-end --
-- -- ALTER FUNCTION pg_catalog.areajoinsel(internal,oid,internal,smallint,internal) OWNER TO postgres;
-- -- ddl-end --
-- COMMENT ON FUNCTION pg_catalog.areajoinsel(internal,oid,internal,smallint,internal) IS E'join selectivity for area-comparison operators';
-- -- ddl-end --
-- 
-- -- object: pg_catalog.&& | type: OPERATOR --
-- -- DROP OPERATOR IF EXISTS pg_catalog.&&(anyrange,anyrange) CASCADE;
-- CREATE OPERATOR pg_catalog.&& (
-- 	PROCEDURE = pg_catalog.range_overlaps
-- 	, LEFTARG = anyrange
-- 	, RIGHTARG = anyrange
-- 	, RESTRICT = pg_catalog.rangesel
-- 	, JOIN = pg_catalog.areajoinsel);
-- -- ddl-end --
-- -- ALTER OPERATOR pg_catalog.&&(anyrange,anyrange) OWNER TO postgres;
-- -- ddl-end --
-- COMMENT ON OPERATOR pg_catalog.&&(anyrange,anyrange) IS E'overlaps';
-- -- ddl-end --
-- 
-- object: btree_gist | type: Generic SQL Object --
CREATE EXTENSION btree_gist;
-- ddl-end --

-- object: public.timetable | type: TABLE --
-- DROP TABLE IF EXISTS public.timetable CASCADE;
CREATE TABLE public.timetable (
	datetime_range tsrange NOT NULL,
	id_hall_scheme_versions smallint NOT NULL,
	id_films integer,
	CONSTRAINT timetable_pk PRIMARY KEY (datetime_range,id_hall_scheme_versions)

);
-- ddl-end --
-- ALTER TABLE public.timetable OWNER TO postgres;
-- ddl-end --

-- object: films_fk | type: CONSTRAINT --
-- ALTER TABLE public.timetable DROP CONSTRAINT IF EXISTS films_fk CASCADE;
ALTER TABLE public.timetable ADD CONSTRAINT films_fk FOREIGN KEY (id_films)
REFERENCES public.films (id) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- -- object: pg_catalog.integer_ops | type: OPERATOR FAMILY --
-- -- DROP OPERATOR FAMILY IF EXISTS pg_catalog.integer_ops USING btree CASCADE;
-- CREATE OPERATOR FAMILY pg_catalog.integer_ops USING btree;
-- -- ddl-end --
-- -- ALTER OPERATOR FAMILY pg_catalog.integer_ops USING btree OWNER TO postgres;
-- -- ddl-end --
-- 
-- -- object: pg_catalog.integer_ops | type: OPERATOR FAMILY --
-- -- DROP OPERATOR FAMILY IF EXISTS pg_catalog.integer_ops USING hash CASCADE;
-- CREATE OPERATOR FAMILY pg_catalog.integer_ops USING hash;
-- -- ddl-end --
-- -- ALTER OPERATOR FAMILY pg_catalog.integer_ops USING hash OWNER TO postgres;
-- -- ddl-end --
-- 
-- -- object: pg_catalog.integer_minmax_ops | type: OPERATOR FAMILY --
-- -- DROP OPERATOR FAMILY IF EXISTS pg_catalog.integer_minmax_ops USING brin CASCADE;
-- CREATE OPERATOR FAMILY pg_catalog.integer_minmax_ops USING brin;
-- -- ddl-end --
-- -- ALTER OPERATOR FAMILY pg_catalog.integer_minmax_ops USING brin OWNER TO postgres;
-- -- ddl-end --
-- 
-- object: public.hall_scheme | type: TABLE --
-- DROP TABLE IF EXISTS public.hall_scheme CASCADE;
CREATE TABLE public.hall_scheme (
	id_hall_scheme_versions smallint NOT NULL,
	"row" smallint NOT NULL,
	place smallint NOT NULL,
	id_hall_scheme_place_types smallint,
	available boolean NOT NULL DEFAULT true,
	CONSTRAINT hall_scheme_pk PRIMARY KEY ("row",place,id_hall_scheme_versions)

);
-- ddl-end --
-- ALTER TABLE public.hall_scheme OWNER TO postgres;
-- ddl-end --

-- object: public.hall_scheme_place_types | type: TABLE --
-- DROP TABLE IF EXISTS public.hall_scheme_place_types CASCADE;
CREATE TABLE public.hall_scheme_place_types (
	id smallint NOT NULL,
	name varchar NOT NULL,
	comment varchar,
	CONSTRAINT hall_scheme_places_type_pk PRIMARY KEY (id)

);
-- ddl-end --
-- ALTER TABLE public.hall_scheme_place_types OWNER TO postgres;
-- ddl-end --

-- object: hall_scheme_place_types_fk | type: CONSTRAINT --
-- ALTER TABLE public.hall_scheme DROP CONSTRAINT IF EXISTS hall_scheme_place_types_fk CASCADE;
ALTER TABLE public.hall_scheme ADD CONSTRAINT hall_scheme_place_types_fk FOREIGN KEY (id_hall_scheme_place_types)
REFERENCES public.hall_scheme_place_types (id) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: public.hall_scheme_versions | type: TABLE --
-- DROP TABLE IF EXISTS public.hall_scheme_versions CASCADE;
CREATE TABLE public.hall_scheme_versions (
	id smallint NOT NULL,
	id_halls smallint,
	name varchar NOT NULL,
	date_time_range tsrange,
	comment varchar,
	CONSTRAINT hall_scheme_versions_pk PRIMARY KEY (id)

);
-- ddl-end --
-- ALTER TABLE public.hall_scheme_versions OWNER TO postgres;
-- ddl-end --

-- object: halls_fk | type: CONSTRAINT --
-- ALTER TABLE public.hall_scheme_versions DROP CONSTRAINT IF EXISTS halls_fk CASCADE;
ALTER TABLE public.hall_scheme_versions ADD CONSTRAINT halls_fk FOREIGN KEY (id_halls)
REFERENCES public.halls (id) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: hall_scheme_versions_fk | type: CONSTRAINT --
-- ALTER TABLE public.hall_scheme DROP CONSTRAINT IF EXISTS hall_scheme_versions_fk CASCADE;
ALTER TABLE public.hall_scheme ADD CONSTRAINT hall_scheme_versions_fk FOREIGN KEY (id_hall_scheme_versions)
REFERENCES public.hall_scheme_versions (id) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: hall_scheme_versions_ex | type: CONSTRAINT --
-- ALTER TABLE public.hall_scheme_versions DROP CONSTRAINT IF EXISTS hall_scheme_versions_ex CASCADE;
ALTER TABLE public.hall_scheme_versions ADD CONSTRAINT hall_scheme_versions_ex EXCLUDE 
	USING gist(
	  id_halls WITH pg_catalog.=,
	  date_time_range WITH pg_catalog.&&
	);
-- ddl-end --

-- object: hall_scheme_versions_fk | type: CONSTRAINT --
-- ALTER TABLE public.timetable DROP CONSTRAINT IF EXISTS hall_scheme_versions_fk CASCADE;
ALTER TABLE public.timetable ADD CONSTRAINT hall_scheme_versions_fk FOREIGN KEY (id_hall_scheme_versions)
REFERENCES public.hall_scheme_versions (id) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: timetable_ex | type: CONSTRAINT --
-- ALTER TABLE public.timetable DROP CONSTRAINT IF EXISTS timetable_ex CASCADE;
ALTER TABLE public.timetable ADD CONSTRAINT timetable_ex EXCLUDE 
	USING gist(
	  id_hall_scheme_versions WITH pg_catalog.=,
	  datetime_range WITH pg_catalog.&&
	);
-- ddl-end --

-- object: public.prices_calc | type: TABLE --
-- DROP TABLE IF EXISTS public.prices_calc CASCADE;
CREATE TABLE public.prices_calc (
	id_price_calc_versions smallint NOT NULL,
	datetime_range_timetable tsrange NOT NULL,
	id_hall_scheme_versions_timetable smallint NOT NULL,
	id_hall_scheme_place_types smallint NOT NULL,
	id_price_variants smallint NOT NULL,
	price money NOT NULL,
	CONSTRAINT prices_calc_pk PRIMARY KEY (id_hall_scheme_place_types,datetime_range_timetable,id_hall_scheme_versions_timetable,id_price_calc_versions,id_price_variants)

);
-- ddl-end --
-- ALTER TABLE public.prices_calc OWNER TO postgres;
-- ddl-end --

-- object: hall_scheme_place_types_fk | type: CONSTRAINT --
-- ALTER TABLE public.prices_calc DROP CONSTRAINT IF EXISTS hall_scheme_place_types_fk CASCADE;
ALTER TABLE public.prices_calc ADD CONSTRAINT hall_scheme_place_types_fk FOREIGN KEY (id_hall_scheme_place_types)
REFERENCES public.hall_scheme_place_types (id) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: public.price_calc_versions | type: TABLE --
-- DROP TABLE IF EXISTS public.price_calc_versions CASCADE;
CREATE TABLE public.price_calc_versions (
	id smallint NOT NULL,
	name varchar NOT NULL,
	date_time_range tsrange NOT NULL,
	comment varchar,
	CONSTRAINT price_versions_pk PRIMARY KEY (id)

);
-- ddl-end --
-- ALTER TABLE public.price_calc_versions OWNER TO postgres;
-- ddl-end --

-- object: timetable_fk | type: CONSTRAINT --
-- ALTER TABLE public.prices_calc DROP CONSTRAINT IF EXISTS timetable_fk CASCADE;
ALTER TABLE public.prices_calc ADD CONSTRAINT timetable_fk FOREIGN KEY (datetime_range_timetable,id_hall_scheme_versions_timetable)
REFERENCES public.timetable (datetime_range,id_hall_scheme_versions) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: price_calc_versions_fk | type: CONSTRAINT --
-- ALTER TABLE public.prices_calc DROP CONSTRAINT IF EXISTS price_calc_versions_fk CASCADE;
ALTER TABLE public.prices_calc ADD CONSTRAINT price_calc_versions_fk FOREIGN KEY (id_price_calc_versions)
REFERENCES public.price_calc_versions (id) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: public.price_variants | type: TABLE --
-- DROP TABLE IF EXISTS public.price_variants CASCADE;
CREATE TABLE public.price_variants (
	id smallint NOT NULL,
	name varchar NOT NULL,
	calc_scheme varchar,
	CONSTRAINT price_variants_pk PRIMARY KEY (id)

);
-- ddl-end --
-- ALTER TABLE public.price_variants OWNER TO postgres;
-- ddl-end --

-- object: price_variants_fk | type: CONSTRAINT --
-- ALTER TABLE public.prices_calc DROP CONSTRAINT IF EXISTS price_variants_fk CASCADE;
ALTER TABLE public.prices_calc ADD CONSTRAINT price_variants_fk FOREIGN KEY (id_price_variants)
REFERENCES public.price_variants (id) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: public.sales | type: TABLE --
-- DROP TABLE IF EXISTS public.sales CASCADE;
CREATE TABLE public.sales (
	datetime_range_timetable_prices_calc tsrange NOT NULL,
	id_hall_scheme_versions_timetable_prices_calc smallint NOT NULL,
	"row" smallint NOT NULL,
	place smallint NOT NULL,
	id_price_calc_versions_prices_calc smallint,
	id_hall_scheme_place_types_prices_calc smallint,
	id_price_variants_prices_calc smallint,
	uuid_tickets uuid,
	CONSTRAINT sales_pk PRIMARY KEY ("row",place,datetime_range_timetable_prices_calc,id_hall_scheme_versions_timetable_prices_calc)

);
-- ddl-end --
-- ALTER TABLE public.sales OWNER TO postgres;
-- ddl-end --

-- object: prices_calc_fk | type: CONSTRAINT --
-- ALTER TABLE public.sales DROP CONSTRAINT IF EXISTS prices_calc_fk CASCADE;
ALTER TABLE public.sales ADD CONSTRAINT prices_calc_fk FOREIGN KEY (id_hall_scheme_place_types_prices_calc,datetime_range_timetable_prices_calc,id_hall_scheme_versions_timetable_prices_calc,id_price_calc_versions_prices_calc,id_price_variants_prices_calc)
REFERENCES public.prices_calc (id_hall_scheme_place_types,datetime_range_timetable,id_hall_scheme_versions_timetable,id_price_calc_versions,id_price_variants) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: tickets_fk | type: CONSTRAINT --
-- ALTER TABLE public.sales DROP CONSTRAINT IF EXISTS tickets_fk CASCADE;
ALTER TABLE public.sales ADD CONSTRAINT tickets_fk FOREIGN KEY (uuid_tickets)
REFERENCES public.tickets (uuid) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --

-- object: sales_uq | type: CONSTRAINT --
-- ALTER TABLE public.sales DROP CONSTRAINT IF EXISTS sales_uq CASCADE;
ALTER TABLE public.sales ADD CONSTRAINT sales_uq UNIQUE (uuid_tickets);
-- ddl-end --

-- object: public.operators | type: TABLE --
-- DROP TABLE IF EXISTS public.operators CASCADE;
CREATE TABLE public.operators (
	id smallint NOT NULL,
	fio varchar NOT NULL,
	CONSTRAINT operators_pk PRIMARY KEY (id)

);
-- ddl-end --
-- ALTER TABLE public.operators OWNER TO postgres;
-- ddl-end --

-- object: operators_fk | type: CONSTRAINT --
-- ALTER TABLE public.tickets DROP CONSTRAINT IF EXISTS operators_fk CASCADE;
ALTER TABLE public.tickets ADD CONSTRAINT operators_fk FOREIGN KEY (id_operators)
REFERENCES public.operators (id) MATCH FULL
ON DELETE RESTRICT ON UPDATE CASCADE;
-- ddl-end --


