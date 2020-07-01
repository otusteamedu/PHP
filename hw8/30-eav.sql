CREATE TABLE public.movies_attributes_types (
    attr_yd   SERIAL,
    type_name VARCHAR(256),
    CONSTRAINT movies_attributes_types_pk PRIMARY KEY (attr_yd)
);

INSERT INTO public.movies_attributes_types(type_name)
VALUES ('текстовое значение')
     , ('логическое значение')
     , ('дата');

CREATE TABLE public.movies_attributes (
    attr_id   SERIAL,
    attr_name VARCHAR(256) NOT NULL,
    attr_yd   INTEGER NOT NULL,
    CONSTRAINT movies_attributes_pk PRIMARY KEY (attr_id),
    CONSTRAINT movies_attributes_fk_types FOREIGN KEY (attr_yd) REFERENCES public.movies_attributes_types(attr_yd)
);

INSERT INTO public.movies_attributes(attr_yd, attr_name)
VALUES (1, 'рецензии критиков')
     , (1, 'отзыв неизвестной киноакадемии')
     , (2, 'премия оскар')
     , (2, 'премия ника')
     , (3, 'премьера в мире')
     , (3, 'премьера в РФ')
     , (3, 'дата начала продажи билетов')
     , (3, 'дата запуска рекламы на ТВ');

CREATE TABLE public.movies_attributes_values (
    movie_id   INTEGER NOT NULL,
    attr_id    INTEGER NOT NULL,
    value_text TEXT NULL,
    value_bool BOOLEAN NULL,
    value_date DATE NULL,
    CONSTRAINT movies_attributes_values_pk PRIMARY KEY (movie_id, attr_id),
    CONSTRAINT movies_attributes_values_fk_movies FOREIGN KEY (movie_id) REFERENCES public.movies (movie_id),
    CONSTRAINT movies_attributes_values_fk_attributes FOREIGN KEY (attr_id) REFERENCES public.movies_attributes (attr_id)
);

CREATE INDEX movies_attributes_values_ix_attr_id ON public.movies_attributes_values (attr_id);

INSERT INTO public.movies_attributes_values(movie_id, attr_id, value_text, value_bool, value_date)
SELECT mm.movie_id
     , ma.attr_id
     , CASE WHEN ma.attr_yd = 1 THEN CONCAT('оценка: ', FLOOR(RANDOM() * 100 + 1)::INT, ' из 100') ELSE NULL END AS value_text
     , CASE WHEN ma.attr_yd = 2 THEN (CASE WHEN RANDOM() < 0.5 THEN TRUE ELSE FALSE END) ELSE NULL END AS value_bool
     , CASE WHEN ma.attr_yd = 3 THEN (CURRENT_TIMESTAMP + FLOOR(RANDOM() * 61)::INT * INTERVAL '1 DAY')::DATE ELSE NULL END AS value_date
  FROM public.movies AS mm
 CROSS JOIN public.movies_attributes AS ma;

CREATE VIEW public.service_tasks AS
SELECT mm.movie
     , STRING_AGG(NULLIF(CONCAT(ma00.attr_name, ': ', av00.value_date), ': '), '; ') AS tasks_today
     , STRING_AGG(NULLIF(CONCAT(ma20.attr_name, ': ', av20.value_date), ': '), '; ') AS tasks_20
  FROM public.movies AS mm
  LEFT JOIN public.movies_attributes_values AS av00
    ON av00.movie_id = mm.movie_id
   AND av00.attr_id IN (7, 8)
   AND av00.value_date = CURRENT_DATE
  LEFT JOIN public.movies_attributes AS ma00
    ON ma00.attr_id = av00.attr_id
  LEFT JOIN public.movies_attributes_values AS av20
    ON av20.movie_id = mm.movie_id
   AND av20.attr_id IN (7, 8)
   AND av20.value_date >= CURRENT_DATE + INTERVAL '20 DAY'
  LEFT JOIN public.movies_attributes AS ma20
    ON ma20.attr_id = av20.attr_id
 GROUP BY mm.movie_id;

CREATE VIEW public.marketing_view AS
SELECT mm.movie
     , mat.type_name
	 , ma.attr_name
	 , CASE ma.attr_yd
	     WHEN 1 THEN av.value_text
	     WHEN 2 THEN (CASE WHEN av.value_bool THEN 'есть' ELSE 'нет' END)::TEXT
	     WHEN 3 THEN av.value_date::TEXT
		 ELSE NULL
	   END AS attr_value
  FROM public.movies_attributes_values AS av
 INNER JOIN public.movies AS mm
    ON mm.movie_id = av.movie_id
 INNER JOIN public.movies_attributes AS ma
    ON ma.attr_id = av.attr_id
 INNER JOIN public.movies_attributes_types AS mat
    ON mat.attr_yd = ma.attr_yd;