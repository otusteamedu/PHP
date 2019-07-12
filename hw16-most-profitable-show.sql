INSERT INTO public.dict_ticket_status ("status_id", "name") VALUES (0, 'Available'), (1, 'Reserved'), (2, 'Sold');

INSERT INTO public.halls ("hall_id", "name") VALUES (1, 'Ruby hall'), (2, 'Emerald hall');

INSERT INTO public.show_list (hall_id,"name",start_time,length,price) VALUES
(1,'British comedy','2018-06-15 17:00:00.000',150,2.00),
(1,'Polish western','2018-06-15 19:30:00.000',150,1.70),
(2,'American drama','2018-06-15 20:00:00.000',150,1.50);

INSERT INTO public.hall_seats (seat_id,hall_id,"name",price_mod) VALUES
(1,1,'Center, row 1, seat 1',1),
(2,1,'Left, seat 1',0.8),
(3,1,'Right, seat 1',0.8),
(4,1,'Back, row 2, seat 1',0.9),
(5,2,'Row 1, seat 1',0.8),
(6,2,'Row 2, seat 1',1),
(8,2,'Row 4, seat 1',0.9),
(7,2,'Row 3, seat 1',1);

INSERT INTO public.tickets (show_id,seat_id,price,status_id,status_time,status_data) VALUES
(1,1,2.00,2,NULL,NULL),
(1,2,1.60,0,NULL,NULL),
(1,3,1.60,0,NULL,NULL),
(1,4,1.80,2,NULL,NULL),
(2,1,1.70,0,NULL,NULL),
(2,2,1.36,2,NULL,NULL),
(2,3,1.36,2,NULL,NULL),
(2,4,1.53,0,NULL,NULL),
(3,5,1.20,2,NULL,NULL),
(3,6,1.50,2,NULL,NULL),
(3,7,1.50,2,NULL,NULL),
(3,8,1.35,2,NULL,NULL);

WITH "earnings" AS (
    SELECT "show_id", SUM("price") "earn" FROM "tickets" WHERE "status_id" = 2 GROUP BY "show_id"
)
SELECT e."show_id", l."name", e."earn"
FROM "earnings" e LEFT JOIN "show_list" l ON e."show_id" = l."show_id"
ORDER BY "earn" DESC LIMIT 1
