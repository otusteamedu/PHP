Create or replace function add_line(length integer) returns text as
$$
declare
    film      films%rowtype;
    hall      halls%rowtype;
    result    text      := '';
    i         integer   := 0;
    time      time      := current_time;
    date      date      := current_date;
    timestamp timestamp := CURRENT_TIMESTAMP;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;

    while i <= length
        loop

            for film in select id from films
                loop
                    time := time + '1 hours';
                    if time >= '22:00' then
                        time = '08:00';
                        date = date + 1;
                    end if;

                    for hall in select id from halls
                        loop
                            timestamp := TO_TIMESTAMP(date || ' ' || time, 'YYYY-MM-DD HH24:MI:SS');
                            if i >= length then
                                return 1;
                            end if;

                            INSERT INTO seances(id_film, id_hall, date) VALUES (film.id, hall.id, timestamp);
                            i := i + 1;
                        end loop;

                end loop;

        end loop;
    return result;
end;
$$ language plpgsql;