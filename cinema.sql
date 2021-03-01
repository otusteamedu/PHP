CREATE TABLE "public"."hall" (
    "id" SERIAL NOT NULL,
    "name" CHARACTER VARYING (32) NOT NULL,
    "created_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP NULL,
    CONSTRAINT "hall_pkey" PRIMARY KEY ("id")
);

CREATE UNIQUE INDEX "uidx_hall_name" ON "public"."hall" ("name");

CREATE TABLE "public"."movie" (
    "id" SERIAL NOT NULL,
    "name" CHARACTER VARYING (128) NOT NULL,
    "description" CHARACTER VARYING (320) NULL,
    "duration" INTEGER NULL,
    "created_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP NULL,
    CONSTRAINT "movie_pkey" PRIMARY KEY ("id")
);

CREATE UNIQUE INDEX "uidx_movie_name" ON "public"."movie" ("name");

CREATE TABLE "public"."showtime" (
    "id" SERIAL NOT NULL,
    "hall_id" INTEGER NOT NULL,
    "movie_id" INTEGER NOT NULL,
    "starts_in" TIMESTAMP NOT NULL,
    "created_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP NULL,
    CONSTRAINT "showtime_pkey" PRIMARY KEY ("id")
);

ALTER TABLE "public"."showtime"
    ADD CONSTRAINT "fk_showtime_hall_id" FOREIGN KEY ("hall_id") REFERENCES "public"."hall" ("id") ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD  CONSTRAINT "fk_showtime_movie_id" FOREIGN KEY ("movie_id") REFERENCES "public"."movie" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

CREATE TABLE "public"."ticket" (
    "id" SERIAL NOT NULL,
    "showtime_id" INTEGER NOT NULL,
    "price" DECIMAL (8, 2) NOT NULL,
    "created_at" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP NULL,
    CONSTRAINT "ticket_pkey" PRIMARY KEY ("id")
);

ALTER TABLE "public"."ticket"
    ADD CONSTRAINT "fk_ticket_showtime_id" FOREIGN KEY ("showtime_id") REFERENCES "public"."showtime" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;
