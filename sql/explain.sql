-- Запрос 1
EXPLAIN ANALYZE
SELECT *
FROM movies_attributes_value
WHERE attribute_id = 6
  AND int_value > 300;

-- Запрос 2
EXPLAIN ANALYZE
SELECT *
FROM movies_attributes_value
WHERE attribute_id = 11
  AND date_value > '2020-03-01 00:00:00.000000';

-- Запрос 3
EXPLAIN ANALYZE
SELECT *
FROM movies_attributes_value
WHERE attribute_id = 5
  AND numeric_value > 290;

-- Запрос 4
EXPLAIN (ANALYZE, BUFFERS )
SELECT m.name AS movie, at.name AS type, ma.name AS attribute,
       CASE
           WHEN ma.type_id = 1 THEN mav.text_value
           WHEN ma.type_id = 2 THEN mav.numeric_value::varchar
           WHEN ma.type_id = 3 THEN mav.int_value::varchar
           WHEN ma.type_id = 4 THEN to_char(mav.date_value, 'DD Mon YYYY HH:MI:SS')
           WHEN ma.type_id = 5 AND mav.int_value = 1 THEN 1::char
           WHEN ma.type_id = 5 AND mav.int_value = 0 THEN 0::char
           ELSE 'unknown type'
       END AS value
FROM movies m
     JOIN movies_attributes_value mav ON m.id = mav.movie_id
     JOIN movies_attributes ma ON mav.attribute_id = ma.id
     JOIN attributes_types at ON ma.type_id = at.id
WHERE ma.is_system IS FALSE;

-- Запрос 5
-- Сколько у фильма заполнено атрибут
EXPLAIN (ANALYZE, BUFFERS)
SELECT mav.movie_id, m.name, count(mav.attribute_id) attr_count
FROM movies_attributes_value mav
    JOIN movies m ON mav.movie_id = m.id
WHERE mav.attribute_id = 6
    AND mav.int_value > 200
GROUP BY mav.movie_id, m.name
ORDER BY attr_count DESC;

--------
-- INDEX

CREATE INDEX "idx-movies_attributes_value-int_value" ON movies_attributes_value(int_value);
DROP INDEX "idx-movies_attributes_value-int_value";

CREATE INDEX "idx-movies_attributes_value-numeric_value" ON movies_attributes_value(numeric_value);
DROP INDEX "idx-movies_attributes_value-numeric_value";

CREATE INDEX "idx-movies_attributes_value-data_value" ON movies_attributes_value(date_value);
DROP INDEX "idx-movies_attributes_value-data_value";

CREATE INDEX "idx-movies_attributes-type_id" ON movies_attributes (type_id);
DROP INDEX "idx-movies_attributes-type_id";

CREATE INDEX "idx-movies_attributes_value-movie_id" ON movies_attributes_value (movie_id);
DROP INDEX "idx-movies_attributes_value-movie_id";

CREATE INDEX "idx-movies_attributes_value-attribute_id" ON movies_attributes_value (attribute_id);
DROP INDEX "idx-movies_attributes_value-attribute_id";

--------
-- DELETE

DELETE FROM movies_attributes_value WHERE id <> 0;
ALTER SEQUENCE movies_attributes_value_id_seq RESTART WITH 1;

DELETE FROM movies_attributes WHERE id <> 0;
ALTER SEQUENCE movies_attributes_id_seq RESTART WITH 1;

DELETE FROM movies WHERE id <> 0;
ALTER SEQUENCE movies_id_seq RESTART WITH 1;
