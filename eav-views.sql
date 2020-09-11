CREATE OR REPLACE VIEW public.marketing_data_movie
AS SELECT m.title,
    ma.name,
    mat.name AS type,
    COALESCE(mav.val_int::character varying, mav.val_date::character varying, mav.val_text, mav.val_num::character varying) AS value
   FROM movie m
     JOIN movieattrvalues mav ON m.id = mav.id_movie
     LEFT JOIN movieattr ma ON mav.id_attr = ma.id
     LEFT JOIN movieattrtype mat ON ma.type = mat.id;

CREATE OR REPLACE VIEW public.movies_tasks
AS SELECT m.title,
    string_agg(
        CASE
            WHEN mav.val_date = CURRENT_DATE THEN ma.name
            ELSE NULL::character varying
        END::text, ', '::text) AS today_tasks,
    string_agg(
        CASE
            WHEN mav.val_date >= CURRENT_DATE AND mav.val_date <= (CURRENT_DATE + '20 days'::interval) THEN ma.name
            ELSE NULL::character varying
        END::text, ', '::text) AS tasks_20_days
   FROM movie m
     JOIN movieattrvalues mav ON mav.id_movie = m.id
     LEFT JOIN movieattr ma ON ma.id = mav.id_attr
  GROUP BY m.title;
