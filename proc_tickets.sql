Create or replace function add_ticket(length integer) returns text as
$$
declare
    seance seances%rowtype;
    seat seats%rowtype;
    result text := '';
    i integer := 0;
    priceTicket integer := 0;

begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;

    while i <= length loop

        for seance in select * from seances loop

            for seat in select * from seats where id_hall = seance.id_hall loop
                if i >= length then
                    return result;
                end if;

                priceTicket := (select price from price where id = seat.id_price)::int;
                INSERT INTO tickets(id_seance, price, is_paid, id_seat) VALUES (seance.id, priceTicket, (floor(random() * 100 + 1)::int > 20), seat.id);
                i := i + 1;
            end loop;

        end loop;

    end loop;

    return result;
end;
$$ language plpgsql;