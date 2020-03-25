-- Функция для boolean

create function bool_to_string(b boolean) returns text as
$$
declare
begin
  if b then 
      return 'да';
  end if;
  if not b then 
      return 'нет';
  end if;

  return null;
end;
$$ language plpgsql;


-- View для маркетинга

CREATE VIEW films_marketing AS SELECT
       f.name as film_name,
       tt.name as type_name,
       fa.name as attr_name,
       COALESCE(text(fv.val_date), text(fv.val_float), text(fv.val_text), text(fv.val_int), bool_to_string(fv.val_bool)) as value
FROM public.tFilms f
LEFT JOIN public.tFilmsValues fv ON f.film_id = fv.film_id
LEFT JOIN public.tFilmsAttrs fa ON fv.attr_id = fa.attr_id
LEFT JOIN public.tTypes tt ON fa.type_id = tt.type_id


-- View для сборки служебных данных

CREATE VIEW films_service AS SELECT
       f.name as film_name,
       fa.name as attr_name,
       fv.val_date as date
FROM public.tFilms f
LEFT JOIN public.tFilmsValues fv ON f.film_id = fv.film_id
LEFT JOIN public.tFilmsAttrs fa ON fv.attr_id = fa.attr_id
LEFT JOIN public.tTypes tt ON fa.type_id = tt.type_id
WHERE tt.name = 'Служебная дата' AND fv.val_date in (date(now()), date(now()+'20 day'::interval))


