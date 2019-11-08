
/* Вспомогательные вьюхи, выводят сегодняшние события и события через 20 дней,
с группировкой по фильмам и конкатинацией событий*/

CREATE VIEW today
  AS SELECT film_id, max(film_name) AS name, max(val_date::date) as date, string_agg(a.name,chr(10)) AS evn
FROM "film" AS f
INNER JOIN "filmAttrValue" AS v1 USING (film_id)
INNER JOIN "filmAttr" AS a USING (attr_id)
WHERE 
v1.val_date::date = 'today'::date
GROUP BY film_id
;

CREATE VIEW to20day
  AS SELECT film_id, max(film_name) AS name, max(val_date::date) as date, string_agg(a.name,chr(10)) AS evn
FROM "film" AS f
INNER JOIN "filmAttrValue" AS v1 USING (film_id)
INNER JOIN "filmAttr" AS a USING (attr_id)
WHERE 
v1.val_date::date = 'today'::date + interval '20 days'
GROUP BY film_id
;



/* Вьюха событий */

CREATE VIEW events
  AS SELECT f.film_name, t1.evn AS today, t2.evn AS to20day
FROM film AS f
LEFT JOiN "today" AS t1 USING (film_id)
LEFT JOiN "to20day" AS t2 USING (film_id)
WHERE t1.evn IS NOT NULL OR t2.evn IS NOT NULL 
;


/*Маркетинговая вьюха*/

CREATE VIEW marketing
  AS SELECT f.film_name, t.name AS type, a.name AS atr, concat(v.val_date, v.val_text, v.val_bool) AS val
FROM film AS f
LEFT JOIN "filmAttrValue" AS v USING (film_id)
LEFT JOIN "filmAttr" AS a ON v.attr_id = a.attr_id
LEFT JOIN "filmAttrType" AS t ON a.type_id = t.type_id
ORDER BY f.film_id, type, atr
;

