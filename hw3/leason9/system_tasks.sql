CREATE OR REPLACE VIEW public.system_tasks
AS WITH t1 AS (
    SELECT f.name,
           a.attr_name,
           at2.attr_type,
           av.attr_value
    FROM films f
             JOIN attr_values av ON av.film = f.id
             JOIN attrs a ON a.id = av.attr
             JOIN attr_types at2 ON at2.id = a.attr_type
)
   SELECT t1.name,
          t1.attr_name,
          t1.attr_value
   FROM t1
   WHERE t1.attr_type::text ~~ '%служебные даты%'::text
    AND (
        to_date(t1.attr_value, 'YYYY-MM-DD'::text) = now()
    OR  to_date(t1.attr_value, 'YYYY-MM-DD'::text) = (CURRENT_DATE + '20 days'::interval)
    );