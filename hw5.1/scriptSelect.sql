EXPLAIN select films.name as name, attributes.name as name_attribute, v_varchar, v_date, v_int, v_double, v_boolean, attribute_types.name as type_attribute, other 
from attribute_value 
Join films ON films.id = attribute_value.id_film
Join attributes ON attributes.id = attribute_value.id_attr
Join attribute_types ON attribute_types.id = attributes.id_type;

EXPLAIN select sessions.id, films.name as film, halls.name as hall, time, duration , base_price
from sessions
Join films ON films.id = sessions.id_film
Join halls ON halls.id = sessions.id_hall;

EXPLAIN select * from clients;

EXPLAIN select * from films;

EXPLAIN select * from tickets
join sessions ON sessions.id = tickets.id_session
where id_film = 0;

EXPLAIN select COUNT(places.id_type) from tickets
join places ON places.id  = tickets.id_place
join place_types ON place_types.id  = places.id_type;

