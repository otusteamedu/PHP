CREATE TABLE otus.rooms (
  id int(11) NOT NULL AUTO_INCREMENT,
  named varchar(50) NOT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

CREATE TABLE otus.sessions (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  price float NOT NULL,
  beginning datetime NOT NULL,
  room_id int(11) NOT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

CREATE TABLE otus.tickets (
  id int(11) NOT NULL AUTO_INCREMENT,
  session_id int(11) NOT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;