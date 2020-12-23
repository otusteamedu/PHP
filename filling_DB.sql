-- Adds items to content
insert into "content" ("name", id_genre, age_limit, movie_length)
SELECT 'movie' || generate_series(1, 10000)::text  as "name",
       random_between(1, 5) as id_genre,
       random_between(0, 18) as age_limit,
       random_between(0, 180) as movie_length;

-- Adds items to  "contentAttrValues" using table content;
DO
$do$
declare
	field_id_max integer = NULL;
    text_val text = NULL;
    boolean_val boolean = NULL;
    date_val date = NULL;
    content_id_max integer = NULL;
BEGIN	   	
   field_id_max := (select count(*) from "contentFields" cf);	
   content_id_max := (select count(*) from "content" c2);	
   FOR i IN 1..content_id_max LOOP
     FOR j IN 1..field_id_max LOOP
       text_val := NULL;
       boolean_val := NULL;
       date_val := NULL;
       if j < 4 THEN 
         text_val := random_string((random()*100)::integer);
       elseif j > 3 and j < 7 THEN 
         boolean_val := random() < 0.5;
       else 
         date_val := random_date();
       end IF;   
       insert into "contentAttrValues" ("idContent", val_text, idfield, val_date, val_boolean, val_int, val_float)
        values (i, text_val, j, date_val, boolean_val, NULL, NULL);
     END LOOP;
   END LOOP; 
END
$do$;





