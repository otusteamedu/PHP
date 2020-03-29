CREATE OR REPLACE VIEW public.view_marketing_datas
AS SELECT f.name AS film,
    fa.name AS attribut,
        case fa.id_type
            WHEN 1 THEN fav.val_text
            WHEN 2 THEN cast(fav.val_bool as text)
            WHEN 3 THEN cast(fav.val_int as text)
            WHEN 4 THEN cast(fav.val_date as text)
            WHEN 5 THEN cast(fav.val_float as text)
            ELSE NULL
        end AS value
   FROM films f
     JOIN film_attribute_values fav ON fav.id_film = f.id
     JOIN film_attributes fa ON fa.id = fav.id_attribute
  WHERE fa.id = ANY (ARRAY[2, 3, 4, 5, 6]);