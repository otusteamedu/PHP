DROP TABLE IF EXISTS "tickets";
DROP TABLE IF EXISTS "dict_ticket_status";
DROP TABLE IF EXISTS "show_list";
DROP TABLE IF EXISTS "hall_seats";
DROP TABLE IF EXISTS "halls";

CREATE TABLE "halls" (
  "hall_id" SERIAL PRIMARY KEY,
  "name" VARCHAR(255)
);

CREATE TABLE "hall_seats" (
  "seat_id" SERIAL PRIMARY KEY,
  "hall_id" INT,
  "name" VARCHAR(255),
  "price_mod" REAL NOT NULL
);

CREATE TABLE "show_list" (
  "show_id" SERIAL PRIMARY KEY,
  "hall_id" INT NOT NULL,
  "name" VARCHAR(255),
  "start_time" TIMESTAMP NOT NULL,
  "length" INT NOT NULL DEFAULT 150,
  "price" MONEY NOT NULL
);

CREATE TABLE "dict_ticket_status" (
  "status_id" SERIAL PRIMARY KEY,
  "name" VARCHAR(255)
);

CREATE TABLE "tickets" (
  "show_id" INT NOT NULL,
  "seat_id" INT NOT NULL,
  "price" MONEY NOT NULL,
  "status_id" INT NOT NULL DEFAULT 0,
  "status_time" TIMESTAMP DEFAULT NULL,
  "status_data" VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY ("show_id", "seat_id")
);

ALTER INDEX ALL IN TABLESPACE "pg_default" SET TABLESPACE "tsFastIndex";
