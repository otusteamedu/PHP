/* выборка всех свободных мест на сегодняшний день */
select count(t.id)
from tickets as t
         inner join sessions s on t.sessions_id = s.id
where t.sold = true
  and s.sessions_date = current_date;

/* список фильмов с оскаром */
select f.name, count(av.attributes_text)
from films as f
         inner join attributes a on f.id = a.films_id
         inner join attributes_value av on f.id = av.film_id
where a.name like '%премия%'
  and av.attributes_text like '%оскар%'
group by f.name;

/* список сеансов на сегодня */
select f.name
from films as f
         inner join sessions s on f.id = s.film_id
where s.sessions_date = current_date;

/* получение места билета по номеру */
select site_number
from tickets
where id = 99;

/* определение фильмов "для взрослых" идущих до 22:00 */
select f.name, s.session_time
from films as f
         inner join attributes a on f.id = a.films_id
         inner join attributes_type at on at.id = a.id
         inner join attributes_value av on f.id = av.film_id
         inner join sessions s on f.id = s.film_id
where at.attributes_type = 'ratio'
  and av.attributes_text = '18+'
  and s.session_time < '22:00:00'

/* определение фильмов без постеров */
select films.name
from films
         inner join attributes a on films.id = a.films_id
         inner join attributes_value av on films.id = av.film_id
where a.name = 'poster' and av.attributes_text is null;