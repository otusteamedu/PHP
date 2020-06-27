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


INSERT INTO films (id,name)
    (
        select gs.id,
               random_string(10)
        FROM generate_series(1, 100000) as gs(id)
    );

INSERT INTO film_attributes_types (id, name, comment)
    (
        select gs.id,
               random_string(10),
               random_string(10)
        FROM generate_series(1, 100000) as gs(id)
    );

INSERT INTO film_attributes (id, name, type_id)
    (
        select gs.id,
               random_string(10),
               random() * 99999 + 1
        FROM generate_series(1, 100000) as gs(id)
    );

INSERT INTO film_attributes_values (id, attribute_id, film_id, val_text, val_float, val_date)
    (
        select gs.id,
               random() * 99999 + 1,
               random() * 99999 + 1,
               random_string(50),
               random() * 1000 + 1 / random() * 237 + 1,
               NOW() + (random() * (NOW()+'100 days' - (NOW() + '150 days') ))
        FROM generate_series(1, 100000) as gs(id));

