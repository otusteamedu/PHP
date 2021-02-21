deploy postgres - see hw-3-1-lesson7/readme.md


- оыты с 10 тысячами (10k) и миллионом (1M) записей в таблице
* dml.sql
```
CREATE OR REPLACE FUNCTION get_big_number_objects() RETURNS INTEGER AS $$
BEGIN RETURN 10000; END;
-- BEGIN RETURN 1000000; END;
$$ LANGUAGE 'plpgsql' STRICT;
```
