select films.name as film_name, film_attr."name" as attr_name, concat(t1.val_date, t1.val_money, t1.val_text) as value
from value_film_attr as t1
inner join films on films.film_id = t1.film_id
inner join film_attr on film_attr.attr_id = t1.attr_id
inner join type_attr on type_attr.type_id = film_attr.type_id

select films.name as film_name, film_attr."name" as task_name, t1.val_date as deadline
from value_film_attr as t1
inner join films on films.film_id = t1.film_id
inner join film_attr on film_attr.attr_id = t1.attr_id
inner join type_attr on type_attr.type_id = film_attr.type_id
where t1.attr_id IN (6,7) and t1.val_date BETWEEN current_date and  current_date + 60;

SELECT
   film_name,
   SUM(sum) AS total_sum
FROM
   (
      SELECT
         *
      FROM
         (
            SELECT
               available_film.film_id,
               available_film.name as film_name,
               schedule.seance_id
            FROM
               available_film
               INNER JOIN
                  "schedule"
                  ON available_film.film_id = schedule.film_id
         )
         as tb1
         INNER JOIN
            (
               SELECT
                  "order".seance_id,
                  "payment_data".sum
               FROM
                  "order"
                  INNER JOIN
                     "payment_data"
                     ON "order".payment_id = payment_data.payment_id
            )
            as tb2
            ON tb1.seance_id = tb2.seance_id
   )
   as result_select
GROUP BY
   film_name
ORDER BY total_sum DESC;
