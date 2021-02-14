CREATE TABLE public.halls (
	id smallserial NOT NULL,
	"name" varchar(255) NOT NULL,
	CONSTRAINT halls_pk PRIMARY KEY (id)
);

CREATE TABLE public.seance (
	id bigserial NOT NULL,
	time_begin int4 NOT NULL,
	time_end int4 NOT NULL,
	id_content int4 NOT NULL,
	id_hall int4 NOT NULL,
	price money NOT NULL,
	CONSTRAINT seance_pk PRIMARY KEY (id),
	CONSTRAINT seance_fk FOREIGN KEY (id_content) REFERENCES content(id),
	CONSTRAINT seance_fk_1 FOREIGN KEY (id_hall) REFERENCES halls(id)
);

CREATE TABLE public.tickets (
	id bigserial NOT NULL,
	cusomer_id int4 NOT NULL,
	id_seance int4 NOT NULL,
	id_place int4 NOT NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id),
	CONSTRAINT tickets_fk FOREIGN KEY (id_seance) REFERENCES seance(id),
	CONSTRAINT tickets_fk_1 FOREIGN KEY (id_place) REFERENCES places(id)
);
CREATE UNIQUE INDEX tickets_id_seance_idx ON public.tickets USING btree (id_seance, id_place);

CREATE TABLE public.places (
	id smallserial NOT NULL,
	"row" int4 NOT NULL,
	place_number int4 NOT NULL,
	id_hall int4 NOT NULL,
	price_coefficient numeric NOT NULL,
	CONSTRAINT places_pk PRIMARY KEY (id),
	CONSTRAINT places_fk FOREIGN KEY (id_hall) REFERENCES halls(id)
);
CREATE UNIQUE INDEX places_place_number_idx ON public.places USING btree (place_number, "row", id_hall);


CREATE TABLE public."content" (
	id bigserial NOT NULL,
	name varchar(255) NOT NULL,
	id_genre int2 NOT NULL,
	age_limit int4 NOT NULL,
	movie_length int4 NOT NULL,
	CONSTRAINT content_pk PRIMARY KEY (id),
	CONSTRAINT content_un UNIQUE (name),
	CONSTRAINT content_fk FOREIGN KEY (id_genre) REFERENCES genre(id)
);

CREATE TABLE public."contentAttr" (
	id int4 NOT NULL DEFAULT nextval('contentattr_id_seq'::regclass),
	"name" varchar(255) NOT NULL,
	"type" int4 NOT NULL,
	CONSTRAINT contentattr_pk PRIMARY KEY (id),
	CONSTRAINT contentattr_un UNIQUE (name),
	CONSTRAINT contentattr_fk FOREIGN KEY (type) REFERENCES "contentAttrType"(id)
);

CREATE TABLE public."contentAttrType" (
	id int4 NOT NULL DEFAULT nextval('contentattrtype_id_seq'::regclass),
	"name" varchar(255) NOT NULL,
	"comment" varchar(255) NULL,
	CONSTRAINT contentattrtype_pk PRIMARY KEY (id),
	CONSTRAINT contentattrtype_un UNIQUE (name)
);

CREATE TABLE public."contentFields" (
	id int4 NOT NULL DEFAULT nextval('contentfields_id_seq'::regclass),
	"name" varchar(255) NOT NULL,
	"idAttr" int4 NOT NULL DEFAULT nextval('contentfields_idattr_seq'::regclass),
	CONSTRAINT contentfields_pk PRIMARY KEY (id),
	CONSTRAINT contentfields_un UNIQUE (name),
	CONSTRAINT contentfields_fk FOREIGN KEY ("idAttr") REFERENCES "contentAttr"(id)
);

CREATE TABLE public."contentAttrValues" (
	id int4 NOT NULL DEFAULT nextval('contentattrvalues_id_seq'::regclass),
	"idContent" int4 NOT NULL,
	val_text varchar NULL,
	idfield int4 NOT NULL,
	val_date date NULL,
	val_boolean bool NULL,
	val_money money NULL,
	val_int int8 NULL,
	val_float float8 NULL,
	CONSTRAINT contentattrvalues_pk PRIMARY KEY (id),
	CONSTRAINT contentattrvalues_un UNIQUE ("idContent", idfield),
	CONSTRAINT contentattrvalues_fk FOREIGN KEY ("idContent") REFERENCES content(id),
	CONSTRAINT contentattrvalues_fk_1 FOREIGN KEY (idfield) REFERENCES "contentFields"(id)
);

-- Functions
CREATE OR REPLACE FUNCTION public.random_between(low integer, high integer)
 RETURNS integer
 LANGUAGE plpgsql
 STRICT
AS $function$
BEGIN
   RETURN floor(random()* (high-low + 1) + low);
END;
$function$
;

CREATE OR REPLACE FUNCTION public.get_value(id_content integer, content_attr_type character varying, id_field integer)
 RETURNS text
 LANGUAGE plpgsql
AS $function$
declare 
    val text := '';
BEGIN   
	val := (select 
		CASE WHEN $2='Date' then cav.val_date::text
         WHEN $2='Text' THEN cav.val_text::text
         WHEN $2='Boolean' THEN cav.val_boolean::text
        end
	from "contentAttrValues" cav 
	where "idContent" = $1 and idfield = $3);
    return val;
END

$function$
;

CREATE OR REPLACE FUNCTION public.random_string(length integer)
 RETURNS text
 LANGUAGE plpgsql
AS $function$
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
$function$
;

CREATE OR REPLACE FUNCTION public.support_current_tasks("idContent" bigint)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
    arow record; 
    tasks text := '';
BEGIN   
	for arow in
		SELECT cf1."name" 
   			FROM "contentAttrValues" cav1 
     		JOIN "content" c1 ON c1.id = cav1."idContent" 
     		join "contentFields" cf1 on cf1.id = cav1.idfield and cf1."idAttr" = 4
   		where 
    		cav1.val_date = CURRENT_DATE
    		and 
    		cav1."idContent" = $1
    LOOP
    	tasks := tasks || arow."name" || '\n';
    END LOOP;
    return tasks;
END

$function$
;

CREATE OR REPLACE FUNCTION public.support_current_tasks()
 RETURNS TABLE("idContent" integer, name character varying)
 LANGUAGE sql
AS $function$
SELECT cav1."idContent", cf1."name" 
   FROM "contentAttrValues" cav1 
     JOIN "content" c1 ON c1.id = cav1."idContent" 
     join "contentFields" cf1 on cf1.id = cav1.idfield and cf1."idAttr" = 4
   where 
    cav1.val_date = CURRENT_DATE;
$function$
;

CREATE OR REPLACE FUNCTION public.support_in20days_tasks("idContent" bigint)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
    arow record; 
    tasks text := '';
BEGIN   
	for arow in
		SELECT cf1."name" 
   			FROM "contentAttrValues" cav1 
     		JOIN "content" c1 ON c1.id = cav1."idContent" 
     		join "contentFields" cf1 on cf1.id = cav1.idfield and cf1."idAttr" = 4
   		where 
            cav1.val_date > CURRENT_DATE + 20
    		and 
    		cav1."idContent" = $1
    LOOP
    	tasks := tasks || arow."name" || '\n';
    END LOOP;
    return tasks;
END;
$function$
;

CREATE OR REPLACE FUNCTION public.support_in20days_tasks()
 RETURNS TABLE("idContent" integer, name character varying)
 LANGUAGE sql
AS $function$
SELECT cav1."idContent", cf1."name" 
   FROM "contentAttrValues" cav1 
     JOIN "content" c1 ON c1.id = cav1."idContent" 
     join "contentFields" cf1 on cf1.id = cav1.idfield and cf1."idAttr" = 4
   where 
    cav1.val_date > CURRENT_DATE + 20;
$function$
;

-- Views
CREATE OR REPLACE VIEW public.collecting_data_marketing
AS SELECT c.id,
    c.name,
    concat(cat.name, ' - ', ca.name) AS attr,
    get_value(cav."idContent", cat.name, cav.idfield) AS value
   FROM "contentAttrValues" cav
     JOIN content c ON c.id = cav."idContent"
     JOIN "contentFields" cf ON cf.id = cav.idfield
     JOIN "contentAttr" ca ON ca.id = cf."idAttr"
     JOIN "contentAttrType" cat ON cat.id = ca.type;

CREATE OR REPLACE VIEW public.tickets_price
AS SELECT t.id,
    s.price * p.price_coefficient::double precision AS price
   FROM tickets t
     JOIN seance s ON t.id_seance = s.id
     JOIN places p ON t.id_place = p.id;

CREATE OR REPLACE VIEW public.support_task_view_denormal
AS SELECT c.id,
    c.name,
    support_current_tasks(c.id) AS today,
    support_in20days_tasks(c.id) AS in_20_days
   FROM content c;

CREATE OR REPLACE VIEW public.support_task_view_normal
AS SELECT c.id,
    c.name,
    s1.name AS today,
    s2.name AS in_20_days
   FROM content c
     LEFT JOIN ( SELECT support_current_tasks."idContent",
            support_current_tasks.name
           FROM support_current_tasks() support_current_tasks("idContent", name)) s1 ON s1."idContent" = c.id
     LEFT JOIN ( SELECT support_in20days_tasks."idContent",
            support_in20days_tasks.name
           FROM support_in20days_tasks() support_in20days_tasks("idContent", name)) s2 ON s2."idContent" = c.id;


