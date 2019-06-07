USE otus;

CREATE INDEX idxTicketStatus ON ticket(status);
CREATE INDEX idxCompositionTitle ON composition(title);

ALTER TABLE ticket
    ADD CONSTRAINT fkTicketClientId FOREIGN KEY (client_id) REFERENCES client(id),
    ADD CONSTRAINT fkTicketBookId FOREIGN KEY (book_id) REFERENCES book(id);

ALTER TABLE book
    ADD CONSTRAINT fkBookCompositionId FOREIGN KEY (composition_id) REFERENCES composition(id),
    ADD CONSTRAINT fkBookPublisherId FOREIGN KEY (publisher_id) REFERENCES publisher(id);

ALTER TABLE composition
    ADD CONSTRAINT fkCompositionAuthorId FOREIGN KEY (author_id) REFERENCES author(id);
