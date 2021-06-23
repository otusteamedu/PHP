INSERT INTO tMovies (name)
VALUES
  ('Властелин колец. Братство кольца'),
  ('Властелин колец. Две крепости'),
  ('Властелин колец. Возвращение короля');

INSERT INTO tMovieAttrTypes ('name')
VALUES
  ('INTEGER'),
  ('FLOAT'),
  ('TEXT'),
  ('DATE'),
  ('BOOLEAN');

INSERT INTO tMovieAttrs (name, type_id)
VALUES
  ('Базовая стоимость билета', '1'),
  ('Рейтинг по мнению Ассоциации Киноманов','2'),
  ('Отзывы зрителей', '3'),
  ('Премьера в России', '4'),
  ('Сейчас в прокате');

INSERT INTO tMovieAttrValues (movie_id, attr_id, val_text, val_float, val_int, val_date)
VALUES
  (1, 1, null, null, 300, null, null),
  (1, 2, null, 9.7, null, null, null),
  (1, 3, 'Cool!', null, null, null, null),
  (1, 4, null, null, null, '2002-02-07', null); 
  (1, 5, null, null, null, null, FALSE); 
  