CREATE VIEW service_tasks AS 
    SELECT f.name as film, fa.name as today, Null as tw_days FROM films AS f 
    LEFT JOIN films_attrs_vals AS fv ON f.id = fv.film_id 
    INNER JOIN films_attrs AS fa ON fa.id=fv.attrs_id WHERE fa.type_id = 7 AND date_val >= CURRENT_DATE AND date_val < (CURRENT_DATE + '1 day'::interval) 
    UNION ALL 
    SELECT f.name as film,Null as today, fa.name as tw_days FROM films AS f 
    LEFT JOIN films_attrs_vals AS fv ON f.id = fv.film_id 
    INNER JOIN films_attrs AS fa ON fa.id=fv.attrs_id WHERE fa.type_id = 7 AND date_val >= (CURRENT_DATE + '20 day'::interval) AND date_val < (CURRENT_DATE + '21 day'::interval);