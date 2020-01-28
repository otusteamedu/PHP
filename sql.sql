ALTER TABLE hw7.films.ticket
    ADD FOREIGN KEY ("film_id") REFERENCES hw7.films.films ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE hw7.films.ticket
    ADD FOREIGN KEY ("hall_id") REFERENCES hw7.films.hall ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE hw7.films.ticket
    ADD FOREIGN KEY ("sessions_id") REFERENCES hw7.films.sessions ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE hw7.films.ticket
    ADD FOREIGN KEY ("places_id") REFERENCES hw7.films.places ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE hw7.films.sessions
    ADD FOREIGN KEY ("film_id") REFERENCES hw7.films.films ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE hw7.films.places
    ADD FOREIGN KEY ("hall_id") REFERENCES hw7.films.hall ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;