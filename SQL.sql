-- Select #1 --
select * from seances where date::time >= '10:00' and date::time <= '19:00';

select
        s.*,
        f.name as film,
        h.name as hall
    from seances s
        join films f on f.id = s.id_film
        join halls h on h.id = s.id_hall
    where date::time >= '10:00' and date::time <= '19:00';

-- Select #2 --
select * from tickets where price > 310;

select
    t.*,
    s.date as date,
    f.name as film,
    st.name as seat_type
from tickets t
    join seances s on s.id = t.id_seance
    join seats seat on seat.id = t.id_seat
    join films f on f.id = s.id_film
    join seat_types st on st.id = seat.id_seat_type
where price > 310;

-- Select #3 --
select * from seats where row_number > 2 and seat_number < 24;

select
    s.*,
    p.price,
    st.name as seat_type
from seats s
    join seat_types st on st.id = s.id_seat_type
    join price p on p.id = s.id_price
where row_number > 2 and seat_number < 24;

