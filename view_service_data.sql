CREATE OR REPLACE VIEW public.view_service_data
AS SELECT f.name AS film,
    fa.name AS attribut,
    fav.val_date AS value
   FROM films f
     JOIN film_attribute_values fav ON fav.id_film = f.id
     JOIN film_attributes fa ON fa.id = fav.id_attribute
  WHERE (fa.id = ANY (ARRAY[7, 8])) AND fav.val_date >= date(now()) AND fav.val_date <= date(now() + '20 days'::interval day);