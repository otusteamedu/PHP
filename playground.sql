/*
тестовые данные
один кинотеатр

4 зала,
в каждом 10х15 мест,

10 фильмов
заполним расписание на 3 дня
каждый день в каждом зале сенсы в каждые 3 часа
сделаем в каждом сеансе рандомный фильм,
стоимость каждого сеанса рандом от 90 до 390 руб.

на каждый сеанс от 50 до 150 билетов


чтобы увеличить базу, заполним расписсание на год


*/

-- кинотеатры
INSERT INTO "cinema" (cinema_id, name) VALUES ('1', 'Октябрь');

-- залы
INSERT INTO "hall" (hall_id, cinema_id) VALUES ('1', '1'), ('2', '1'), ('3', '1'), ('4', '1');

-- места в залах
DO $$
DECLARE
    h INTEGER;
    halls INTEGER := (SELECT MAX(hall_id) FROM hall);
    cols INTEGER := 10;
    rows INTEGER := 15;
    q TEXT := 'INSERT INTO "place" (hall_id, row_id, call_id) VALUES ';
BEGIN
    FOR h IN SELECT hall_id AS cn FROM hall ORDER BY hall_id ASC LOOP
        FOR c IN 1 .. cols LOOP
           FOR r IN 1 .. rows LOOP
            q := q || '(' || h || ',' || c || ',' || r || ')';
            IF h = halls AND c = cols AND r = rows THEN
                q := q || ';';
            ELSE
                q := q || ',';
            END IF;
           END LOOP; 
        END LOOP;
    END LOOP;
    EXECUTE q;
END $$;

-- фильмы
DO $$
DECLARE
    x TEXT;
    a TEXT[] := ARRAY['Сторож', 'Доктор Сон', 'Семейка Аддамс', 'Терминатор: Тёмные судьбы', 'Девятая', 'Малефисента: Владычица тьмы', 'Текст', 'Во всё тяжкое', 'Джокер', 'Верность'];
    q TEXT := 'INSERT INTO "film" (film_name, duration) VALUES ';
BEGIN
    FOREACH x IN ARRAY a
    LOOP
        EXECUTE q || '(''' || x || ''', ' || random()*100+100 || ');';
    END LOOP;
END $$;

-- сеансы
DO $$
DECLARE
    h  INTEGER;
    ts TIMESTAMP;
    start  TIMESTAMP := '2019-11-01 00:00:00';
    finish TIMESTAMP := '2019-11-03 23:59:00';
    -- start  TIMESTAMP := '2019-12-01 00:00:00';
    -- finish TIMESTAMP := '2020-10-31 23:59:00';
    fi INTEGER;
    p  NUMERIC;
    q  TEXT := 'INSERT INTO "seance" (hall_id, time_start, film_id, price) VALUES ';
    hmin   INTEGER := (SELECT min(hall_id) FROM hall);
BEGIN
    FOR h IN SELECT hall_id FROM hall ORDER BY hall_id ASC LOOP
        FOR ts IN select time_start::timestamp from generate_series(start, finish, interval '3 hours') as time_start LOOP
            fi := (SELECT film_id FROM film ORDER BY RANDOM() limit 1);
            p := round(random()::numeric*(390-90+1)+90, -1);
            IF NOT (h = hmin AND ts = start) THEN
                q := q || ',';
            END IF;
            q := q || '(' || h || ',''' || ts || ''',' || fi || ',' || p || ')';
        END LOOP;
    END LOOP;
    q := q || ';';
    EXECUTE q;
END $$;

-- билеты
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


DO $$
DECLARE
    s    RECORD;
    p    INTEGER;
    r    NUMERIC;
    start  TIMESTAMP := '2019-11-01 00:00:00';
    -- start  TIMESTAMP := '2019-12-01 00:00:00';
    qw   TEXT := 'INSERT INTO "ticket" (seance_id, place_id, "hash") VALUES ';
    rstr TEXT;
    q    TEXT;
BEGIN
    FOR s IN SELECT seance_id, hall_id FROM seance WHERE time_start > start ORDER BY seance_id, hall_id ASC LOOP
        q := qw;
        r := random()*(1-0.3)+0.3;
        FOR p IN SELECT place_id FROM place WHERE hall_id = s.hall_id ORDER BY place_id ASC LOOP
            IF random() < r THEN
                rstr := random_string(floor(random()*(100-50+1))::INTEGER+50);
                q := q || '(' || s.seance_id || ',' || p || ',''' || rstr || '''),';
            END IF;
        END LOOP;
        q := trim(trailing ',' from q);
        q := q || ';';
        EXECUTE q;
    END LOOP;
END $$;


















