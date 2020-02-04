-- The most profitable movie
select tFilm.id,
       tFilm.name,
       sum(tBasket.price) as summ
from cinema.basket as tBasket
         join cinema.film as tFilm on tBasket.film_id = tFilm.id
         join cinema.order as tOrder on tBasket.order_id = tOrder.id
where order_id is not null
  and tOrder.date_pay is not null

group by tFilm.id
order by summ desc
;

-- Adminer 4.7.5 PostgreSQL dump

\connect "hw7";

DROP TABLE IF EXISTS "basket";
DROP SEQUENCE IF EXISTS basket_id_seq;
CREATE SEQUENCE basket_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "cinema"."basket" (
                                   "id" integer DEFAULT nextval('basket_id_seq') NOT NULL,
                                   "film_id" integer,
                                   "hall_id" integer,
                                   "session_id" integer,
                                   "plase_id" integer,
                                   "price" double precision,
                                   "order_id" integer,
                                   "user_id" integer,
                                   CONSTRAINT "basket_id_uindex" UNIQUE ("id"),
                                   CONSTRAINT "basket_pk" PRIMARY KEY ("id"),
                                   CONSTRAINT "basket_film_id_fkey" FOREIGN KEY (film_id) REFERENCES film(id) NOT DEFERRABLE,
                                   CONSTRAINT "basket_hall_id_fkey" FOREIGN KEY (hall_id) REFERENCES hall(id) NOT DEFERRABLE,
                                   CONSTRAINT "basket_order_id_fkey" FOREIGN KEY (order_id) REFERENCES "order"(id) NOT DEFERRABLE,
                                   CONSTRAINT "basket_plase_id_fkey" FOREIGN KEY (plase_id) REFERENCES place(id) NOT DEFERRABLE,
                                   CONSTRAINT "basket_sessions_id_fkey" FOREIGN KEY (session_id) REFERENCES session(id) NOT DEFERRABLE,
                                   CONSTRAINT "basket_user_id_fkey" FOREIGN KEY (user_id) REFERENCES "user"(id) NOT DEFERRABLE
) WITH (oids = false);

INSERT INTO "basket" ("id", "film_id", "hall_id", "session_id", "plase_id", "price", "order_id", "user_id") VALUES
(2,	4,	4,	4,	151,	5000,	1,	1),
(7,	2,	2,	9,	76,	350,	5,	5),
(5,	2,	2,	3,	54,	500,	3,	3),
(6,	2,	2,	8,	99,	150,	4,	4),
(4,	2,	2,	2,	54,	500,	2,	2),
(8,	3,	3,	7,	132,	2000,	NULL,	NULL),
(9,	3,	3,	7,	133,	2000,	NULL,	NULL),
(10,	3,	3,	7,	134,	2000,	NULL,	NULL),
(11,	3,	3,	7,	142,	1900,	NULL,	NULL),
(12,	3,	3,	7,	143,	1900,	NULL,	NULL),
(13,	4,	4,	4,	147,	6000,	NULL,	NULL),
(1,	4,	4,	4,	148,	6000,	1,	1),
(15,	4,	4,	4,	151,	5000,	9,	4),
(14,	4,	4,	4,	150,	5000,	9,	4),
(3,	4,	4,	4,	147,	6000,	8,	5),
(16,	1,	1,	10,	125,	600,	10,	1),
(17,	1,	1,	10,	105,	700,	11,	4),
(18,	1,	1,	10,	125,	600,	NULL,	NULL),
(19,	1,	1,	10,	105,	700,	NULL,	NULL);

DROP TABLE IF EXISTS "film";
DROP SEQUENCE IF EXISTS films_id_seq;
CREATE SEQUENCE films_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "cinema"."film" (
                                 "id" integer DEFAULT nextval('films_id_seq') NOT NULL,
                                 "name" character varying NOT NULL,
                                 "decription" text,
                                 CONSTRAINT "films_pk" PRIMARY KEY ("id")
) WITH (oids = false);

COMMENT ON TABLE "cinema"."film" IS 'hw8 table films';

COMMENT ON COLUMN "cinema"."film"."decription" IS 'description films';

INSERT INTO "film" ("id", "name", "decription") VALUES
(1,	'Василий Иванович меняет профессию',	'Комедия'),
(2,	'Любовь и голуби',	'Третья полнометражная режиссерская работа Владимира Меньшова ждет в нашем интернет-кинотеатре всех поклонников советской «нетленки».'),
(3,	'Служебный роман',	'Эту классическую историю в нашей стране знает, наверное, каждый. '),
(4,	'Девчата',	'Окончив школу, воспитанница детского дома Тося приезжает работать в уральский поселок, совсем как сказочная Золушка на бал. '),
(5,	'Операция «Ы» и другие приключения Шурика',	'Сейчас уже сложно представить, что роль простоватого студента-очкарика, героя всенародно любимых комедий Леонида Гайдая мог сыграть Виталий Соломин, Александр Збруев или даже Андрей Миронов. ');

DROP TABLE IF EXISTS "hall";
DROP SEQUENCE IF EXISTS hall_id_seq;
CREATE SEQUENCE hall_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "cinema"."hall" (
                                 "id" integer DEFAULT nextval('hall_id_seq') NOT NULL,
                                 "name" character varying,
                                 "total_places" integer,
                                 CONSTRAINT "hall_id_uindex" UNIQUE ("id"),
                                 CONSTRAINT "hall_pk" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "hall" ("id", "name", "total_places") VALUES
(1,	'Зал №1',	30),
(2,	'Зал №2',	50),
(3,	'3D зал',	15),
(4,	'4D зал',	5);

DROP TABLE IF EXISTS "order";
DROP SEQUENCE IF EXISTS order_id_seq;
CREATE SEQUENCE order_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "cinema"."order" (
                                  "id" integer DEFAULT nextval('order_id_seq') NOT NULL,
                                  "price" double precision,
                                  "date_pay" timestamp,
                                  "user_id" integer,
                                  CONSTRAINT "order_id_uindex" UNIQUE ("id"),
                                  CONSTRAINT "order_pk" PRIMARY KEY ("id"),
                                  CONSTRAINT "order_user_id_fkey" FOREIGN KEY (user_id) REFERENCES "user"(id) NOT DEFERRABLE
) WITH (oids = false);

INSERT INTO "order" ("id", "price", "date_pay", "user_id") VALUES
(2,	500,	'2020-02-04 23:07:44',	2),
(4,	150,	'2020-02-04 23:07:48',	4),
(5,	350,	'2020-02-04 23:07:49',	5),
(3,	500,	'2020-02-04 23:07:47',	3),
(6,	6000,	'2020-02-04 23:18:38',	1),
(7,	3800,	'2020-02-04 23:19:07',	3),
(1,	11000,	'2020-02-03 23:28:11',	1),
(8,	6000,	'2020-02-04 23:23:35',	5),
(9,	10000,	'2020-02-04 23:24:12',	4),
(10,	600,	'2020-02-04 23:36:19',	1),
(11,	700,	'2020-02-04 23:36:28',	4);

DROP TABLE IF EXISTS "place";
DROP SEQUENCE IF EXISTS places_id_seq;
CREATE SEQUENCE places_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "cinema"."place" (
                                  "id" integer DEFAULT nextval('places_id_seq') NOT NULL,
                                  "hall_id" integer,
                                  "number" integer,
                                  "price" double precision,
                                  CONSTRAINT "places_id_uindex" UNIQUE ("id"),
                                  CONSTRAINT "places_pk" PRIMARY KEY ("id"),
                                  CONSTRAINT "place_hall_id_fkey" FOREIGN KEY (hall_id) REFERENCES hall(id) NOT DEFERRABLE
) WITH (oids = false);

INSERT INTO "place" ("id", "hall_id", "number", "price") VALUES
(52,	2,	1,	500),
(53,	2,	2,	500),
(54,	2,	3,	500),
(55,	2,	4,	500),
(56,	2,	5,	500),
(57,	2,	6,	500),
(58,	2,	7,	500),
(59,	2,	8,	500),
(60,	2,	9,	500),
(61,	2,	10,	500),
(62,	2,	11,	450),
(63,	2,	12,	450),
(64,	2,	13,	450),
(65,	2,	14,	450),
(66,	2,	15,	450),
(67,	2,	16,	450),
(68,	2,	17,	450),
(69,	2,	18,	450),
(70,	2,	19,	450),
(71,	2,	20,	450),
(72,	2,	21,	350),
(73,	2,	22,	350),
(74,	2,	23,	350),
(75,	2,	24,	350),
(76,	2,	25,	350),
(77,	2,	26,	350),
(78,	2,	27,	350),
(79,	2,	28,	350),
(80,	2,	29,	350),
(81,	2,	30,	350),
(82,	2,	31,	250),
(83,	2,	32,	250),
(84,	2,	33,	250),
(85,	2,	34,	250),
(86,	2,	35,	250),
(87,	2,	36,	250),
(88,	2,	37,	250),
(89,	2,	38,	250),
(90,	2,	39,	250),
(91,	2,	40,	250),
(92,	2,	41,	150),
(93,	2,	42,	150),
(94,	2,	43,	150),
(95,	2,	44,	150),
(96,	2,	45,	150),
(97,	2,	46,	150),
(98,	2,	47,	150),
(99,	2,	48,	150),
(100,	2,	49,	150),
(101,	2,	50,	150),
(102,	1,	1,	700),
(103,	1,	2,	700),
(104,	1,	3,	700),
(105,	1,	4,	700),
(106,	1,	5,	700),
(107,	1,	6,	700),
(108,	1,	7,	700),
(109,	1,	8,	700),
(110,	1,	9,	700),
(111,	1,	10,	700),
(112,	1,	11,	650),
(113,	1,	12,	650),
(114,	1,	13,	650),
(115,	1,	14,	650),
(116,	1,	15,	650),
(117,	1,	16,	650),
(118,	1,	17,	650),
(119,	1,	18,	650),
(120,	1,	19,	650),
(121,	1,	20,	650),
(122,	1,	21,	600),
(123,	1,	22,	600),
(124,	1,	23,	600),
(125,	1,	24,	600),
(126,	1,	25,	600),
(127,	1,	26,	600),
(128,	1,	27,	600),
(129,	1,	28,	600),
(130,	1,	29,	600),
(131,	1,	30,	600),
(132,	3,	1,	2000),
(133,	3,	2,	2000),
(134,	3,	3,	2000),
(135,	3,	4,	1950),
(136,	3,	5,	1950),
(137,	3,	6,	1950),
(138,	3,	7,	1950),
(139,	3,	8,	1950),
(140,	3,	9,	1900),
(141,	3,	10,	1900),
(142,	3,	11,	1900),
(143,	3,	12,	1900),
(144,	3,	13,	1850),
(145,	3,	14,	1850),
(146,	3,	15,	1850),
(147,	4,	1,	6000),
(148,	4,	2,	6000),
(149,	4,	3,	6000),
(150,	4,	4,	5000),
(151,	4,	5,	5000);

DROP TABLE IF EXISTS "session";
DROP SEQUENCE IF EXISTS sessions_id_seq;
CREATE SEQUENCE sessions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "cinema"."session" (
                                    "id" integer DEFAULT nextval('sessions_id_seq') NOT NULL,
                                    "film_id" integer NOT NULL,
                                    "hall_id" integer,
                                    "date_delivery" timestamp,
                                    CONSTRAINT "sessions_id_uindex" UNIQUE ("id"),
                                    CONSTRAINT "sessions_pk" PRIMARY KEY ("id"),
                                    CONSTRAINT "session_film_id_fkey" FOREIGN KEY (film_id) REFERENCES film(id) NOT DEFERRABLE,
                                    CONSTRAINT "session_hall_id_fkey" FOREIGN KEY (hall_id) REFERENCES hall(id) NOT DEFERRABLE
) WITH (oids = false);

INSERT INTO "session" ("id", "film_id", "hall_id", "date_delivery") VALUES
(2,	2,	2,	'2020-02-10 12:33:08'),
(3,	2,	1,	'2020-02-09 10:00:00'),
(4,	4,	4,	'2020-02-10 10:00:00'),
(6,	5,	3,	'2020-02-24 12:00:00'),
(7,	3,	1,	'2020-02-07 22:00:00'),
(1,	1,	1,	'2020-01-31 10:00:00'),
(8,	2,	4,	'2020-01-31 10:00:00'),
(9,	2,	2,	'2020-01-31 10:00:00'),
(10,	1,	2,	'2020-01-31 12:00:00');

DROP TABLE IF EXISTS "ticket";
DROP SEQUENCE IF EXISTS ticket_id_seq;
CREATE SEQUENCE ticket_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "cinema"."ticket" (
                                   "id" integer DEFAULT nextval('ticket_id_seq') NOT NULL,
                                   "film_id" integer NOT NULL,
                                   "hall_id" integer NOT NULL,
                                   "sessions_id" integer NOT NULL,
                                   "places_id" integer NOT NULL,
                                   "basket_id" integer,
                                   "order_id" integer,
                                   "user_id" integer,
                                   CONSTRAINT "ticket_id_uindex" UNIQUE ("id"),
                                   CONSTRAINT "ticket_pk" PRIMARY KEY ("id"),
                                   CONSTRAINT "ticket_basket_id_fkey" FOREIGN KEY (basket_id) REFERENCES basket(id) NOT DEFERRABLE,
                                   CONSTRAINT "ticket_film_id_fkey" FOREIGN KEY (film_id) REFERENCES film(id) NOT DEFERRABLE,
                                   CONSTRAINT "ticket_hall_id_fkey" FOREIGN KEY (hall_id) REFERENCES hall(id) NOT DEFERRABLE,
                                   CONSTRAINT "ticket_order_id_fkey" FOREIGN KEY (order_id) REFERENCES "order"(id) NOT DEFERRABLE,
                                   CONSTRAINT "ticket_places_id_fkey" FOREIGN KEY (places_id) REFERENCES place(id) NOT DEFERRABLE,
                                   CONSTRAINT "ticket_sessions_id_fkey" FOREIGN KEY (sessions_id) REFERENCES session(id) NOT DEFERRABLE,
                                   CONSTRAINT "ticket_user_id_fkey" FOREIGN KEY (user_id) REFERENCES "user"(id) NOT DEFERRABLE
) WITH (oids = false);

INSERT INTO "ticket" ("id", "film_id", "hall_id", "sessions_id", "places_id", "basket_id", "order_id", "user_id") VALUES
(4,	4,	4,	4,	151,	2,	1,	1);

DROP TABLE IF EXISTS "user";
DROP SEQUENCE IF EXISTS user_id_seq;
CREATE SEQUENCE user_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "cinema"."user" (
                                 "id" integer DEFAULT nextval('user_id_seq') NOT NULL,
                                 "name" character varying,
                                 "last_name" character varying,
                                 "email" character varying,
                                 "password" integer,
                                 "phone" character varying,
                                 CONSTRAINT "user_id_uindex" UNIQUE ("id"),
                                 CONSTRAINT "user_pk" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "user" ("id", "name", "last_name", "email", "password", "phone") VALUES
(1,	'ALex',	'Mostovoy',	'mostovoi@bk.ru',	123456,	'9552213652'),
(2,	'Igor',	'Alohin',	'alohin@bk.ru',	123456,	'9999999999'),
(3,	'Sash',	'Kirova',	'kirova@bk.ru',	123456,	'8888888888'),
(4,	'Masha',	'Samsonova',	'samsonova@bk.ru',	123456,	'8888888889'),
(5,	'Dasha',	'Shevtsova',	'shevtsova@bk.ru',	123456,	'7777777778');

-- 2020-02-04 20:44:20.784088+00