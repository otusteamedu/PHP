
DROP TABLE IF EXISTS hall_places;
DROP TABLE IF EXISTS halls;


CREATE TABLE halls
(
    hall_id INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY NOT NULL,
    name    VARCHAR(32)                                  NOT NULL
);
COMMENT ON TABLE halls IS 'Кинозалы';
COMMENT ON COLUMN halls.name IS 'Название зала';

CREATE TABLE hall_places
(
    hall_place_id  INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY NOT NULL,
    hall_id        INT REFERENCES halls (hall_id)               NOT NULL,
    hall_place_num INT                                          NOT NULL
);
COMMENT ON TABLE hall_places IS 'Места в кинозале';
COMMENT ON COLUMN hall_places.hall_place_num IS 'Номер места в зале';

CREATE OR REPLACE FUNCTION get_random_string(length INTEGER) RETURNS TEXT AS
$$
DECLARE
    chars  TEXT[]  := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result TEXT    := '';
    i      INTEGER := 0;
BEGIN
    IF length < 0 THEN
        RAISE EXCEPTION 'Given length cannot be less than 0';
    END IF;
    FOR i IN 1..length
        LOOP
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        END LOOP;
    RETURN result;
END;
$$ LANGUAGE plpgsql;

-- количество залов для заполнения демо
CREATE OR REPLACE FUNCTION hallsNum() RETURNS INT AS
$$
BEGIN
    RETURN 10;
END;
$$ LANGUAGE plpgsql;

-- количество мест в залах для заполнения демо
CREATE OR REPLACE FUNCTION hallsPlacesNum() RETURNS INT AS
$$
BEGIN
    RETURN 1000;
END;
$$ LANGUAGE plpgsql;

--
-- Наполнение демо данными
--

INSERT INTO halls(name)
SELECT get_random_string(10)
FROM generate_series(1, hallsNum())
ON CONFLICT DO NOTHING;

INSERT INTO hall_places(hall_id, hall_place_num)
SELECT floor(random() * (hallsNum())) + 1,
       random() * 100
FROM generate_series(1, hallsPlacesNum())
ON CONFLICT DO NOTHING;
