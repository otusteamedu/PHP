DROP TABLE IF EXISTS "filmAttributeValues";
DROP TABLE IF EXISTS "filmAttributes";
DROP TABLE IF EXISTS "filmAttributeTypes";
DROP TABLE IF EXISTS films;

CREATE TABLE films (
    id serial,
    title varchar(60) NOT NULL,
    duration_in_minutes smallint NOT NULL,
    comment text NULL DEFAULT ''::text,
    CONSTRAINT films_pk PRIMARY KEY (id),
    CONSTRAINT films_un UNIQUE (title)
);
CREATE INDEX "films_title_index" ON "films" USING btree("title");
CREATE INDEX "films_duration_min_index" ON "films" USING btree("duration_in_minutes");

CREATE TABLE "filmAttributeTypes" (
    id serial,
    title varchar(60) NOT NULL,
    comment text NULL DEFAULT ''::text,
    CONSTRAINT filmattrtypes_pk PRIMARY KEY (id),
    CONSTRAINT filmattrtypes_un UNIQUE (title)
);

CREATE TABLE "filmAttributes" (
    id serial,
    title varchar(60) NOT NULL,
    type_id integer NOT NULL,
    CONSTRAINT filmattributes_pk PRIMARY KEY (id),
    CONSTRAINT filmattributes_type_fk FOREIGN KEY (type_id) REFERENCES "filmAttributeTypes",
    CONSTRAINT filmattributes_un UNIQUE (title)
);

CREATE TABLE "filmAttributeValues" (
    id serial,
    film_id integer NOT NULL,
    attribute_id integer NOT NULL,
    val_bool boolean NULL,
    val_num numeric NULL,
    val_date date NULL,
    val_text varchar NULL,
    comment text NULL DEFAULT ''::text,
    CONSTRAINT filmattrvalues_pk PRIMARY KEY (id),
    CONSTRAINT filmattrvalues_film_fk FOREIGN KEY (film_id) REFERENCES "films",
    CONSTRAINT filmattrvalues_attribute_fk FOREIGN KEY (attribute_id) REFERENCES "filmAttributes"
);
CREATE INDEX "filmAttributeValues_subtitres_index" ON "filmAttributeValues" USING btree("val_bool")
    WHERE "attribute_id" = 1;
CREATE INDEX "filmAttributeValues_subtitres_true_index" ON "filmAttributeValues" USING btree("val_bool")
    WHERE "attribute_id" = 1 AND "val_bool" = TRUE;
CREATE INDEX "filmAttributeValues_val_text_index" ON "filmAttributeValues" USING btree("val_text");
CREATE INDEX "filmAttributeValues_val_text_not_null_index" ON "filmAttributeValues" USING btree("val_text")
    WHERE "val_text" IS NOT NULL;