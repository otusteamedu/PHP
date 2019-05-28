EXPLAIN
    SELECT CONCAT(cl.first_name, ' ', cl.last_name) AS `client`,
           c.title                                  as `book`,
           CONCAT(a.last_name, ' ', a.first_name)   AS `author`,
           t.expired_at
    FROM `ticket` t
             INNER JOIN `book` b ON b.id = t.book_id
             INNER JOIN `composition` c ON c.id = b.composition_id
             INNER JOIN `author` a ON a.id = c.author_id
             INNER JOIN `client` cl ON cl.id = t.client_id
    WHERE t.status = 1
    ORDER BY c.title;


EXPLAIN
    SELECT CONCAT(cl.first_name, ' ', cl.last_name) AS `client`,
           c.title                                  as `book`,
           CONCAT(a.last_name, ' ', a.first_name)   AS `author`,
           t.expired_at
    FROM `ticket` t
             INNER JOIN `book` b ON b.id = t.book_id
             INNER JOIN `composition` c ON c.id = b.composition_id
             INNER JOIN `author` a ON a.id = c.author_id
             INNER JOIN `client` cl ON cl.id = t.client_id
    WHERE t.status = 1
    ORDER BY c.title;




