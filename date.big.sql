



TRUNCATE TABLE
    tickets,
    clients,
    seance,
    hall,
    attributes_value,
    attributes,
    attributes_types,
    film;


ALTER TABLE clients 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE tickets 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE seance 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE hall 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE attributes_value 
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE attributes
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE attributes_types
    ALTER COLUMN id
        RESTART WITH 1;

ALTER TABLE film
    ALTER COLUMN id
        RESTART WITH 1;


CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
    RETURNS INT AS
$$
BEGIN
    RETURN floor(random()* (high-low + 1) + low);
END;
$$ language 'plpgsql' STRICT; 

CREATE OR REPLACE FUNCTION random_string() returns text AS
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    for i in 1..10 loop
        result := result || chars[1+random()*(array_length(chars, 1)-1)];
    end loop;
    return result;
end
$$ language plpgsql;

DROP INDEX idx_clients_name;
DROP INDEX idx_seance_datetime;
DROP INDEX idx_price_tickets;
DROP INDEX idx_id_seance;
DROP INDEX idx_id_film ;
DROP INDEX idx_tickets ;

DROP INDEX idx_film_name ;
DROP INDEX idx_attributes;
DROP INDEX idx_date ;

DROP INDEX idx_filmId ;
DROP INDEX idx_attributes_value_Id_attributes ;
DROP INDEX idx_attributes_id_type ;


INSERT INTO hall(hall_name)
SELECT
    random_string()
FROM generate_series(1,12);


INSERT INTO film (film_name)
SELECT
    random_string()
FROM generate_series(1,33);


INSERT INTO clients (name)
SELECT
    random_string()
FROM generate_series(1,500000);


INSERT INTO seance (id_film ,id_hall, datetime ,price_seance)
SELECT
    random_between (1, 33),
    random_between (1,12),
    date_trunc('second',LOCALTIMESTAMP(1) + (random() * ( LOCALTIMESTAMP(1)+'90 days' -  LOCALTIMESTAMP(1)))),
    random_between (200, 900)
FROM generate_series(1,550);

INSERT INTO attributes_types(type_name)
SELECT
     random_string()
FROM generate_series(1,10);

INSERT INTO attributes(attr_name,id_type)
SELECT
    random_string(),
    random_between (1,10)
FROM generate_series(1,20);

INSERT INTO attributes_value(id_attributes,id_film,text_val,boolean_val,date_val,realis_number_val,float_number_val)
SELECT
    random_between (1,20),
    random_between (1,33),
    random_string(),
    random()<0.5,
    date_trunc('second',LOCALTIMESTAMP(1) + (random() * ( LOCALTIMESTAMP(1)+'90 days' -  LOCALTIMESTAMP(1)))),
    random_between (1,1000),
    random_between (1,100000000)
FROM generate_series(1,20);

INSERT INTO tickets(id_seance,id_client,price_tickets)
SELECT
    random_between (1,550),
    random_between (1,500000),
    random_between (200, 900)
FROM generate_series(1,10000000);



/*
INSERT INTO tickets(id_seance,id_client,price_tickets)
SELECT
    random_between (1,550),
    random_between (1,12),
    random_between (200, 900)
FROM generate_series(1,10000000);
*/