/* film */
DROP TABLE IF EXISTS film CASCADE;
CREATE TABLE film (
    entity_id SERIAL PRIMARY KEY,
    name VARCHAR(255)
);

INSERT INTO film (name) VALUES ('The Shawshank Redemption');
INSERT INTO film (name) VALUES ('The Godfather');
INSERT INTO film (name) VALUES ('The Dark Knight');
INSERT INTO film (name) VALUES ('The Lord of the Rings: The Return of the King');

/* eav */
DROP TABLE IF EXISTS eav_entity_type;
CREATE TABLE eav_entity_type (
    entity_type_id SERIAL PRIMARY KEY,
    entity_name VARCHAR(40)
);

INSERT INTO eav_entity_type (entity_name) VALUES ('film');

DROP TABLE IF EXISTS eav_attribute;
CREATE TABLE eav_attribute (
    attribute_id SERIAL PRIMARY KEY,
    entity_type_id INTEGER,
    attribute_name VARCHAR(40),
    attribute_value_type VARCHAR(40)
);

INSERT INTO eav_attribute (entity_type_id, attribute_name, attribute_value_type) VALUES (1, 'Testimonial by criticals', 'text');
INSERT INTO eav_attribute (entity_type_id, attribute_name, attribute_value_type) VALUES (1, 'Testimonial by unknown film academy', 'text');
INSERT INTO eav_attribute (entity_type_id, attribute_name, attribute_value_type) VALUES (1, 'Oscar award', 'boolean');
INSERT INTO eav_attribute (entity_type_id, attribute_name, attribute_value_type) VALUES (1, 'Nika award', 'boolean');
INSERT INTO eav_attribute (entity_type_id, attribute_name, attribute_value_type) VALUES (1, 'World premier', 'date');
INSERT INTO eav_attribute (entity_type_id, attribute_name, attribute_value_type) VALUES (1, 'RF premier', 'date');
INSERT INTO eav_attribute (entity_type_id, attribute_name, attribute_value_type) VALUES (1, 'Ticket sale date', 'date');
INSERT INTO eav_attribute (entity_type_id, attribute_name, attribute_value_type) VALUES (1, 'Tv ads date', 'date');

DROP TABLE IF EXISTS eav_entity_text;
CREATE TABLE eav_entity_text (
    value_id SERIAL PRIMARY KEY,
    entity_type_id INTEGER,
    entity_id INTEGER,
    attribute_id INTEGER,
    value TEXT
);

DROP TABLE IF EXISTS eav_entity_boolean;
CREATE TABLE eav_entity_boolean (
    value_id SERIAL PRIMARY KEY,
    entity_type_id INTEGER,
    entity_id INTEGER,
    attribute_id INTEGER,
    value BOOLEAN
);

DROP TABLE IF EXISTS eav_entity_date;
CREATE TABLE eav_entity_date (
    value_id SERIAL PRIMARY KEY,
    entity_type_id INTEGER,
    entity_id INTEGER,
    attribute_id INTEGER,
    value DATE NOT NULL DEFAULT CURRENT_DATE
);

INSERT INTO eav_entity_text (entity_type_id, entity_id, attribute_id, value) VALUES (1, 1, 1, 'Deal with life or deal with death The Shawshank Redemption in my opinion, this is the rarest case when a film has surpassed the literary work for which it was created...');
INSERT INTO eav_entity_text (entity_type_id, entity_id, attribute_id, value) VALUES (1, 1, 2, 'Never give up! The film is about a man who made the only right choice in a desperate situation - to look for this very way out!...');
INSERT INTO eav_entity_boolean (entity_type_id, entity_id, attribute_id, value) VALUES (1, 1, 3, TRUE);
INSERT INTO eav_entity_boolean (entity_type_id, entity_id, attribute_id, value) VALUES (1, 1, 4, TRUE);
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 1, 5, '2020-08-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 1, 6, '2020-09-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 1, 7, '2020-07-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 1, 8, '2020-07-30');

INSERT INTO eav_entity_text (entity_type_id, entity_id, attribute_id, value) VALUES (1, 2, 1, 'Brilliant cinema, sparkling against the background of dull everyday films, brilliant cinema...');
INSERT INTO eav_entity_text (entity_type_id, entity_id, attribute_id, value) VALUES (1, 2, 2, 'There is a category of films that anyone must watch at least once in their life.');
INSERT INTO eav_entity_boolean (entity_type_id, entity_id, attribute_id, value) VALUES (1, 2, 3, TRUE);
INSERT INTO eav_entity_boolean (entity_type_id, entity_id, attribute_id, value) VALUES (1, 2, 4, FALSE);
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 2, 5, '2020-07-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 2, 6, '2020-08-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 2, 7, '2020-06-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 2, 8, '2020-06-30');

INSERT INTO eav_entity_text (entity_type_id, entity_id, attribute_id, value) VALUES (1, 3, 1, 'No doubt the film is gorgeous. The story of the struggle between good and evil, love and hate and ... the Joker!');
INSERT INTO eav_entity_text (entity_type_id, entity_id, attribute_id, value) VALUES (1, 3, 2, '..But, alas, we have to. ''The Dark Knight'' is one of the best superhero film adaptations, if not the best.');
INSERT INTO eav_entity_boolean (entity_type_id, entity_id, attribute_id, value) VALUES (1, 3, 3, TRUE);
INSERT INTO eav_entity_boolean (entity_type_id, entity_id, attribute_id, value) VALUES (1, 3, 4, FALSE);
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 3, 5, '2020-06-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 3, 6, '2020-07-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 3, 7, '2020-05-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 3, 8, '2020-05-30');

INSERT INTO eav_entity_text (entity_type_id, entity_id, attribute_id, value) VALUES (1, 4, 1, 'The film amazes with its scale, beauty and depth of images and the world itself - I still wonder how one person could create a whole world...');
INSERT INTO eav_entity_text (entity_type_id, entity_id, attribute_id, value) VALUES (1, 4, 2, 'And the music of the film is a separate conversation! The musical theme of the film is beyond praise - how can elven ballads or heroic motives against...');
INSERT INTO eav_entity_boolean (entity_type_id, entity_id, attribute_id, value) VALUES (1, 4, 3, TRUE);
INSERT INTO eav_entity_boolean (entity_type_id, entity_id, attribute_id, value) VALUES (1, 4, 4, TRUE);
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 4, 5, '2020-05-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 4, 6, '2020-06-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 4, 7, '2020-04-20');
INSERT INTO eav_entity_date (entity_type_id, entity_id, attribute_id, value) VALUES (1, 4, 8, '2020-04-30');

/* client */
DROP TABLE IF EXISTS client CASCADE;
CREATE TABLE client (
    client_id SERIAL PRIMARY KEY,
    client_name VARCHAR(255),
    client_surname VARCHAR(255),
    client_phone VARCHAR(20),
    client_email VARCHAR(320)
);

INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Ivan', 'Ivanov', '+733(585)865-47-21', 'nudif@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Petr', 'Petrov', '+709(232)216-89-57', 'dyhiqyl@mailinator.net');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Sergey', 'Sergeev', '+704(23)634-70-56', 'vemahyfaw@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Alexandr', 'Alexandrov', '+757(907)106-47-03', 'warimidul@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Ivan1', 'Ivanov1', '+733(585)865-47-20', 'nudif1@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Petr1', 'Petrov1', '+709(232)216-89-50', 'dyhiqyl1@mailinator.net');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Sergey1', 'Sergeev1', '+704(23)634-70-50', 'vemahyfaw1@mailinator.com');
INSERT INTO client (client_name, client_surname, client_phone, client_email) VALUES ('Alexandr1', 'Alexandrov1', '+757(907)106-47-00', 'warimidul1@mailinator.com');

/* hall */
DROP TABLE IF EXISTS hall_status CASCADE;
CREATE TABLE hall_status (
    hall_status_id SERIAL PRIMARY KEY,
    hall_status_name VARCHAR(40)
);

INSERT INTO hall_status (hall_status_id, hall_status_name) VALUES (1, 'doesn''t work');
INSERT INTO hall_status (hall_status_id, hall_status_name) VALUES (2, 'work');
INSERT INTO hall_status (hall_status_id, hall_status_name) VALUES (3, 'under construction');

DROP TABLE IF EXISTS hall CASCADE;
CREATE TABLE hall (
    hall_id SERIAL PRIMARY KEY,
    hall_title VARCHAR(255),
    hall_status_id INT DEFAULT 1,
    CONSTRAINT fk_hall_hall_status_id
        FOREIGN KEY (hall_status_id)
            REFERENCES hall_status(hall_status_id)
            ON DELETE CASCADE
);

INSERT INTO hall (hall_title, hall_status_id) VALUES ('a', 2);
INSERT INTO hall (hall_title, hall_status_id) VALUES ('b', 2);
INSERT INTO hall (hall_title, hall_status_id) VALUES ('c', 2);
INSERT INTO hall (hall_title, hall_status_id) VALUES ('d', 3);
INSERT INTO hall (hall_title, hall_status_id) VALUES ('e', 1);

/* seat */
DROP TABLE IF EXISTS seat_status CASCADE;
CREATE TABLE seat_status (
  seat_status_id SERIAL PRIMARY KEY,
  seat_status_name VARCHAR(40)
);

INSERT INTO seat_status (seat_status_id, seat_status_name) VALUES (1, 'free');
INSERT INTO seat_status (seat_status_id, seat_status_name) VALUES (2, 'sold out');
INSERT INTO seat_status (seat_status_id, seat_status_name) VALUES (3, 'off');

DROP TABLE IF EXISTS seat_type CASCADE;
CREATE TABLE seat_type (
  seat_type_id SERIAL PRIMARY KEY,
  seat_type_name VARCHAR(40)
);

INSERT INTO seat_type (seat_type_id, seat_type_name) VALUES (1, 'standart');
INSERT INTO seat_type (seat_type_id, seat_type_name) VALUES (2, 'premium');
INSERT INTO seat_type (seat_type_id, seat_type_name) VALUES (3, 'vip');

DROP TABLE IF EXISTS seat CASCADE;
CREATE TABLE seat (
    seat_id SERIAL PRIMARY KEY,
    hall_id INT NOT NULL,
    seat_row INT NOT NULL,
    seat_number INT NOT NULL,
    seat_type_id INT NOT NULL,
    CONSTRAINT fk_seat_hall_id
        FOREIGN KEY (hall_id)
            REFERENCES hall(hall_id)
            ON DELETE CASCADE
);

INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 1, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 2, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 3, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 4, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 1, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 2, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 3, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 4, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 5, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 6, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 7, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 8, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 9, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 5, 10, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 1, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 2, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 3, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 4, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 5, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 6, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 7, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 8, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 9, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (1, 6, 10, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 1, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 2, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 3, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 4, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 1, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 2, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 3, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 4, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 5, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 6, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 7, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 8, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 9, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 5, 10, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 1, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 2, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 3, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 4, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 5, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 6, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 7, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 8, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 9, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (2, 6, 10, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 1, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 2, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 3, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 4, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 1, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 2, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 3, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 4, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 5, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 6, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 7, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 8, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 9, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 5, 10, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 1, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 2, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 3, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 4, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 5, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 6, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 7, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 8, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 9, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (3, 6, 10, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 1, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 2, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 3, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 4, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 1, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 2, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 3, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 4, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 5, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 6, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 7, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 8, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 9, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 5, 10, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 1, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 2, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 3, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 4, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 5, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 6, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 7, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 8, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 9, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (4, 6, 10, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 1, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 2, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 3, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 1, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 2, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 3, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 4, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 5, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 6, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 7, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 8, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 9, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 4, 10, 1);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 1, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 2, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 3, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 4, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 5, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 6, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 7, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 8, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 9, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 5, 10, 2);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 1, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 2, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 3, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 4, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 5, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 6, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 7, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 8, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 9, 3);
INSERT INTO seat (hall_id, seat_row, seat_number, seat_type_id) VALUES (5, 6, 10, 3);

/* session */
DROP TABLE IF EXISTS session_status CASCADE;
CREATE TABLE session_status (
  session_status_id SERIAL PRIMARY KEY,
  session_status_name VARCHAR(40)
);

INSERT INTO session_status (session_status_id, session_status_name) VALUES (1, 'off');
INSERT INTO session_status (session_status_id, session_status_name) VALUES (2, 'on');

DROP TABLE IF EXISTS session CASCADE;
CREATE TABLE session (
    session_id SERIAL PRIMARY KEY,
    film_id INT,
    session_start_time TIMESTAMP,
    session_status_id INT DEFAULT 1,
    CONSTRAINT fk_session_film_id
        FOREIGN KEY (film_id)
            REFERENCES film(entity_id)
            ON DELETE CASCADE,
    CONSTRAINT fk_session_session_status_id
        FOREIGN KEY (session_status_id)
            REFERENCES session_status(session_status_id)
            ON DELETE CASCADE
);

INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (1, '08 September 2020 10:00', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (2, '08 September 2020 10:20', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (3, '08 September 2020 10:30', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (4, '08 September 2020 10:35', 1);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (1, '08 September 2020 13:00', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (2, '08 September 2020 13:20', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (3, '08 September 2020 13:30', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (4, '08 September 2020 13:35', 1);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (1, '08 September 2020 18:00', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (2, '08 September 2020 18:20', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (3, '08 September 2020 18:30', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (4, '08 September 2020 18:35', 1);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (1, '08 September 2020 20:00', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (2, '08 September 2020 20:20', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (3, '08 September 2020 20:30', 2);
INSERT INTO session (film_id, session_start_time, session_status_id) VALUES (4, '08 September 2020 20:35', 1);

DROP TABLE IF EXISTS session_seat CASCADE;
CREATE TABLE session_seat (
    session_seat_id SERIAL PRIMARY KEY,
    session_id INT NOT NULL,
    seat_id INT NOT NULL,
    seat_status_id INT NOT NULL,
    CONSTRAINT fk_session_seat_session_id
        FOREIGN KEY (session_id)
            REFERENCES session(session_id)
            ON DELETE CASCADE,
    CONSTRAINT fk_session_seat_seat_id
        FOREIGN KEY (seat_id)
            REFERENCES seat(seat_id)
            ON DELETE CASCADE,
    CONSTRAINT fk_session_seat_seat_status_id
        FOREIGN KEY (seat_status_id)
            REFERENCES seat_status(seat_status_id)
            ON DELETE CASCADE
);

INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 1, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 2, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 3, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 4, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 5, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 6, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 7, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 8, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 9, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 10, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 11, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 12, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 13, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 14, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 15, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 16, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 17, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 18, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 19, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 20, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 21, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 22, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 23, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 24, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 25, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 26, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 27, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 28, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 29, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 30, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 31, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 32, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 33, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 34, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 35, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 36, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 37, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 38, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 39, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 40, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 41, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 42, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 43, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 44, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 45, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 46, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 47, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 48, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 49, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 50, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 51, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 52, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 53, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 54, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 55, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 56, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 57, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 58, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 59, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (1, 60, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 61, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 62, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 63, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 64, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 65, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 66, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 67, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 68, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 69, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 70, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 71, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 72, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 73, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 74, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 75, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 76, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 77, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 78, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 79, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 80, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 81, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 82, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 83, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 84, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 85, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 86, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 87, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 88, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 89, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 90, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 91, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 92, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 93, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 94, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 95, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 96, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 97, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 98, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 99, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 100, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 101, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 102, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 103, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 104, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 105, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 106, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 107, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 108, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 109, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 110, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 111, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 112, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 113, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 114, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 115, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 116, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 117, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 118, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 119, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (2, 120, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 121, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 122, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 123, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 124, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 125, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 126, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 127, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 128, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 129, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 130, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 131, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 132, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 133, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 134, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 135, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 136, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 137, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 138, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 139, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 140, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 141, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 142, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 143, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 144, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 145, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 146, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 147, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 148, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 149, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 150, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 151, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 152, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 153, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 154, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 155, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 156, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 157, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 158, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 159, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 160, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 161, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 162, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 163, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 164, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 165, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 166, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 167, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 168, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 169, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 170, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 171, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 172, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 173, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 174, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 175, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 176, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 177, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 178, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 179, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (3, 180, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 1, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 2, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 3, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 4, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 5, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 6, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 7, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 8, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 9, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 10, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 11, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 12, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 13, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 14, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 15, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 16, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 17, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 18, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 19, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 20, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 21, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 22, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 23, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 24, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 25, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 26, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 27, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 28, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 29, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 30, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 31, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 32, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 33, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 34, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 35, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 36, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 37, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 38, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 39, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 40, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 41, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 42, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 43, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 44, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 45, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 46, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 47, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 48, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 49, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 50, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 51, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 52, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 53, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 54, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 55, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 56, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 57, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 58, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 59, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (5, 60, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 61, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 62, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 63, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 64, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 65, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 66, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 67, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 68, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 69, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 70, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 71, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 72, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 73, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 74, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 75, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 76, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 77, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 78, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 79, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 80, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 81, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 82, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 83, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 84, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 85, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 86, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 87, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 88, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 89, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 90, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 91, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 92, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 93, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 94, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 95, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 96, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 97, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 98, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 99, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 100, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 101, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 102, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 103, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 104, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 105, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 106, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 107, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 108, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 109, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 110, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 111, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 112, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 113, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 114, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 115, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 116, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 117, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 118, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 119, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (6, 120, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 121, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 122, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 123, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 124, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 125, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 126, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 127, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 128, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 129, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 130, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 131, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 132, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 133, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 134, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 135, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 136, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 137, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 138, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 139, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 140, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 141, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 142, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 143, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 144, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 145, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 146, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 147, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 148, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 149, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 150, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 151, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 152, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 153, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 154, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 155, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 156, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 157, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 158, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 159, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 160, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 161, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 162, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 163, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 164, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 165, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 166, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 167, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 168, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 169, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 170, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 171, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 172, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 173, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 174, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 175, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 176, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 177, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 178, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 179, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (7, 180, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 1, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 2, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 3, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 4, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 5, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 6, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 7, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 8, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 9, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 10, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 11, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 12, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 13, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 14, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 15, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 16, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 17, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 18, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 19, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 20, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 21, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 22, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 23, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 24, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 25, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 26, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 27, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 28, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 29, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 30, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 31, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 32, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 33, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 34, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 35, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 36, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 37, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 38, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 39, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 40, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 41, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 42, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 43, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 44, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 45, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 46, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 47, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 48, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 49, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 50, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 51, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 52, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 53, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 54, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 55, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 56, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 57, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 58, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 59, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (9, 60, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 61, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 62, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 63, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 64, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 65, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 66, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 67, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 68, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 69, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 70, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 71, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 72, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 73, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 74, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 75, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 76, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 77, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 78, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 79, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 80, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 81, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 82, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 83, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 84, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 85, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 86, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 87, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 88, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 89, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 90, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 91, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 92, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 93, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 94, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 95, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 96, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 97, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 98, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 99, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 100, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 101, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 102, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 103, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 104, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 105, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 106, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 107, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 108, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 109, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 110, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 111, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 112, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 113, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 114, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 115, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 116, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 117, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 118, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 119, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (10, 120, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 121, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 122, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 123, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 124, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 125, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 126, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 127, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 128, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 129, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 130, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 131, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 132, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 133, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 134, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 135, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 136, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 137, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 138, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 139, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 140, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 141, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 142, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 143, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 144, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 145, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 146, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 147, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 148, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 149, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 150, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 151, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 152, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 153, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 154, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 155, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 156, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 157, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 158, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 159, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 160, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 161, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 162, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 163, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 164, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 165, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 166, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 167, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 168, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 169, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 170, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 171, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 172, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 173, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 174, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 175, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 176, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 177, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 178, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 179, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (11, 180, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 1, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 2, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 3, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 4, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 5, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 6, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 7, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 8, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 9, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 10, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 11, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 12, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 13, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 14, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 15, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 16, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 17, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 18, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 19, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 20, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 21, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 22, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 23, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 24, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 25, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 26, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 27, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 28, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 29, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 30, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 31, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 32, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 33, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 34, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 35, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 36, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 37, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 38, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 39, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 40, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 41, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 42, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 43, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 44, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 45, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 46, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 47, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 48, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 49, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 50, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 51, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 52, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 53, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 54, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 55, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 56, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 57, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 58, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 59, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (13, 60, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 61, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 62, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 63, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 64, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 65, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 66, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 67, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 68, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 69, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 70, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 71, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 72, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 73, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 74, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 75, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 76, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 77, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 78, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 79, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 80, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 81, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 82, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 83, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 84, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 85, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 86, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 87, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 88, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 89, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 90, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 91, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 92, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 93, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 94, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 95, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 96, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 97, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 98, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 99, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 100, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 101, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 102, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 103, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 104, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 105, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 106, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 107, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 108, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 109, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 110, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 111, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 112, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 113, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 114, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 115, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 116, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 117, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 118, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 119, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (14, 120, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 121, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 122, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 123, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 124, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 125, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 126, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 127, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 128, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 129, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 130, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 131, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 132, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 133, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 134, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 135, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 136, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 137, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 138, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 139, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 140, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 141, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 142, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 143, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 144, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 145, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 146, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 147, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 148, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 149, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 150, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 151, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 152, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 153, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 154, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 155, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 156, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 157, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 158, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 159, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 160, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 161, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 162, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 163, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 164, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 165, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 166, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 167, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 168, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 169, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 170, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 171, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 172, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 173, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 174, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 175, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 176, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 177, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 178, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 179, 1);
INSERT INTO session_seat (session_id, seat_id, seat_status_id) VALUES (15, 180, 1);

DROP TABLE IF EXISTS session_seat_price CASCADE;
CREATE TABLE session_seat_price (
    session_id INTEGER NOT NULL,
    seat_type_id INTEGER NOT NULL,
    price NUMERIC(5,2),
    CONSTRAINT fk_session_seat_price_session_seat_type_id
        FOREIGN KEY (seat_type_id)
            REFERENCES seat_type(seat_type_id)
            ON DELETE CASCADE
);

INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (1, 1, 300.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (1, 2, 420.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (1, 3, 600.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (2, 1, 300.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (2, 2, 420.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (2, 3, 600.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (3, 1, 300.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (3, 2, 420.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (3, 3, 600.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (5, 1, 300.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (5, 2, 420.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (5, 3, 600.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (6, 1, 300.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (6, 2, 420.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (6, 3, 600.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (7, 1, 300.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (7, 2, 420.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (7, 3, 600.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (8, 1, 300.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (8, 2, 420.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (8, 3, 600.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (9, 1, 400.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (9, 2, 520.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (9, 3, 700.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (10, 1, 400.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (10, 2, 520.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (10, 3, 700.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (11, 1, 400.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (11, 2, 520.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (11, 3, 700.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (13, 1, 500.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (13, 2, 620.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (13, 3, 800.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (14, 1, 500.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (14, 2, 620.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (14, 3, 800.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (15, 1, 500.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (15, 2, 620.00);
INSERT INTO session_seat_price (session_id, seat_type_id, price) VALUES (15, 3, 800.00);

DROP TABLE IF EXISTS session_seat_client CASCADE;
CREATE TABLE session_seat_client (
    session_seat_id INT NOT NULL,
    client_id INT NOT NULL,
    CONSTRAINT fk_session_seat_client_session_seat_id
        FOREIGN KEY (session_seat_id)
            REFERENCES session_seat(session_seat_id)
            ON DELETE CASCADE,
    CONSTRAINT fk_session_seat_client_client_id
        FOREIGN KEY (client_id)
            REFERENCES client(client_id)
            ON DELETE CASCADE
);

--SELECT ss.session_seat_id as session_seat_id FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) WHERE ss.session_id = '1' AND ss.seat_status_id = '1' AND s.seat_row = '1' AND s.seat_number IN (1, 2, 3, 4);
-- returning ids session_seat_id
UPDATE session_seat SET seat_status_id = '2' WHERE session_seat_id IN (1, 2, 3, 4);
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (1, 1);
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (2, 1);
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (3, 1);
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (4, 1);


--SELECT ss.session_seat_id as session_seat_id FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) WHERE ss.session_id = '1' AND ss.seat_status_id = '1' AND s.seat_row = '1' AND s.seat_number IN (5, 6, 7, 8);
-- returning ids session_seat_id
UPDATE session_seat SET seat_status_id = '2' WHERE session_seat_id IN (5, 6, 7, 8);
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (5, 2);
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (6, 2);
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (7, 2);
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (8, 2);

--SELECT ss.session_seat_id as session_seat_id FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) WHERE ss.session_id = '1' AND ss.seat_status_id = '1' AND s.seat_row = '1' AND s.seat_number = 9;
-- returning ids session_seat_id
UPDATE session_seat SET seat_status_id = '2' WHERE session_seat_id = 9;
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (9, 3);

--SELECT ss.session_seat_id as session_seat_id FROM session_seat ss LEFT JOIN seat s ON (ss.seat_id = s.seat_id) WHERE ss.session_id = '1' AND ss.seat_status_id = '1' AND s.seat_row = '2' AND s.seat_number = 10;
-- returning ids session_seat_id
UPDATE session_seat SET seat_status_id = '2' WHERE session_seat_id = 20;
INSERT INTO session_seat_client (session_seat_id, client_id) VALUES (20, 3);

/* history */
DROP TABLE IF EXISTS history CASCADE;
CREATE TABLE history (
    history_id SERIAL PRIMARY KEY,
    session_id INT NOT NULL,
    history_total NUMERIC(8,2),
    CONSTRAINT fk_history_session_id
        FOREIGN KEY (session_id)
            REFERENCES session(session_id)
            ON DELETE CASCADE
);

INSERT INTO history (session_id, history_total) VALUES (1, 21600.00);
INSERT INTO history (session_id, history_total) VALUES (2, 21900.00);
INSERT INTO history (session_id, history_total) VALUES (3, 22400.00);
INSERT INTO history (session_id, history_total) VALUES (4, 23000.00);
INSERT INTO history (session_id, history_total) VALUES (5, 21000.00);
INSERT INTO history (session_id, history_total) VALUES (6, 18000.00);
INSERT INTO history (session_id, history_total) VALUES (7, 17500.00);
INSERT INTO history (session_id, history_total) VALUES (8, 16000.00);
INSERT INTO history (session_id, history_total) VALUES (9, 22000.00);
INSERT INTO history (session_id, history_total) VALUES (10, 24000.00);
INSERT INTO history (session_id, history_total) VALUES (11, 25000.00);
INSERT INTO history (session_id, history_total) VALUES (12, 23800.00);
INSERT INTO history (session_id, history_total) VALUES (13, 27500.00);
INSERT INTO history (session_id, history_total) VALUES (14, 28300.00);
INSERT INTO history (session_id, history_total) VALUES (15, 25400.00);
INSERT INTO history (session_id, history_total) VALUES (16, 25200.00);

SELECT h.history_total as total, f.name as film_name FROM film f LEFT JOIN session s ON (f.entity_id = s.film_id) LEFT JOIN history h ON (s.session_id = h.history_id) WHERE history_total = (SELECT MAX(history_total) FROM history);

DROP TABLE IF EXISTS task CASCADE;
CREATE TABLE task (
    task_id SERIAL PRIMARY KEY,
    task_film_id INTEGER,
    task_name VARCHAR(40),
    task_date DATE NOT NULL DEFAULT CURRENT_DATE,
     CONSTRAINT fk_task_film_id
        FOREIGN KEY (task_film_id)
            REFERENCES film(entity_id)
            ON DELETE CASCADE
);

INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'prepare tv ads', '2020-10-04');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'prepare radio ads', '2020-10-05');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'make an anouncement in cinema', '2020-10-06');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'organize free ticket program', '2020-10-07');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'send sms for clients', '2020-10-08');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'organize day of cheap tickers in cinema', '2020-10-09');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'organize day of free popcorn in cinema', '2020-10-10');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'organize family day in cinema', '2020-10-11');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'organize big menu day in cinema', '2020-10-12');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (1, 'organize new popcorn menu in cinema', '2020-10-13');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'prepare tv ads', '2020-10-08');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'prepare radio ads', '2020-10-09');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'make an anouncement in cinema', '2020-10-10');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'organize free ticket program', '2020-10-11');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'send sms for clients', '2020-10-12');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'organize day of cheap tickers in cinema', '2020-10-13');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'organize day of free popcorn in cinema', '2020-10-14');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'organize family day in cinema', '2020-10-15');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'organize big menu day in cinema', '2020-10-16');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (2, 'organize new popcorn menu in cinema', '2020-10-17');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'prepare tv ads', '2020-10-12');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'prepare radio ads', '2020-10-13');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'make an anouncement in cinema', '2020-10-14');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'organize free ticket program', '2020-10-15');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'send sms for clients', '2020-10-16');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'organize day of cheap tickers in cinema', '2020-10-14');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'organize day of free popcorn in cinema', '2020-10-15');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'organize family day in cinema', '2020-10-16');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'organize big menu day in cinema', '2020-10-17');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (3, 'organize new popcorn menu in cinema', '2020-10-18');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'prepare tv ads', '2020-10-16');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'prepare radio ads', '2020-10-17');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'make an anouncement in cinema', '2020-10-18');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'organize free ticket program', '2020-10-19');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'send sms for clients', '2020-10-20');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'organize day of cheap tickers in cinema', '2020-10-21');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'organize day of free popcorn in cinema', '2020-10-22');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'organize family day in cinema', '2020-10-23');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'organize big menu day in cinema', '2020-10-24');
INSERT INTO task (task_film_id, task_name, task_date) VALUES (4, 'organize new popcorn menu in cinema', '2020-10-25');

CREATE VIEW
    pg_service_data
    AS
    SELECT
        f.name AS film_name,
        t.task_name AS task_name_today,
        null AS task_name_after_20_days
    FROM
        task t
    LEFT JOIN
        film f
    ON
        (t.task_film_id = f.entity_id)
		WHERE t.task_date = now()::date
    UNION
    SELECT
        f.name AS film_name,
        null AS task_name_today,
        t.task_name AS task_name_after_20_days
    FROM
        task t
    LEFT JOIN
        film f
    ON
        (t.task_film_id = f.entity_id)
    WHERE
            t.task_date = now()::date + 20;

CREATE VIEW
    pg_marketing_data
    AS
    SELECT
        f.name AS film_name,
        eav_a.attribute_value_type AS attribute_type,
        eav_a.attribute_name AS attribute_name,
        eav_v.value AS attribute_value_text
    FROM
        eav_attribute eav_a
    LEFT JOIN eav_entity_text eav_v
    ON
        (eav_a.attribute_id = eav_v.attribute_id)
    LEFT JOIN film f
    ON
        (f.entity_id = eav_v.entity_id)
    WHERE
        eav_v.entity_type_id = 1
    UNION
    SELECT
        f.name AS film_name,
        eav_a.attribute_value_type AS attribute_type,
        eav_a.attribute_name AS attribute_name,
        CAST(eav_vb.value AS text) attribute_value_text
    FROM
        eav_attribute eav_a
    LEFT JOIN eav_entity_boolean eav_vb
    ON
        (eav_a.attribute_id = eav_vb.attribute_id)
    LEFT JOIN film f
    ON
        (f.entity_id = eav_vb.entity_id)
    WHERE
        eav_vb.entity_type_id = 1
    UNION
    SELECT
        f.name AS film_name,
        eav_a.attribute_value_type AS attribute_type,
        eav_a.attribute_name AS attribute_name,
        CAST(eav_vd.value AS text) attribute_value_text
    FROM
        eav_attribute eav_a
    LEFT JOIN eav_entity_date eav_vd
    ON
        (eav_a.attribute_id = eav_vd.attribute_id)
    LEFT JOIN film f
    ON
        (f.entity_id = eav_vd.entity_id)
    WHERE
        eav_vd.entity_type_id = 1
    ORDER BY film_name, attribute_type;