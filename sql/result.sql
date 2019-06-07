EXPLAIN
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

#from
#	PRIMARY	t		ALL					49929	10	Using where; Using temporary; Using filesort
#	DEPENDENT SUBQUERY	a		eq_ref	PRIMARY	PRIMARY	8	func	1	100	Using where
#	DEPENDENT SUBQUERY	c		eq_ref	PRIMARY	PRIMARY	8	func	1	100	Using where
#	DEPENDENT SUBQUERY	b		eq_ref	PRIMARY	PRIMARY	8	otus.t.book_id	1	100
#	DEPENDENT SUBQUERY	c		eq_ref	PRIMARY	PRIMARY	8	func	1	100	Using where
#	DEPENDENT SUBQUERY	b		eq_ref	PRIMARY	PRIMARY	8	otus.t.book_id	1	100
#	DEPENDENT SUBQUERY	c		eq_ref	PRIMARY	PRIMARY	8	otus.t.client_id	1	100

#to
#	PRIMARY	t		ref	idxTicketStatus	idxTicketStatus	2	const	24974	100	Using temporary; Using filesort
#	DEPENDENT SUBQUERY	a		eq_ref	PRIMARY	PRIMARY	8	func	1	100	Using where
#	DEPENDENT SUBQUERY	c		eq_ref	PRIMARY	PRIMARY	8	func	1	100	Using where
#	DEPENDENT SUBQUERY	b		eq_ref	PRIMARY	PRIMARY	8	otus.t.book_id	1	100
#	DEPENDENT SUBQUERY	c		eq_ref	PRIMARY	PRIMARY	8	func	1	100	Using where
#	DEPENDENT SUBQUERY	b		eq_ref	PRIMARY	PRIMARY	8	otus.t.book_id	1	100
#	DEPENDENT SUBQUERY	c		eq_ref	PRIMARY	PRIMARY	8	otus.t.client_id	1	100

EXPLAIN
    SELECT CONCAT(cl.first_name, ' ', cl.last_name) AS `client`,
           c.title as `book`,
           CONCAT(a.last_name, ' ', a.first_name) AS `author`,
           t.expired_at
    FROM `ticket` t
    INNER JOIN `book` b ON b.id = t.book_id
    INNER JOIN `composition` c ON c.id = b.composition_id
    INNER JOIN `author` a ON a.id = c.author_id
    INNER JOIN `client` cl ON cl.id = t.client_id
    WHERE t.status = 1
    ORDER BY c.title;

#from
#	SIMPLE	t		ALL					49948	10	Using where; Using temporary; Using filesort
#	SIMPLE	b		eq_ref	PRIMARY	PRIMARY	8	otus.t.book_id	1	100	Using where
#	SIMPLE	c		eq_ref	PRIMARY	PRIMARY	8	otus.b.composition_id	1	100	Using where
#	SIMPLE	a		eq_ref	PRIMARY	PRIMARY	8	otus.c.author_id	1	100
#	SIMPLE	cl		eq_ref	PRIMARY	PRIMARY	8	otus.t.client_id	1	100

#to
#	SIMPLE	b		index	PRIMARY,fkBookCompositionId	fkBookCompositionId	9		1200	100	Using where; Using index; Using temporary; Using filesort
#	SIMPLE	c		eq_ref	PRIMARY,fkCompositionAuthorId	PRIMARY	8	otus.b.composition_id	1	100	Using where
#	SIMPLE	a		eq_ref	PRIMARY	PRIMARY	8	otus.c.author_id	1	100
#	SIMPLE	t		ref	idxTicketStatus,fkTicketClientId,fkTicketBookId	fkTicketBookId	9	otus.b.id	42	50	Using where
#	SIMPLE	cl		eq_ref	PRIMARY	PRIMARY	8	otus.t.client_id	1	100

