-- Функция по наполнению БД тестовыми данными. Параметр count INTEGER - количество строк для наполнения
Create or replace function cinema.set_test_data (count INTEGER)returns bool as
$$
DECLARE
  second_count integer := count / 100;

begin
  TRUNCATE "attribute" CASCADE;
  TRUNCATE "film" CASCADE;
  TRUNCATE "hall" CASCADE;

  INSERT INTO hall ("id", "name", "price_coefficient", "width", "length") VALUES (1, 'test hall', 1, 10, 10);
  INSERT INTO film("id", "name") SELECT gs.id AS id, random_string(10) AS string_10 FROM generate_series(1,count) AS gs(id);
  INSERT INTO "attribute" ("id", "name", "collumn", "type_data")
    SELECT
      gs.id AS id,
      random_string(10),
      ('{boolean,text,numeric,date,interval}'::cinema.collumn_type[])[ceil(random()*5)],
      ''
    FROM generate_series(1,count) AS gs(id);

  INSERT INTO attribute_value (attribute_id, film_id) SELECT ceil(random()*(second_count-1+1)) AS attribute_id, ceil(random()*(second_count-1+1)) AS film_id FROM generate_series(1,count);

 return true;
end;
$$ LANGUAGE plpgsql;
