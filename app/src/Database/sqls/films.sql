DROP table IF EXISTS public.films;

CREATE TABLE public.films (
      id serial PRIMARY KEY,
      "name" varchar(100) NOT NULL,
      description varchar(255) NULL,
      age_restrict smallint NOT NULL,
      created_at timestamp NOT NULL,
      updated_at timestamp NOT NULL,
      duration time NOT NULL
);

INSERT INTO public.films (id,"name",description,age_restrict,created_at,updated_at,duration) VALUES
(1,'Аватар',NULL,12,'2021-03-08 14:04:39.370399','2021-03-08 14:04:39.370399','03:05:00'),
(2,'Титаник',NULL,14,'2021-03-08 14:05:18.268191','2021-03-08 14:05:18.268191','02:55:00'),
(3,'Шоу Трумена',NULL,10,'2021-03-08 14:05:55.201834','2021-03-08 14:05:55.201834','01:40:00'),
(4,'Хоббит. Нежданное путешествие',NULL,12,'2021-03-08 14:06:56.543824','2021-03-08 14:06:56.543824','03:10:00'),
(5,'Бегущий в Лабиринте','1 часть',12,'2021-03-08 14:08:03.15633','2021-03-08 14:08:03.15633','02:15:00');