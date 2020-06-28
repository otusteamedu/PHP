### ER модель
Файл `otus_12_diagram.png`

### DDL
Файл `cinema-ddl-eav.sql`

### Задачи
> View сборки служебных данных в форме (три колонки)
```
CREATE OR REPLACE VIEW public.service_task
AS SELECT max(m.name::text) AS movie,
    string_agg(
        CASE
            WHEN mev.date = CURRENT_DATE THEN mea.name
            ELSE NULL::character varying
        END::text, ', '::text) AS today,
    string_agg(
        CASE
            WHEN mev.date = (CURRENT_DATE + '20 days'::interval) THEN mea.name
            ELSE NULL::character varying
        END::text, ', '::text) AS after_20_days
   FROM movie m
     JOIN movie_eav_value mev ON mev.movie_id = m.id
     JOIN movie_eav_attribute mea ON mea.id = mev.attribute_id
  WHERE mea.attribute_type_id = 3
  GROUP BY m.id;
```
Результат с данными фыйл `otus_12_view1_data.png`
> View сборки данных для маркетинга в форме (три колонки)
```
CREATE OR REPLACE VIEW public.marketing_data
AS SELECT m.name AS movie,
    meat.name AS type,
    mea.name AS attribute,
        CASE
            WHEN mea.attribute_type_id = 1 THEN mev."int"::text
            WHEN mea.attribute_type_id = 2 THEN mev.text
            WHEN mea.attribute_type_id = 3 THEN mev.date::text
            WHEN mea.attribute_type_id = 4 THEN mev."varchar"::text
            WHEN mea.attribute_type_id = 5 THEN mev.bool::text
            WHEN mea.attribute_type_id = 6 THEN mev."numeric"::text
            ELSE NULL::text
        END AS value
   FROM movie m
     JOIN movie_eav_value mev ON mev.movie_id = m.id
     JOIN movie_eav_attribute mea ON mea.id = mev.attribute_id
     JOIN movie_eav_attribute_type meat ON meat.id = mea.attribute_type_id;
```
Результат с данными фыйл `otus_12_view2_data.png`