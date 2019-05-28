create index composition_title_index
    on composition (title);

create index ticket_status_index
    on ticket (status);

alter table ticket
    add constraint ticket_book_id_fk
        foreign key (book_id) references book (id);

alter table ticket
    add constraint ticket_client_id_fk
        foreign key (client_id) references client (id);

alter table book
    add constraint book_composition_id_fk
        foreign key (composition_id) references composition (id);

alter table book
    add constraint book_publisher_id_fk
        foreign key (publisher_id) references publisher (id);

alter table composition
    add constraint composition_author_id_fk
        foreign key (author_id) references author (id);
