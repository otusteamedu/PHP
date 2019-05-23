DELIMITER $$
CREATE PROCEDURE generateAuthors(volume INTEGER)
BEGIN
    SET @x = 0;
    TRUNCATE TABLE `author`;
    REPEAT
        INSERT INTO `author` (
            `first_name`, 
            `middle_name`, 
            `last_name`
        ) VALUES ( 
            (SELECT CONCAT('FNAME::', SHA1(CONCAT(MD5(RAND()), SHA1(RAND()))))),
            (SELECT CONCAT('MNAME::', SHA1(CONCAT(MD5(RAND()), SHA1(RAND()))))),
            (SELECT CONCAT('LNAME::', SHA1(CONCAT(MD5(RAND()), SHA1(RAND())))))
        );
        SET @x = @x + 1;
    UNTIL @x >= volume END REPEAT;
END$$
CREATE PROCEDURE generateCompositions(volume INTEGER)
BEGIN
    SET @x = 0;
    TRUNCATE TABLE `composition`;
    REPEAT
        INSERT INTO `composition` (`author_id`, `title`, `code`, `enabled`) VALUES ( 
            (SELECT IF(CEIL(MAX(id) * RAND()) = 0, 1, CEIL(MAX(id) * RAND())) FROM `author`),
            (SELECT CONCAT('COMPOSE::', SHA1(CONCAT(MD5(RAND()), SHA1(RAND()))))), 
            (SELECT MD5(CONCAT(MD5(RAND()), SHA1(RAND())))), 
            1 
        );
        SET @x = @x + 1;
    UNTIL @x >= volume END REPEAT;
END$$
CREATE PROCEDURE generatePublishers(volume INTEGER)
BEGIN
    SET @x = 0;
    TRUNCATE TABLE `publisher`;
    REPEAT
        INSERT INTO `publisher` (
            `code`, 
            `legal_name`, 
            `brand_name`
        ) VALUES ( 
            (SELECT MD5(CONCAT(MD5(RAND()), SHA1(RAND())))),
            (SELECT CONCAT('LEGAL::', SHA1(CONCAT(MD5(RAND()), SHA1(RAND()))))), 
            (SELECT CONCAT('BRAND::', SHA1(CONCAT(MD5(RAND()), SHA1(RAND())))))
        );
        SET @x = @x + 1;
    UNTIL @x >= volume END REPEAT;
END$$
CREATE PROCEDURE generateBooks(volume INTEGER)
BEGIN
    SET @x = 0;
    TRUNCATE TABLE `book`;
    REPEAT
        INSERT INTO `book` (
            `composition_id`, 
            `publisher_id`
        ) VALUES ( 
            (SELECT IF(CEIL(MAX(id) * RAND()) = 0, 1, CEIL(MAX(id) * RAND())) FROM `composition`),
            (SELECT IF(CEIL(MAX(id) * RAND()) = 0, 1, CEIL(MAX(id) * RAND())) FROM `publisher`)
        );
        SET @x = @x + 1;
    UNTIL @x >= volume END REPEAT;
END$$
CREATE PROCEDURE generateClients(volume INTEGER)
BEGIN
    SET @x = 0;
    TRUNCATE TABLE `client`;
    REPEAT
        INSERT INTO `client` (
            `first_name`, 
            `middle_name`, 
            `last_name`
        ) VALUES ( 
            (SELECT CONCAT('FNAME::', SHA1(CONCAT(MD5(RAND()), SHA1(RAND()))))),
            (SELECT CONCAT('MNAME::', SHA1(CONCAT(MD5(RAND()), SHA1(RAND()))))),
            (SELECT CONCAT('LNAME::', SHA1(CONCAT(MD5(RAND()), SHA1(RAND())))))
        );
        SET @x = @x + 1;
    UNTIL @x >= volume END REPEAT;
END$$
CREATE PROCEDURE generateTickets(volume INTEGER)
BEGIN
    SET @x = 0;
    TRUNCATE TABLE `ticket`;
    REPEAT
        INSERT INTO `ticket` (
            `client_id`, 
            `book_id`, 
            `status`
        ) VALUES ( 
            (SELECT IF(CEIL(MAX(id) * RAND()) = 0, 1, CEIL(MAX(id) * RAND())) FROM `client`),
            (SELECT IF(CEIL(MAX(id) * RAND()) = 0, 1, CEIL(MAX(id) * RAND())) FROM `book`),
            (SELECT ROUND(1 * RAND()))  
        );
        SET @x = @x + 1;
    UNTIL @x >= volume END REPEAT;
    UPDATE `ticket`
       SET `expired_at` = IF(status = 0, (SELECT NOW() - INTERVAL FLOOR(RAND() * 1000) DAY), (SELECT NOW() + INTERVAL FLOOR(RAND() * 14) DAY)),
           `returned_at` = IF(status = 0, (SELECT NOW() - INTERVAL FLOOR(RAND() * 1000) DAY), NULL);
END$$
CREATE PROCEDURE generateData(volume INTEGER)
BEGIN
    CALL generateClients(volume * 100);
    CALL generateAuthors(volume);
    CALL generateCompositions(volume * 4);
    CALL generatePublishers(ROUND(volume / 30));
    CALL generateBooks(volume * 12);
    CALL generateTickets(volume * 500);
END$$
DELIMITER ;

CALL generateData(10);

SHOW PROCEDURE STATUS;

DROP PROCEDURE generateAuthors;
DROP PROCEDURE generateCompositions;
DROP PROCEDURE generatePublishers;
DROP PROCEDURE generateBooks;
DROP PROCEDURE generateClients;
DROP PROCEDURE generateTickets;
DROP PROCEDURE generateData;
