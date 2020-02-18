---- скрипты заполнения таблиц
-- Случайная генерация даты
create or replace function random_datetime() returns timestamp as
$$
begin
    return (now() - (random() * (interval '90 days')));
END;
$$ language plpgsql;

-- Случайная генерация int
-- в параметре указывается максимальное значение
create or replace function random_int(max_int int) returns int as
$$
begin
    if max_int < 1 THEN
        raise exception 'max_int cannot be less than 1';
    END if;

    return (1 + random() * (max_int - 1))::int;
END;
$$ language plpgsql;

-- случайная генерация строки
CREATE OR REPLACE FUNCTION random_string() returns text AS
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    for i in 1..20 loop
        if (round(random())::int)::boolean
        then
            result := result || chars[1+random()*(array_length(chars, 1)-1)];
        end if;
    end loop;
    return result;
end
$$ language plpgsql;