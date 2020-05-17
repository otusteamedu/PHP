-- EAV ddl
DROP TABLE IF EXISTS "attribute_type" CASCADE;
CREATE TABLE "attribute_type" (
    id serial UNIQUE,
    type_name varchar(255) NOT NULL,
    CONSTRAINT attribute_type_pk PRIMARY KEY (id)
);

DROP TABLE IF EXISTS "attribute" CASCADE;
CREATE TABLE "attribute" (
    id serial UNIQUE,
    attr_name varchar(255) NOT NULL,
    type_id int,
    CONSTRAINT attribute_pk PRIMARY KEY (id),
    CONSTRAINT attribute_type_fk FOREIGN KEY (type_id) REFERENCES attribute_type(id)
);

DROP TABLE IF EXISTS "film" CASCADE;
CREATE TABLE "film" (
    id serial UNIQUE,
    name varchar(255) NOT NULL,
    comment text,
    CONSTRAINT film_pk PRIMARY KEY (id)
);

DROP TABLE IF EXISTS "attribute_value" CASCADE;
CREATE TABLE "attribute_value" (
    id serial UNIQUE,
    attribute_id int NOT NULL,
    film_id int NOT NULL,
    val_text text,
    val_numeric numeric,
    val_date date,
    val_bool bool,
    CONSTRAINT attribute_value_pk PRIMARY KEY (id),
    CONSTRAINT attribute_value_attribute_fk FOREIGN KEY (attribute_id) REFERENCES attribute(id),
    CONSTRAINT attribute_value_film_fk FOREIGN KEY (film_id) REFERENCES film(id)
);


-- Create functions
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


Create or replace function random_date() returns date as
$$
declare
    result date := current_date;
begin
    result := result + (-100 + 100*random())::int;

    return result;
end;
$$ language plpgsql;

-- Init data
INSERT INTO attribute_type (type_name)
    SELECT random_string( (4 + 10*random())::int ) FROM generate_series(1, 5);

INSERT INTO "attribute" (attr_name, type_id)
    SELECT random_string( (3 + 7*random())::int ), (1 + 4*random())::int FROM generate_series(1, 10) AS gs(id);

INSERT INTO film ("name", "comment")
    SELECT random_string( (7 + 30*random())::int ), random_string( (15 + 50*random())::int ) FROM generate_series(1, 20) AS gs(id);