CREATE VIEW films_attrs_view AS 
    SELECT f.name as film, ft.descr as attr_type, fa.name as attr_name, COALESCE(int_val::text,date_val::text, text_val,float_val::text) as attr_value  
    FROM films as f INNER JOIN films_attrs_vals as fv ON f.id=fv.film_id 
    LEFT JOIN films_attrs as fa ON fv.attrs_id = fa.id 
    LEFT JOIN films_attrs_types as ft ON fa.type_id = ft.id;