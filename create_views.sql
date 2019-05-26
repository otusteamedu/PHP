-- -----------------------------------------------------
-- View theater.movie_market_view
-- -----------------------------------------------------
CREATE OR REPLACE VIEW "theater"."movie_market_view" AS
SELECT
       "movie"."title",
       "attribute_type"."name" AS "type",
       "attribute_name"."name" AS "attribute",
       CASE "attribute_type"."type"
             WHEN 'int'::text THEN "attribute_value"."int_val"::text
             WHEN 'timestamp'::text THEN "attribute_value"."date_val"::text
             WHEN 'text'::text THEN "attribute_value"."text_val"
             WHEN 'boolean'::text THEN "attribute_value"."bool_val"::text
             ELSE null::text
             END
       as "value"
FROM "theater"."movie"
         LEFT JOIN "theater"."movie_attribute" ON "movie"."id" = "movie_attribute"."movie_id"
         LEFT JOIN "theater"."attribute_name" ON "movie_attribute"."attribute_name_id" = "attribute_name"."id"
         LEFT JOIN "theater"."attribute_type" ON "movie_attribute"."attribute_type_id" = "attribute_type"."id"
         LEFT JOIN "theater"."attribute_value" ON "movie_attribute"."attribute_value_id" = "attribute_value"."id"
WHERE
      "attribute_type"."category" != 3 OR "attribute_type"."category" ISNULL -- 3 категория для задач
ORDER BY "movie"."id";
-- -----------------------------------------------------
-- View theater.work_task_view
-- -----------------------------------------------------
CREATE OR REPLACE VIEW work_task_view AS
SELECT
       "movie"."title", "today"."task" AS "work_for_today", "future"."task" AS "next_20_days"
FROM
     "theater"."movie"
LEFT JOIN (
    SELECT "movie_attribute"."movie_id",
            array_agg("attribute_name"."name") AS "task"
    FROM "theater"."movie_attribute"
    LEFT JOIN "theater"."attribute_name" ON "movie_attribute"."attribute_name_id" = "attribute_name"."id"
    LEFT JOIN "theater"."attribute_type" ON "movie_attribute"."attribute_type_id" = "attribute_type"."id"
    LEFT JOIN "theater"."attribute_value" ON "movie_attribute"."attribute_value_id" = "attribute_value"."id"
    WHERE
          "attribute_type"."category" = 3 AND date_val::date = current_date
    GROUP BY "movie_id"
    ORDER BY "movie_id"
) AS "today" ON "movie"."id" = "today"."movie_id"
LEFT JOIN (
    SELECT "movie_attribute"."movie_id",
            array_agg("attribute_name"."name") AS "task"
    FROM "theater"."movie_attribute"
    LEFT JOIN "theater"."attribute_name" ON "movie_attribute"."attribute_name_id" = "attribute_name"."id"
    LEFT JOIN "theater"."attribute_type" ON "movie_attribute"."attribute_type_id" = "attribute_type"."id"
    LEFT JOIN "theater"."attribute_value" ON "movie_attribute"."attribute_value_id" = "attribute_value"."id"
    WHERE
          "attribute_type"."category" = 3 AND date_val::date = current_date + interval '20d'
    GROUP BY "movie_id"
    ORDER BY "movie_id"
) AS "future" ON "movie"."id" = "future"."movie_id"
WHERE today.task NOTNULL OR future.task NOTNULL