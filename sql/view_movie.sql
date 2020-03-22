-- View сборки служебных данных в форме (три колонки): фильм, задачи актуальные на сегодня, задачи
-- актуальные через 20 дней.

-- View сборки данных для маркетинга в форме (три колонки): фильм, тип атрибута, атрибут, значение
-- (значение выводим как текст)

CREATE VIEW movie_attributes_view AS
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

-- UNDO

DROP VIEW movie_attributes_view;
