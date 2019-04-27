create database "cinemaDB" template template1;

CREATE SEQUENCE "cinemahall_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE TABLE IF NOT EXISTS "cinemaHall" (
    "id" bigint NOT NULL DEFAULT nextval('cinemahall_id_seq'),
    "idHall" integer NOT NULL DEFAULT 0,
    "cinemaName" varchar(254) NOT NULL DEFAULT '',
    PRIMARY KEY("id")
);
                                                                      
insert into "cinemaHall" ("id", "idHall", "cinemaName") values (DEFAULT, 0, 'Illuzion');
insert into "cinemaHall" ("id", "idHall", "cinemaName") values (DEFAULT, 1, 'Illuzion_room_1');
insert into "cinemaHall" ("id", "idHall", "cinemaName") values (DEFAULT, 1, 'Illuzion_room_2');

CREATE SEQUENCE "cinemaseance_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE IF NOT EXISTS "cinemaSeance" (
    "id" integer NOT NULL DEFAULT nextval('cinemaseance_id_seq') PRIMARY KEY,
    "idCinemaHall" integer NOT NULL DEFAULT 0,
    "seanceName" varchar(254) NOT NULL DEFAULT '',
    "seansePrice" DECIMAL(11,2) NOT NULL DEFAULT '0.0',
    FOREIGN KEY ("idCinemaHall") REFERENCES "cinemaHall"("id")
);

insert into "cinemaSeance"("id", "idCinemaHall", "seanceName", "seansePrice") values (DEFAULT, 2, 'Game of Thrones', '900');
insert into "cinemaSeance"("id", "idCinemaHall", "seanceName", "seansePrice") values (DEFAULT, 3, 'Axcel', '700');

CREATE SEQUENCE "cinemasoldtikets_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE IF NOT EXISTS "cinemaSoldTikets" (
    "id" integer NOT NULL DEFAULT nextval('cinemasoldtikets_id_seq') PRIMARY KEY,
    "idSeance" integer NOT NULL DEFAULT 0,
    "soldPrice" NUMERIC (5, 2) NOT NULL DEFAULT '0.0',
    FOREIGN KEY ("idSeance") REFERENCES "cinemaSeance"("id")
);

insert into "cinemaSoldTikets" ("id", "idSeance", "soldPrice") values (DEFAULT, 1, '900');
insert into "cinemaSoldTikets" ("id", "idSeance", "soldPrice") values (DEFAULT, 1, '900');
insert into "cinemaSoldTikets" ("id", "idSeance", "soldPrice") values (DEFAULT, 1, '900');
insert into "cinemaSoldTikets" ("id", "idSeance", "soldPrice") values (DEFAULT, 1, '900');
insert into "cinemaSoldTikets" ("id", "idSeance", "soldPrice") values (DEFAULT, 2, '700');
insert into "cinemaSoldTikets" ("id", "idSeance", "soldPrice") values (DEFAULT, 2, '700');
insert into "cinemaSoldTikets" ("id", "idSeance", "soldPrice") values (DEFAULT, 2, '700');
insert into "cinemaSoldTikets" ("id", "idSeance", "soldPrice") values (DEFAULT, 2, '700');

 select "cinemaSeance"."seanceName", sum("cinemaSoldTikets"."soldPrice") as "totalSold"
    from "cinemaSoldTikets"
    left join "cinemaSeance" ON "cinemaSeance"."id" = "cinemaSoldTikets"."idSeance"
    group by "cinemaSeance"."seanceName"
    order by "totalSold" desc
    limit 1;
