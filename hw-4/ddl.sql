CREATE TABLE tMovies (
  id          SERIAL PRIMARY KEY,
  name        varchar(140) NOT NULL UNIQUE
);

CREATE TABLE tMovieAttrs (
  id	      SERIAL PRIMARY KEY,
  type_id     int NOT NULL REFERENCES tMovieAttrTypes(id),
  name        varchar(140) NOT NULL
);

CREATE TABLE tMovieAttrTypes (
  id           SERIAL PRIMARY KEY,
  name         varchar(50) NOT NULL UNIQUE
);

CREATE TABLE tMovieAttrValues (
  id           SERIAL PRIMARY KEY,
  movie_id     int NOT NULL REFERENCES tMovies(id),
  attr_id      int NOT NULL REFERENCES tMovieAttrs(id),
  val_text     text,
  val_float    float(24),
  val_int      int,
  val_date     date,
  val_bool     boolean
);


CREATE VIEW viewMovies(id, name, attr_type, attr_name, attr_value) AS
  SELECT 
    tMovie.id              AS id,
    tMovie.name            AS name,
    tMovieAttrTypes.name   AS attr_type,
    tMoviesAttrs.name      AS attr_name,
    COALESCE(
      tMovieAttrValues.val_float::text,
      tMovieAttrValues.val_int::text,
      tMovieAttrValues.val_data::text,
      tMovieAttrValues.val_data::text,
      tMovieAttrValues.val_text
    ) AS attr_value
  FROM 
    tMovies
    LEFT JOIN tMovieAttrValues ON tMovies.id = tMovieAttrValues.movie_id
    LEFT JOIN tMovieAttrs      ON tMovieAttrValues.attr_id = tMovieAttrs.id
    LEFT JOIN tMovieAttrTypes  ON tMovieAttrs.type_id = tMovieAttrTypes.id
  ORDER BY
    tMovie.id, tMovieAttrs.name;

CREATE VIEW viewMoviesTasks(movie_name, today_tasks, 20_days_tasks) AS
  WITH 
  today_tasks AS (
    SELECT 
      tMovieAttrValues.movie_id
      tMovieAttrs.name as attr_name
    FROM
      tMovieAttrValues
      LEFT JOIN tMovieAttrs ON tMovieAttrValues.attr_id = tMovieAttrs.id
    WHERE
      tMovieAttrValues.val_date = CURRENT_DATE
    ORDER BY
      tMovieAttrValues.movie_id DESC
  ),
  20_days_tasks AS (
    SELECT
      tMovieAttrValues.movie_id
      tMovieAttrs.name as attr_name
    FROM
      tMovieAttrValues
      LEFT JOIN tMovieAttrs ON tMovieAttrValues.attr_id = tMovieAttrs.id
    WHERE
      tMovieAttrValues.val_date >= CURRENT_DATE
      AND tMovieAttrValues.val_date <= (CURRENT_DATE + interval '20 days')
    ORDER BY
      tMovieAttrValues.movie_id DESC
  )
  SELECT
    tMovies.name            AS movie_name,
    today_tasks.attr_name   AS today_tasks,
    20_days_tasks.attr_name AS 20_days_tasks
  FROM
    tMovies
    LEFT JOIN today_tasks ON tMovies.id = today_tasks.movie_id
    LEFT JOIN 20_days_tasks ON tMovies.id = 20_days_tasks.movie_id
  ORDER BY
    tMovies.name;
    