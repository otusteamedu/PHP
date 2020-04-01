
-- Запрос 1: Посчитать количество фильмов название которых начинается с Терм
SELECT count(name)
FROM public.films
WHERE name like 'Term%';

-- Запрос 2: Посчитать количество атрибутов фильмов у которых тип атрибута = 2
SELECT count(name)
FROM public.filmsattrs
WHERE type_id = 50;

-- Запрос 3: Выбрать сумму билетов за сентябрь 2020
SELECT sum(price) 
FROM public.tickets
WHERE date_buy >= '2020-09-01' AND date_buy <= '2020-09-30';

-- Запрос 4: Фильм который заработал самую большую сумму
SELECT fs.name as film_name, sum(ts.price) as price
FROM tickets ts
INNER JOIN timetables tt ON ts.timetable_id = tt.timetable_id
INNER JOIN films fs ON tt.film_id = fs.film_id
GROUP BY film_name
ORDER BY price DESC
LIMIT 1

-- Запрос 5: Выборка для марткетинга по фильму id=1
SELECT
    f.name as film_name,
    tt.name as type_name,
    fa.name as attr_name,
    COALESCE(text(fv.val_date), text(fv.val_float), fv.val_text, text(fv.val_int), bool_to_string(fv.val_bool)) as value
FROM public.films f
LEFT JOIN public.filmsvalues fv ON f.film_id = fv.film_id
LEFT JOIN public.filmsAttrs fa ON fv.attr_id = fa.attr_id
LEFT JOIN public.types tt ON fa.type_id = tt.type_id
WHERE f.film_id = 1


-- Запрос 6: Выборка для рабочих моментов по "Служебная дата" сегодняшней дате и +20 дней
SELECT
    f.name as film_name,
    fa.name as attr_name,
    fv.val_date as date
FROM public.tFilms f
LEFT JOIN public.tFilmsValues fv ON f.film_id = fv.film_id
LEFT JOIN public.tFilmsAttrs fa ON fv.attr_id = fa.attr_id
LEFT JOIN public.tTypes tt ON fa.type_id = tt.type_id
WHERE tt.name = 'Служебная дата' AND fv.val_date in (date(now()), date(now()+'20 day'::interval))

