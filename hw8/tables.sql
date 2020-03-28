CREATE TABLE halls
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(15),
    num_places integer
);

CREATE TABLE places
(
    id SERIAL PRIMARY KEY,
    hall_id integer REFERENCES halls(id),
    num_row integer,
    num_col integer
);

CREATE TABLE customers
(
    id serial primary key,
    name varchar(127),
    phone varchar(10)
);

CREATE TABLE films
(
    id serial primary key,
    name varchar(127),
    duration integer
);

CREATE TABLE sessions
(
    id serial primary key,
    hall_id integer REFERENCES halls(id),
    time_from time,
    time_to time
);

CREATE TABLE offers
(
    id serial primary key,
    session_id integer REFERENCES sessions(id),
    film_id integer REFERENCES films(id),
    price numeric(8,2)
);

CREATE TABLE tickets
(
    id serial primary key,
    offer_id integer REFERENCES offers(id),
    place_id integer REFERENCES places(id),
    customer_id integer REFERENCES customers(id),
    date date
);

-- самый прибыльный фильм
SELECT SUM(offers.price) AS total, films.name AS film_id
FROM tickets
LEFT JOIN offers ON tickets.offer_id = offers.id
LEFT JOIN films on offers.film_id = films.id
GROUP BY films.id
ORDER BY total DESC
FETCH FIRST 1 ROWS ONLY;


-------- EAV films
CREATE TABLE filmsAttrTypes
(
    id serial primary key,
    type varchar(15)
);

CREATE TABLE filmsAttr
(
    id serial primary key,
    attr varchar(128),
    type_id integer REFERENCES filmsAttrTypes(id)
);

CREATE TABLE  filmsAttrValues
(
    id serial primary key,
    film_id integer REFERENCES films(id),
    attr_id integer REFERENCES filmsAttr(id),
    value_str varchar,
    value_date date,
    value_bool boolean
);
CREATE INDEX films_id_index ON filmsAttrValues(film_id);

CREATE TABLE services
(
    id serial primary key,
    attr_id integer REFERENCES filmsAttr(id),
    priority integer DEFAULT 0
);

------------------------------------------------------------
----- Служебные задачи актуальные на сегодня и через 20 дней
WITH Tasks AS
(
    SELECT film_id, value_date AS date, filmsAttr.attr AS task
    FROM services
    LEFT JOIN filmsAttrValues AS AttrVal ON AttrVal.attr_id = services.attr_id
    LEFT JOIN filmsAttr ON filmsAttr.id = services.attr_id
)

SELECT films.name, TasksNow.task AS today, TasksAfter.task AS "after 20 days"
FROM films
LEFT JOIN Tasks AS TasksNow ON films.id = TasksNow.film_id AND TasksNow.date <= CURRENT_DATE
LEFT JOIN Tasks AS TasksAfter ON films.id = TasksAfter.film_id AND TasksAfter.date >= (CURRENT_DATE+20)
WHERE NOT (TasksNow.date IS NULL AND TasksAfter.date IS NULL)
ORDER BY TasksAfter.date;
------------------------------------------------------------
----- Данные для маркетинга
SELECT films.name, filmsAttrTypes.type, filmsAttr.attr,
	coalesce(filmsAttrValues.value_date::text, filmsAttrValues.value_str, filmsAttrValues.value_bool::text ) AS value
FROM filmsAttrValues
LEFT JOIN filmsAttr ON filmsAttr.id = filmsAttrValues.attr_id
LEFT JOIN filmsAttrTypes ON filmsAttr.type_id = filmsAttrTypes.id
LEFT JOIN films ON filmsAttrValues.film_id = films.id
ORDER BY films.id;