CREATE TABLE "Cinema_hall" (
    "Hall_id" int primary key,
    "Seats_amount" int,
    "Movie_id" int references "Movie"("Movie_id")
);
CREATE TABLE "Timetable" (
    "Timeslot_id" int primary key,
    "SeanceTime" timestamp,
    "Movie_id" int references "Movie"("Movie_id"),
    "Hall_id" int references "Cinema_hall"("Hall_id")
);
CREATE TABLE "Movie" (
    "Movie_id" int primary key,
    "Movie_name" varchar(200),
    "Movie_duration" time
);
CREATE TABLE "Ticket_purchasing" (
    "Purchase_id" int primary key,
    "SeatNum" int,
    "Ticket_price" money,
    "Movie_id" int references "Movie"("Movie_id"),
    "Timeslot_id" int references "Timetable"("Timeslot_id"),
    "Customer_id" int references "Customer"("Customer_id")
);
CREATE TABLE "Customer" (
  "Customer_id" int primary key,
  "CustomerName" varchar(200)  
);

SELECT * FROM "Movie"
WHERE "Movie_id" = (SELECT "Purchase_id" FROM "Ticket_purchasing"
GROUP BY "Purchase_id" ORDER BY SUM("Ticket_price") DESC LIMIT 1);