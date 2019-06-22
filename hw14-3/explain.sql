-- ORIGINAL SQL
SELECT (
    SELECT CONCAT(c.first_name, ' ', c.last_name) FROM `client` c WHERE c.id = t.client_id LIMIT 1
) as `client`,
(
    SELECT c.title FROM `composition` c WHERE c.id = (SELECT b.composition_id FROM `book` b WHERE b.id = t.book_id)
) as `book`,
(
    SELECT CONCAT(a.last_name, ' ', a.first_name) FROM `author` a WHERE a.id = (
        SELECT c.author_id FROM `composition` c WHERE c.id = (
            SELECT b.composition_id FROM `book` b WHERE b.id = t.book_id
        )
    )
) as `author`,
t.expired_at 
  FROM `ticket` t
 WHERE t.`status` = 1
ORDER BY `book`;


-- EXPALIN BEFORE
|id |select_type        |table |partitions |type      |possible_keys |key     |key_len |ref                 |rows |filtered|Extra                                        |
|---|-------------------|------|-----------|----------|--------------|--------|--------|--------------------|-----|--------|---------------------------------------------|
|1  |PRIMARY            |t     |           |ALL       |              |        |        |                    |4968 |10      |Using where; Using temporary; Using filesort |
|5  |DEPENDENT SUBQUERY |a     |           |eq_ref    |PRIMARY       |PRIMARY |8       |func                |1    |100     |Using where                                  |
|6  |DEPENDENT SUBQUERY |c     |           |eq_ref    |PRIMARY       |PRIMARY |8       |func                |1    |100     |Using where                                  |
|7  |DEPENDENT SUBQUERY |b     |           |eq_ref    |PRIMARY       |PRIMARY |8       |library.t.book_id   |1    |100     |                                             |
|3  |DEPENDENT SUBQUERY |c     |           |eq_ref    |PRIMARY       |PRIMARY |8       |func                |1    |100     |Using where                                  |
|4  |DEPENDENT SUBQUERY |b     |           |eq_ref    |PRIMARY       |PRIMARY |8       |library.t.book_id   |1    |100     |                                             |
|2  |DEPENDENT SUBQUERY |c     |           |eq_ref    |PRIMARY       |PRIMARY |8       |library.t.client_id |1    |100     |                                             |



-- OPTIMIZATION
-- Едиснвенное что я могу здесть оптимизировать - это накрутить индекс на ticket.status чтобы отфильтровать status = 1 быстрее:
---
ALTER TABLE `library`.`ticket` ADD INDEX `idx_ticket_status` (`status` ASC);


-- REFACTOR SQL
-- Переделал в более красивый SQL на JOIN-ах:
---
select 
  concat(`client`.first_name, `client`.last_name) as `client`,
  composition.title as book,
  concat(author.last_name, author.first_name) as author,
  ticket.expired_at
from composition 
join book on book.composition_id = composition.id
join ticket on ticket.book_id = book.id and ticket.status = 1
join `client` on `client`.id = ticket.client_id
join author on author.id = composition.author_id
order by composition.title;


--EXPLAIN AFTER
-- Здесь видно, что кол-во rows в ticket стало меньшне блягодаря новому индексу:
---
|id |select_type |table       |partitions |type   |possible_keys     |key               |key_len |ref                           |rows |filtered|Extra                                        |
|---|------------|------------|-----------|-------|------------------|------------------|--------|------------------------------|-----|--------|---------------------------------------------|
|1  |SIMPLE      |ticket      |           |ref    |idx_ticket_status |idx_ticket_status |2       |const                         |2497 |100     |Using where; Using temporary; Using filesort |
|1  |SIMPLE      |book        |           |eq_ref |PRIMARY           |PRIMARY           |8       |library.ticket.book_id        |1    |100     |Using where                                  |
|1  |SIMPLE      |composition |           |eq_ref |PRIMARY           |PRIMARY           |8       |library.book.composition_id   |1    |100     |Using where                                  |
|1  |SIMPLE      |author      |           |eq_ref |PRIMARY           |PRIMARY           |8       |library.composition.author_id |1    |100     |                                             |
|1  |SIMPLE      |client      |           |eq_ref |PRIMARY           |PRIMARY           |8       |library.ticket.client_id      |1    |100     |                                             |
