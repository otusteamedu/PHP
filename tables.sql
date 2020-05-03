CREATE TABLE "Cinema_hall" (
    "Hall_id" smallint primary key,
    "Seats_amount" smallint,
    "Movie_id" smallint references "Movie"("Movie_id")
);
CREATE TABLE "Timetable" (
    "Timeslot_id" smallint primary key,
    "SeanceTime" timestamp,
    "Seance_price" smallint,
    "Movie_id" smallint references "Movie"("Movie_id"),
    "Hall_id" smallint references "Cinema_hall"("Hall_id")
);
CREATE TABLE "Movie" (
    "Movie_id" smallint primary key,
    "Movie_name" varchar(250),
    "Movie_duration" time
);
CREATE TABLE "Ticket_purchasing" (
    "Purchase_id" smallint primary key,
    "SeatNum" smallint,
    "Movie_id" smallint references "Movie"("Movie_id"),
    "Timeslot_id" smallint references "Timetable"("Timeslot_id"),
    "Customer_id" smallint references "Customer"("Customer_id")
);
CREATE TABLE "Customer" (
  "Customer_id" smallint primary key,
  "CustomerName" varchar(250)
);

INSERT INTO "Movie"("Movie_id", "Movie_name", "Movie_duration") VALUES (1, 'FirstFilm', '01:00');
INSERT INTO "Movie"("Movie_id", "Movie_name", "Movie_duration") VALUES (2, 'SecondFilm', '01:30');
INSERT INTO "Movie"("Movie_id", "Movie_name", "Movie_duration") VALUES (3, 'ThirdFilm', '02:00');
INSERT INTO "Movie"("Movie_id", "Movie_name", "Movie_duration") VALUES (4, 'FourthFilm', '02:30');

INSERT INTO "Cinema_hall"("Hall_id", "Seats_amount", "Movie_id") VALUES (1, 100, 1);
INSERT INTO "Cinema_hall"("Hall_id", "Seats_amount", "Movie_id") VALUES (2, 150, 2);
INSERT INTO "Cinema_hall"("Hall_id", "Seats_amount", "Movie_id") VALUES (3, 100, 3);
INSERT INTO "Cinema_hall"("Hall_id", "Seats_amount", "Movie_id") VALUES (4, 150, 4);

INSERT INTO "Customer"("Customer_id", "CustomerName") VALUES (1, 'Ruslan1');
INSERT INTO "Customer"("Customer_id", "CustomerName") VALUES (2, 'Ruslan2');
INSERT INTO "Customer"("Customer_id", "CustomerName") VALUES (3, 'Ruslan3');
INSERT INTO "Customer"("Customer_id", "CustomerName") VALUES (4, 'Ruslan4');

INSERT INTO "Timetable"("Timeslot_id", "SeanceTime", "Seance_price", "Movie_id", "Hall_id")
VALUES (1, '2020-04-19 11:00:00', 150, 1, 1);
INSERT INTO "Timetable"("Timeslot_id", "SeanceTime", "Seance_price", "Movie_id", "Hall_id")
VALUES (2, '2020-04-19 13:00:00', 200, 2, 2);
INSERT INTO "Timetable"("Timeslot_id", "SeanceTime", "Seance_price", "Movie_id", "Hall_id")
VALUES (3, '2020-04-19 15:00:00', 100, 3, 3);
INSERT INTO "Timetable"("Timeslot_id", "SeanceTime", "Seance_price", "Movie_id", "Hall_id")
VALUES (4, '2020-04-19 11:00:00', 120, 4, 4);

INSERT INTO "Ticket_purchasing"("Purchase_id", "SeatNum", "Movie_id", "Timeslot_id", "Customer_id")
VALUES (1, 25, 1, 1, 1);
INSERT INTO "Ticket_purchasing"("Purchase_id", "SeatNum", "Movie_id", "Timeslot_id", "Customer_id")
VALUES (2, 30, 2, 2, 2);
INSERT INTO "Ticket_purchasing"("Purchase_id", "SeatNum", "Movie_id", "Timeslot_id", "Customer_id")
VALUES (3, 35, 3, 3, 3);
INSERT INTO "Ticket_purchasing"("Purchase_id", "SeatNum", "Movie_id", "Timeslot_id", "Customer_id")
VALUES (4, 40, 4, 4, 4);
INSERT INTO "Ticket_purchasing"("Purchase_id", "SeatNum", "Movie_id", "Timeslot_id", "Customer_id")
VALUES (5, 45, 1, 1, 1);
INSERT INTO "Ticket_purchasing"("Purchase_id", "SeatNum", "Movie_id", "Timeslot_id", "Customer_id")
VALUES (6, 55, 3, 2, 2);
INSERT INTO "Ticket_purchasing"("Purchase_id", "SeatNum", "Movie_id", "Timeslot_id", "Customer_id")
VALUES (7, 65, 2, 2, 3);

SELECT * FROM "Movie"
WHERE "Movie_id" = (SELECT tp."Movie_id"  FROM "Ticket_purchasing" tp
                    INNER JOIN "Timetable" tt on tp."Movie_id" = tt."Movie_id"
            GROUP BY tp."Movie_id" ORDER BY SUM("Seance_price") DESC LIMIT 1);