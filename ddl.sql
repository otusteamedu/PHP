CREATE TABLE "cinema" (
  "cinema_id" int primary key,
  "name" varchar(50)
);

CREATE TABLE "hall" (
  "hall_id" int primary key,
  "cinema_id" int references cinema(cinema_id)
);

CREATE TABLE "place" (
  "place_id" int primary key,
  "hall_id" int references hall(hall_id),
  "row_id" int,
  "call_id" int
);

CREATE TABLE "film" (
  "film_id" int primary key,
  "film_name" varchar(100),
  "duration" int
);

CREATE TABLE "seance" (
  "seance_id" int primary key,
  "hall_id" int references hall(hall_id),
  "film_id" int references film(film_id),
  "time_start" timestamp with time zone,
  "price" numeric(10,2)
);

CREATE TABLE "ticket" (
  "place_id" int references place(place_id),
  "seance_id" int references seance(seance_id),
  PRIMARY KEY ("place_id", "seance_id")
);

/* EAV. Таблицы для хранения атрибутов фильма */

CREATE TABLE "filmAttrType" (
  "type_id" int primary key,
  "name" varchar(50)
);

CREATE TABLE "filmAttr" (
  "attr_id" int primary key,
  "type_id" int references "filmAttrType"(type_id),
  "name" varchar(50)
);

CREATE TABLE "filmAttrValue" (
  "val_id" int primary key,
  "film_id" int references film(film_id),
  "attr_id" int references "filmAttr"(attr_id),
  "val_date" timestamp with time zone,
  "val_text" text,
  "val_bool" boolean,
  "val_num" numeric
);
CREATE INDEX ON "filmAttrValue" (val_date);
