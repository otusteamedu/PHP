-- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
WITH Tasks AS
         (
             SELECT film_id, value_date AS date, filmsAttr.attr AS task
             FROM services
                      LEFT JOIN filmsAttrValues AS AttrVal ON AttrVal.attr_id = services.attr_id
                      LEFT JOIN filmsAttr ON filmsAttr.id = services.attr_id
         )

SELECT films.name, TasksNow.task AS today, TasksLater.task AS later
FROM films
         LEFT JOIN Tasks AS TasksNow ON films.id = TasksNow.film_id AND TasksNow.date <= CURRENT_DATE
         LEFT JOIN Tasks AS TasksLater ON films.id = TasksLater.film_id AND TasksLater.date >= (CURRENT_DATE + 20)
WHERE TasksNow.date IS NOT NULL
  AND TasksLater.date IS NOT NULL
ORDER BY TasksLater.date;

--фильм, тип атрибута, атрибут, значение (значение выводим как текст)
SELECT name, attr_type, attr, concat(filmsattrvalues.value_str, ' ', filmsattrvalues.description, ' ', filmsattrvalues.value_date)::text AS value
FROM filmsattrvalues
         LEFT JOIN filmsattr ON filmsattrvalues.attr_id = filmsattr.id
         LEFT JOIN films on films.id = filmsattrvalues.film_id
         LEFT JOIN filmsattrtypes on filmsattr.type_id = filmsattrtypes.id
ORDER BY films.id;