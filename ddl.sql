CREATE TABLE "cinema" (
  "cinema_id" smallserial primary key,
  "name" varchar(50)
);

CREATE TABLE "hall" (
  "hall_id" smallserial primary key,
  "cinema_id" int references cinema(cinema_id)
);

CREATE TABLE "place" (
  "place_id" smallserial primary key,
  "hall_id" int references hall(hall_id),
  "row_id" int,
  "call_id" int
);

CREATE TABLE "film" (
  "film_id" serial primary key,
  "film_name" varchar(100),
  "duration" int
);

CREATE TABLE "seance" (
  "seance_id" serial primary key,
  "hall_id" int references hall(hall_id),
  "film_id" int references film(film_id),
  "time_start" timestamp with time zone,
  "price" numeric(10,2)
);

-- hash для экспериментов
CREATE TABLE "ticket" (
  "place_id" serial references place(place_id),
  "seance_id" int references seance(seance_id),
  "hash" text,
  PRIMARY KEY ("place_id", "seance_id")
);