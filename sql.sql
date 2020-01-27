ALTER TABLE hw7.films.ticket
    ADD FOREIGN KEY ("film_id") REFERENCES hw7.films.films ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;