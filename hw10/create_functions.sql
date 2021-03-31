create function random_string(length integer) returns text as
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

create function random_int(min int ,max int) returns int as
$$
begin
    return floor(random() * (max-min + 1) + min);
end;
$$ language plpgsql;

create function random_double_precision(min double precision ,max double precision) returns double precision as
$$
begin
    return random() * (max-min + 1) + min;
end;
$$ language plpgsql;

create function random_timestamp() returns timestamp as
$$
begin
    return now() - '1 month'::interval * round(random() * 100) - '1 day'::interval * round(random() * 100);
end;
$$ language plpgsql;

create function random_boolean() returns boolean as
$$
begin
    return random() > 0.5;
end;
$$ language plpgsql;