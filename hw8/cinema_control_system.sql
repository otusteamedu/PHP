CREATE TABLE "cinema" (
  "cinema_id" serial2,
  "title" varchar(255),
  "address" varchar(255),
  "phone" varchar(255),
  "district" varchar(255),
  PRIMARY KEY ("cinema_id")
);

CREATE TABLE "film" (
  "film_id" serial2,
  "country" varchar(255),
  "release_date" date,
  "genre_id" int2 NOT NULL,
  "description" text,
  PRIMARY KEY ("film_id", "genre_id")
);

CREATE TABLE "genre" (
  "genre_id" serial2,
  "genre" varchar(255),
  "description" text,
  PRIMARY KEY ("genre_id")
);

CREATE TABLE "hall" (
  "hall_id" serial2,
  "title" varchar(255),
  "capasity" int2 NOT NULL,
  "is_works" bool NOT NULL,
  "cinema_id" int2 NOT NULL,
  PRIMARY KEY ("hall_id")
);
COMMENT ON COLUMN "hall"."cinema_id" IS 'Внешний ключ к таблице сinema.cinema_id';

CREATE TABLE "session" (
  "session_id" serial,
  "date" date,
  "time" time,
  "hall_id" int2 NOT NULL,
  "free_place" int2,
  "film_id" int2 NOT NULL,
  PRIMARY KEY ("session_id", "hall_id", "film_id")
);

CREATE TABLE "ticket" (
  "ticket_id" serial,
  "cost" decimal(10,4),
  "session_id" int NOT NULL,
  PRIMARY KEY ("ticket_id", "session_id")
);

ALTER TABLE "film" ADD CONSTRAINT "fk_genres" FOREIGN KEY ("genre_id") REFERENCES "genre" ("genre_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "hall" ADD CONSTRAINT "fk_cinema" FOREIGN KEY ("cinema_id") REFERENCES "cinema" ("cinema_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "session" ADD CONSTRAINT "fk_hall" FOREIGN KEY ("hall_id") REFERENCES "hall" ("hall_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "session" ADD CONSTRAINT "fk_film" FOREIGN KEY ("film_id") REFERENCES "film" ("film_id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "ticket" ADD CONSTRAINT "fk_session" FOREIGN KEY ("session_id") REFERENCES "session" ("session_id") ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO "film"("film_id", "country", "release_date", "genre_id", "description", "title") VALUES (1, 'США', '1994-01-01', 6, 'Бухгалтер Энди Дюфрейн обвинён в убийстве собственной жены и её любовника. Оказавшись в тюрьме под названием Шоушенк, он сталкивается с жестокостью и беззаконием, царящими по обе стороны решётки. Каждый, кто попадает в эти стены, становится их рабом до конца жизни. Но Энди, обладающий живым умом и доброй душой, находит подход как к заключённым, так и к охранникам, добиваясь их особого к себе расположения.', 'Побег из Шоушенка');
INSERT INTO "film"("film_id", "country", "release_date", "genre_id", "description", "title") VALUES (2, 'США', '1999-01-01', 6, 'Пол Эджкомб — начальник блока смертников в тюрьме «Холодная гора», каждый из узников которого однажды проходит «зеленую милю» по пути к месту казни. Пол повидал много заключённых и надзирателей за время работы. Однако гигант Джон Коффи, обвинённый в страшном преступлении, стал одним из самых необычных обитателей блока.', 'Зеленая миля');
INSERT INTO "film"("film_id", "country", "release_date", "genre_id", "description", "title") VALUES (3, 'США', '1994-01-01', 9, 'От лица главного героя Форреста Гампа, слабоумного безобидного человека с благородным и открытым сердцем, рассказывается история его необыкновенной жизни.



Фантастическим образом превращается он в известного футболиста, героя войны, преуспевающего бизнесмена. Он становится миллиардером, но остается таким же бесхитростным, глупым и добрым. Форреста ждет постоянный успех во всем, а он любит девочку, с которой дружил в детстве, но взаимность приходит слишком поздно.', 'Форрест Гамп');
INSERT INTO "film"("film_id", "country", "release_date", "genre_id", "description", "title") VALUES (4, 'США', '1993-01-01', 7, 'Фильм рассказывает реальную историю загадочного Оскара Шиндлера, члена нацистской партии, преуспевающего фабриканта, спасшего во время Второй мировой войны почти 1200 евреев.', 'Список Шиндлера');
INSERT INTO "film"("film_id", "country", "release_date", "genre_id", "description", "title") VALUES (5, 'Франция', '2011-01-01', 8, 'Пострадав в результате несчастного случая, богатый аристократ Филипп нанимает в помощники человека, который менее всего подходит для этой работы, — молодого жителя предместья Дрисса, только что освободившегося из тюрьмы. Несмотря на то, что Филипп прикован к инвалидному креслу, Дриссу удается привнести в размеренную жизнь аристократа дух приключений.', '1+1');
INSERT INTO "film"("film_id", "country", "release_date", "genre_id", "description", "title") VALUES (6, 'Великобритания', '2010-01-01', 14, 'Кобб — талантливый вор, лучший из лучших в опасном искусстве извлечения: он крадет ценные секреты из глубин подсознания во время сна, когда человеческий разум наиболее уязвим. Редкие способности Кобба сделали его ценным игроком в привычном к предательству мире промышленного шпионажа, но они же превратили его в извечного беглеца и лишили всего, что он когда-либо любил.', 'Начало');
INSERT INTO "film"("film_id", "country", "release_date", "genre_id", "description", "title") VALUES (10, 'СССР', '1973-01-01', 8, 'Инженер-изобретатель Тимофеев сконструировал машину времени, которая соединила его квартиру с далеким шестнадцатым веком — точнее, с палатами государя Ивана Грозного. Туда-то и попадают тезка царя пенсионер-общественник Иван Васильевич Бунша и квартирный вор Жорж Милославский.', 'Иван Васильевич меняет профессию

');
INSERT INTO "film"("film_id", "country", "release_date", "genre_id", "description", "title") VALUES (11, 'Италия', '1971-01-01', 9, 'Во время Второй мировой войны из Италии в концлагерь были отправлены евреи — отец с маленьким сыном. Жена-итальянка добровольно последовала за ними. В лагере отец сказал мальчику, что всё происходящее вокруг является большой интересной игрой за приз в виде настоящего танка. И этот классный приз достанется тому мальчику, который сможет не попасться на глаза надзирателям.', 'Жизнь прекрасна');
 
INSERT INTO "cinema"("cinema_id", "title", "address", "phone", "district") VALUES (1, 'Мир', '​Победы площадь, 1', '+7 (3852) 22‒32‒42', 'Железнодорожный район');
INSERT INTO "cinema"("cinema_id", "title", "address", "phone", "district") VALUES (2, 'Формула', '​Октябрьская, 36', '+7 (3852) 22‒60‒07', 'Октябрьский район');
INSERT INTO "cinema"("cinema_id", "title", "address", "phone", "district") VALUES (3, 'Pioneer Cinema', '​Ленина проспект, 102в', '+7 (3852) 59‒04‒12', 'Октябрьский район');
INSERT INTO "cinema"("cinema_id", "title", "address", "phone", "district") VALUES (4, 'Премьера', '​Крупской, 97', '+7 (3852) 62‒83‒30', 'Железнодорожный район');
INSERT INTO "cinema"("cinema_id", "title", "address", "phone", "district") VALUES (5, 'Матрица', '​Юрина, 275Б к2', '+7 (3852) 20‒24‒28', 'Ленинский район');

INSERT INTO "genre"("genre_id", "genre", "description") VALUES (1, 'Боевик', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (2, 'Вестерн', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (4, 'Гангстерский фильм', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (5, 'Детектив', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (6, 'Драма', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (7, 'Исторический фильм', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (8, 'Комедия', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (9, 'Мелодрама', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (10, 'Триллер', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (12, 'Сказка', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (13, 'Фильм ужасов', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (14, 'Фантастический фильм', NULL);
INSERT INTO "genre"("genre_id", "genre", "description") VALUES (15, 'Фильм-катастрофа', NULL);

INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (2, 'Квадратный', 60, 't', 1);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (3, 'Треугольный', 120, 't', 1);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (1, 'Круглый', 50, 't', 1);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (4, 'Ferrari', 100, 't', 2);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (5, 'Mercedes', 50, 't', 2);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (6, 'McLaren', 90, 'f', 2);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (7, 'Первый', 100, 't', 3);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (8, 'Второй', 120, 't', 3);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (12, 'Mars', 50, 't', 4);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (13, 'Neo', 110, 't', 5);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (14, 'Morpheus', 120, 't', 5);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (15, 'Trinity', 130, 'f', 5);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (9, 'Mercury', 50, 't', 4);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (10, 'Venus', 60, 't', 4);
INSERT INTO "hall"("hall_id", "title", "capasity", "is_works", "cinema_id") VALUES (11, 'Earth', 70, 't', 4);
