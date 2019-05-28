# FROM

EXPLAIN
    SELECT
           (
               SELECT CONCAT(c.first_name, ' ', c.last_name)
               FROM `client` c
               WHERE c.id = t.client_id
               LIMIT 1) as `client`,
           (
               SELECT c.title
               FROM `composition` c
               WHERE c.id = (SELECT b.composition_id FROM `book` b WHERE b.id = t.book_id)
           )            as `book`,
           (
               SELECT CONCAT(a.last_name, ' ', a.first_name)
               FROM `author` a
               WHERE a.id = (
                   SELECT c.author_id
                   FROM `composition` c
                   WHERE c.id = (
                       SELECT b.composition_id
                       FROM `book` b
                       WHERE b.id = t.book_id
                   )
               )
           )            as `author`,
           t.expired_at
    FROM `ticket` t
    WHERE t.`status` = 1
    ORDER BY `book`;

# TO

EXPLAIN
    SELECT CONCAT(c.first_name, ' ', c.last_name) as `client`,
           comp.title                             as `book`,
           CONCAT(a.last_name, ' ', a.first_name) as `author`,
           t.expired_at
    FROM author a
             join composition comp on comp.author_id = a.id
             join book b on b.composition_id = comp.id
             join ticket t on t.book_id = b.id
             join client c on t.client_id = c.id
    WHERE t.`status` = 1
    ORDER BY `book`;

# ADD INDEXES

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

