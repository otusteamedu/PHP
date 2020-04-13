Create or replace function add_seat(length integer) returns text as
$$
declare
    hall      halls%rowtype;
    seat_type seat_types%rowtype;
    price     price%rowtype;
    result    text    := '';
    i         integer := 0;

begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;

    while i <= length
        loop

            for hall in select * from halls
                loop
                    for seat_type in select * from seat_types
                        loop

                            for price in select * from price
                                loop
                                    for seat_number in 1..20
                                        loop
                                            if i >= length then
                                                return result;
                                            end if;

                                            INSERT INTO seats(id_hall, seat_number, row_number, id_seat_type, id_price)
                                            VALUES (hall.id, seat_number, price.id, seat_type.id, price.id);
                                            i := i + 1;
                                        end loop;
                                end loop;

                        end loop;
                end loop;

        end loop;

    return result;
end;
$$ language plpgsql;
