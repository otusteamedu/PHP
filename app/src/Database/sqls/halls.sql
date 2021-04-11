DROP table IF EXISTS public.halls;

CREATE TABLE public.halls (
      id serial PRIMARY KEY,
      "name" varchar(20) NOT NULL,
      description varchar(255) NULL,
      capacity smallint NOT NULL,
      "rows" smallint NOT NULL,
      created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO public.halls (id,"name",description,capacity,created_at,updated_at,"rows") VALUES
(1,'Синий','1 этаж',110,'2021-03-08 14:02:10.807592','2021-03-08 14:02:10.807592',10),
(2,'Зеленый','1 этаж',50,'2021-03-08 14:02:37.249916','2021-03-08 14:02:37.249916',5),
(3,'Красный','2 этаж',78,'2021-03-08 14:03:00.385993','2021-03-08 14:03:00.385993',8);