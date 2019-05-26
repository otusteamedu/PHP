-- -----------------------------------------------------
-- Table theater.attribute_name
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS "theater"."attribute_name" (
    "id" SERIAL PRIMARY KEY,
    "name" VARCHAR(255) NOT NULL
);

CREATE UNIQUE INDEX attribute_name_idx ON "theater"."attribute_name" ("name" ASC);
-- -----------------------------------------------------
-- Table theater.attribute_type
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS "theater"."attribute_type" (
    "id" SERIAL PRIMARY KEY,
    "category" int2 NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "type" VARCHAR(45) NOT NULL
);

CREATE UNIQUE INDEX attribute_type_idx ON "theater"."attribute_type" ("name" ASC);
-- -----------------------------------------------------
-- Table theater.attribute_value
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS "theater"."attribute_value" (
    "id" SERIAL PRIMARY KEY,
    "bool_val" bool NOT NULL DEFAULT FALSE,
    "int_val" int8 NULL,
    "date_val" timestamptz NULL,
    "text_val" text NULL
);
-- -----------------------------------------------------
-- Table theater.movie_attribute
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS "theater"."movie_attribute" (
    "id" SERIAL PRIMARY KEY,
    "movie_id" int4 NOT NULL,
    "attribute_name_id" int4 NOT NULL,
    "attribute_value_id" int4 NOT NULL,
    "attribute_type_id" int4 NOT NULL,
    CONSTRAINT "movie_attribute_movie_fk"
        FOREIGN KEY ("movie_id")
        REFERENCES "theater"."movie" ("id"),
    CONSTRAINT "movie_attribute_attribute_name_fk"
        FOREIGN KEY ("attribute_name_id")
        REFERENCES "theater"."attribute_name" ("id"),
    CONSTRAINT "movie_attribute_attribute_value_fk"
        FOREIGN KEY ("attribute_value_id")
        REFERENCES "theater"."attribute_value" ("id"),
    CONSTRAINT "movie_attribute_attribute_type_fk"
        FOREIGN KEY ("attribute_type_id")
        REFERENCES "theater"."attribute_type" ("id")
);

CREATE INDEX movie_attribute_movie_fk_idx ON "theater"."movie_attribute" USING btree (movie_id);
CREATE INDEX movie_attribute_attribute_name_fk_idx ON "theater"."movie_attribute" USING btree (attribute_name_id);
CREATE INDEX movie_attribute_attribute_value_fk_idx ON "theater"."movie_attribute" USING btree (attribute_value_id);
CREATE INDEX movie_attribute_attribute_type_fk_idx ON "theater"."movie_attribute" USING btree (attribute_type_id);
