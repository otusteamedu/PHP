drop table if exists ticket;
drop table if exists session;
drop table if exists hall;
drop table if exists cinema;
drop table if exists movie_attr_value;
drop table if exists movie_attr;
drop table if exists movie;

CREATE TABLE public.cinema (
	id serial NOT NULL,
	cinema_name varchar(255) NOT NULL,
	cinema_address varchar(255) NOT NULL,
	CONSTRAINT cinema_pkey PRIMARY KEY (id)
);

CREATE TABLE public.hall (
	hall_id serial NOT NULL,
	hall_name varchar(255) NULL,
	cinema_id int4 NULL,
	CONSTRAINT hall_pkey PRIMARY KEY (hall_id)
);

CREATE TABLE public.movie (
	movie_id serial NOT NULL,
	movie_name varchar(255) NULL,
	format varchar(2) NOT NULL,
	duration int4 NOT NULL,
	CONSTRAINT movie_pkey PRIMARY KEY (movie_id)
);

CREATE TABLE public."session" (
	session_id serial NOT NULL,
	"data" date NULL,
	"start" time NULL,
	hall_id int4 NULL,
	movie_id int4 NULL,
	price money NOT NULL,
	CONSTRAINT session_pkey PRIMARY KEY (session_id)
);

CREATE TABLE public.movie_attr (
	ma_id serial NOT NULL,
	attr_name varchar(255) NOT NULL,
	attr_type movie_attributes NULL,
	CONSTRAINT movie_attr_pkey PRIMARY KEY (ma_id)
);

CREATE TABLE public.movie_attr_value (
	mav_id serial NOT NULL,
	m_id int4 NOT NULL,
	ma_id int4 NOT NULL,
	attr_value text NULL,
	CONSTRAINT movie_attr_value_pkey PRIMARY KEY (mav_id)
);

Create or replace function random_string(length integer) returns text as
$$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$$ language plpgsql;