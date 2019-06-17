CREATE DATABASE cinema;

\c cinema

-- -----------------------------------------------------
-- Table hall_type
-- -----------------------------------------------------
CREATE TABLE  "hall_type" (
  id SERIAL ,
  rows INT NULL,
  row_seats INT NULL,
  PRIMARY KEY (id));



-- -----------------------------------------------------
-- Table hall
-- -----------------------------------------------------
CREATE TABLE  "hall" (
  id SERIAL,
  name VARCHAR(45) NULL,
  size INT NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_hall_size
    FOREIGN KEY (size)
    REFERENCES hall_type (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



-- -----------------------------------------------------
-- Table movie
-- -----------------------------------------------------
CREATE TABLE  "movie" (
  id SERIAL,
  name VARCHAR(45) NULL,
  PRIMARY KEY (id));



-- -----------------------------------------------------
-- Table session
-- -----------------------------------------------------
CREATE TABLE  "session" (
  id SERIAL,
  hall INT NULL,
  show INT NULL,
  datetime INT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_session_movie
    FOREIGN KEY (show)
    REFERENCES movie (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_session_hall
    FOREIGN KEY (hall)
    REFERENCES hall (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



-- -----------------------------------------------------
-- Table hall_price
-- -----------------------------------------------------
CREATE TABLE  "hall_price" (
  id SERIAL,
  hall_type INT NULL,
  rows VARCHAR(255) NULL,
  seats VARCHAR(255) NULL,
  price INT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_hall_price_type
    FOREIGN KEY (hall_type)
    REFERENCES hall_type (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



-- -----------------------------------------------------
-- Table user_type
-- -----------------------------------------------------
CREATE TABLE  "user_type" (
  id SERIAL,
  name VARCHAR(45) NULL,
  PRIMARY KEY (id));


-- -----------------------------------------------------
-- Table user
-- -----------------------------------------------------
CREATE TABLE  "user" (
  id SERIAL,
  type INT NULL,
  name VARCHAR(45) NULL,
  phone VARCHAR(45) NULL,
  pass VARCHAR(128) NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_user_1
    FOREIGN KEY (type)
    REFERENCES user_type (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



-- -----------------------------------------------------
-- Table ticket
-- -----------------------------------------------------
CREATE TABLE  "ticket" (
  id SERIAL,
  session INT NULL,
  price INT NULL,
  row INT NULL,
  seat INT NULL,
  "user" INT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_ticket_session
    FOREIGN KEY (session)
    REFERENCES session (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_ticket_price
    FOREIGN KEY (price)
    REFERENCES hall_price (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_ticket_user
    FOREIGN KEY ("user")
    REFERENCES "user" (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



-- -----------------------------------------------------
-- Table movie_rewards
-- -----------------------------------------------------
CREATE TABLE  "movie_rewards" (
  id SERIAL,
  movie INT NULL,
  print BOOLEAN NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_movie_rewards_1
    FOREIGN KEY (movie)
    REFERENCES movie (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table movie_attribute_type
-- -----------------------------------------------------
CREATE TABLE  "movie_attribute_type" (
  id INT NOT NULL,
  name VARCHAR(45) NOT NULL,
  PRIMARY KEY (id));


-- -----------------------------------------------------
-- Table movie_attribute_name
-- -----------------------------------------------------
CREATE TABLE  "movie_attribute_name" (
  id SERIAL,
  name VARCHAR(45) NOT NULL,
  PRIMARY KEY (id));


-- -----------------------------------------------------
-- Table movie_attribute_value
-- -----------------------------------------------------
CREATE TABLE  "movie_attribute_value" (
  id SERIAL,
  value_datetime DATE NULL DEFAULT NULL,
  value_bool BOOLEAN NULL DEFAULT NULL,
  value_text TEXT NULL DEFAULT NULL,
  value_int INT NULL DEFAULT NULL,
  PRIMARY KEY (id));


-- -----------------------------------------------------
-- Table movie_attribute_categ
-- -----------------------------------------------------
CREATE TABLE  "movie_attribute_categ" (
  id INT NOT NULL,
  name VARCHAR(45) NULL,
  PRIMARY KEY (id));


-- -----------------------------------------------------
-- Table movie_attribute
-- -----------------------------------------------------
CREATE TABLE  "movie_attribute" (
  id SERIAL,
  movie INT NULL,
  name INT NULL,
  type INT NULL,
  value INT NULL,
  categ INT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_movie_attribute_1
    FOREIGN KEY (movie)
    REFERENCES movie (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_movie_attribute_2
    FOREIGN KEY (type)
    REFERENCES movie_attribute_type (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_movie_attribute_3
    FOREIGN KEY (name)
    REFERENCES movie_attribute_name (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_movie_attribute_4
    FOREIGN KEY (value)
    REFERENCES movie_attribute_value (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_movie_attribute_5
    FOREIGN KEY (categ)
    REFERENCES movie_attribute_categ (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Placeholder table for view movie_attributes
-- -----------------------------------------------------
CREATE TABLE  "movie_attributes" (movieName INT, attributeType INT, attributeName INT, attributeValue INT);

-- -----------------------------------------------------
-- Placeholder table for view staff_tasks
-- -----------------------------------------------------
CREATE TABLE  "staff_tasks" (movieName INT, todayTasks INT, plus20DaysTasks INT);

-- -----------------------------------------------------
-- View movie_attributes
-- -----------------------------------------------------
DROP TABLE IF EXISTS movie_attributes CASCADE;
CREATE OR REPLACE VIEW movie_attributes AS
SELECT m.name as movieName, mat.name AS attributeType, man.name AS attributeName,
CASE
    WHEN mat.name = 'int' THEN mav.value_datetime::text
    WHEN mat.name = 'time' THEN mav.value_bool::text
    WHEN mat.name = 'text' THEN mav.value_text::text
    WHEN mat.name = 'boolean' THEN mav.value_int::text
    ELSE null
END AS attributeValue
FROM movie as m
LEFT JOIN movie_attribute AS ma ON m.id = ma.movie
LEFT JOIN movie_attribute_value AS mav ON ma.value = mav.id
LEFT JOIN movie_attribute_type AS mat ON ma.type = mat.id
LEFT JOIN movie_attribute_name AS man ON ma.name = man.id;

-- -----------------------------------------------------
-- View staff_tasks
-- -----------------------------------------------------
DROP TABLE IF EXISTS staff_tasks CASCADE;
CREATE OR REPLACE VIEW staff_tasks AS
SELECT m.name AS movieName, ma1.taskName AS todayTasks, ma1.taskName AS plus20DaysTasks
FROM movie as m
LEFT JOIN (
	SELECT ma.movie, man.name as taskName
    FROM movie_attribute AS ma
    LEFT JOIN movie_attribute_value AS mav ON ma.value = mav.id
	LEFT JOIN movie_attribute_name AS man ON ma.name = man.id
	LEFT JOIN movie_attribute_categ AS mac ON ma.categ = mac.id
    WHERE ma.categ = 1
	AND mav.value_datetime = CAST((NOW()) as date)
) AS ma1 ON m.id = ma1.movie
LEFT JOIN (
	SELECT ma.movie, man.name as taskName
    FROM movie_attribute AS ma
    LEFT JOIN movie_attribute_value AS mav ON ma.value = mav.id
	LEFT JOIN movie_attribute_name AS man ON ma.name = man.id
	LEFT JOIN movie_attribute_categ AS mac ON ma.categ = mac.id
    WHERE ma.categ = 1
	AND mav.value_datetime = CAST((NOW() + INTERVAL '20 DAYS') as date)
) AS ma2 ON m.id = ma2.movie;


-- -----------------------------------------------------
-- View movies_reviews
-- -----------------------------------------------------
DROP TABLE IF EXISTS movies_reviews CASCADE;
CREATE OR REPLACE VIEW movies_reviews AS
SELECT m.name as movieName, mav.value_text::text
FROM movie as m
LEFT JOIN movie_attribute AS ma ON m.id = ma.movie
LEFT JOIN movie_attribute_value AS mav ON ma.value = mav.id
WHERE ma.categ = 4;