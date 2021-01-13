/*create database cinema_eav;*/

CREATE TABLE cinema (
	id smallint NOT NULL AUTO_INCREMENT,
    cinema_name varchar(255),
    total_placement smallint,
    PRIMARY KEY (id)
) ;

 CREATE TABLE cinema_hall (
	id smallint NOT NULL AUTO_INCREMENT,
	hall_name varchar(255),
	placement smallint,
    cinema_id smallint ,
    PRIMARY KEY (id),
    FOREIGN KEY (cinema_id) REFERENCES cinema(id) ON DELETE cascade ON 
UPDATE cascade
    
);

CREATE TABLE movie (
	id integer NOT NULL AUTO_INCREMENT,
    title varchar(255),
    description varchar(255),
	PRIMARY KEY (id)
);


CREATE TABLE movie_attr_type (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    name varchar(255) ,
    comment text 
);


CREATE TABLE movie_attr (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    name varchar(255),
    movie_attr_type_id integer NOT NULL
);



CREATE TABLE movie_attr_values (
    id integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
    attr_id integer NOT NULL,
    val_date date,
    val_text varchar(255),
    val_num numeric(2,0),
    movie_id integer NOT NULL
);

CREATE TABLE session_type (
	id integer NOT NULL AUTO_INCREMENT ,
	type_name varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE movie_session (
	id integer NOT NULL AUTO_INCREMENT,
	time_start datetime,
    time_end datetime,
	movie_id integer,
    hall_id smallint ,
    session_type_id integer,
    FOREIGN KEY (session_type_id) REFERENCES session_type(id) ON DELETE 
cascade ON UPDATE cascade,
    PRIMARY KEY (id)
);

CREATE TABLE seat_type (
	id integer NOT NULL AUTO_INCREMENT,
	type_name varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE price_rule (
	id integer NOT NULL AUTO_INCREMENT,
	session_id integer,
    seat_type_id integer,
    price integer,
	FOREIGN KEY (session_id) REFERENCES movie_session(id) ON DELETE 
cascade ON UPDATE cascade,
    FOREIGN KEY (seat_type_id) REFERENCES seat_type(id) ON DELETE 
cascade ON UPDATE cascade,
	PRIMARY KEY (id)
);

CREATE TABLE seat (
	id integer NOT NULL AUTO_INCREMENT,
	hall_id smallint,
    seat_type_id integer,
    FOREIGN KEY (seat_type_id) REFERENCES seat_type(id) ON DELETE 
cascade ON UPDATE cascade,
    PRIMARY KEY (id)
);


CREATE TABLE ticket (
	id integer NOT NULL AUTO_INCREMENT,
    price_rule_id integer,
    seat_id integer,
    FOREIGN KEY (price_rule_id) REFERENCES price_rule(id),
	PRIMARY KEY (id)
);



insert into cinema(cinema_name,total_placement) values 
('the_only_cinema_in_town',400);

insert into cinema_hall(hall_name,placement,cinema_id) values 
('blue',100,1);
insert into cinema_hall(hall_name,placement,cinema_id) values 
('red',100,1);
insert into cinema_hall(hall_name,placement,cinema_id) values 
('yellow',200,1);

insert into movie(title,description) 
values ('hobbit1','the good one');
insert into movie(title,description) 
values ('hobbit2','not the good one');
insert into movie(title,description) 
values ('hobbit3','the bad one');
insert into movie(title,description) 
values ('matrix1','the good one');
insert into movie(title,description) 
values ('matrix2','not the good one');
insert into movie(title,description) 
values ('matrix3','the bad one');

insert into session_type(type_name) values ('day');
insert into session_type(type_name) values ('night');

insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2011-10-10 21:00:00','2011-10-10 23:00:00',1,1,1);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2011-01-10 11:00:00','2011-10-10 13:00:00',1,3,2);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2015-10-09 11:00:00','2015-10-00 13:00:00',2,1,1);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2016-10-10 21:00:00','2016-10-10 23:00:00',2,1,2);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2015-10-10 21:00:00','2015-10-10 23:00:00',3,1,1);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2016-02-10 21:00:00','2016-02-10 23:00:00',4,1,1);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2017-10-10 11:00:00','2017-10-10 13:00:00',5,1,1);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2017-10-10 21:00:00','2017-10-10 23:00:00',5,2,1);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2017-10-10 21:00:00','2017-10-10 23:00:00',5,3,1);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2018-10-10 21:00:00','2018-10-10 23:00:00',6,1,1);
insert into 
movie_session(time_start,time_end,movie_id,hall_id,session_type_id) 
values ('2018-10-10 21:00:00','2018-10-10 23:00:00',6,1,2);

insert into seat_type(type_name) values ('normal');
insert into seat_type(type_name) values ('luxury');


insert into price_rule(seat_type_id,session_id,price) values 
('1','1',100);
insert into price_rule(seat_type_id,session_id,price) values 
('1','2',200);
insert into price_rule(seat_type_id,session_id,price) values 
('1','3',120);
insert into price_rule(seat_type_id,session_id,price) values 
('1','4',100);
insert into price_rule(seat_type_id,session_id,price) values 
('1','5',150);
insert into price_rule(seat_type_id,session_id,price) values 
('1','6',220);
insert into price_rule(seat_type_id,session_id,price) values 
('1','7',250);
insert into price_rule(seat_type_id,session_id,price) values 
('1','8',260);
insert into price_rule(seat_type_id,session_id,price) values 
('1','9',290);
insert into price_rule(seat_type_id,session_id,price) values 
('1','10',100);
insert into price_rule(seat_type_id,session_id,price) values 
('1','11',90);


USE `cinema_eav`;
DROP procedure IF EXISTS `set_seats`;

DELIMITER $$
USE `cinema_eav`$$
CREATE PROCEDURE `set_seats` ()
BEGIN
DECLARE income INT ;
	SET income = 0;
	label1: WHILE income < 100 DO
		SET income = income + 1;
        insert into seat(hall_id,seat_type_id) values ('1',FLOOR( 1 + 
RAND( ) * 2 ));
	END WHILE label1;
    SET income = 0;
	label2: WHILE income < 100 DO
		SET income = income + 1;
        insert into seat(hall_id,seat_type_id) values ('2',FLOOR( 1 + 
RAND( ) * 2 ));
	END WHILE label2;
    SET income = 0;
	label3: WHILE income < 200 DO
		SET income = income + 1;
        insert into seat(hall_id,seat_type_id) values ('3',FLOOR( 1 + 
RAND( ) * 2 ));
	END WHILE label3;
END$$

DELIMITER ;
call set_seats();



insert into ticket(price_rule_id,seat_id) values ('1',2);
insert into ticket(price_rule_id,seat_id)  values ('2',3);
insert into ticket(price_rule_id,seat_id)  values ('3',8);
insert into ticket(price_rule_id,seat_id)  values ('4',330);
insert into ticket(price_rule_id,seat_id)  values ('5',150);
insert into ticket(price_rule_id,seat_id)  values ('6',220);
insert into ticket(price_rule_id,seat_id)  values ('7',250);
insert into ticket(price_rule_id,seat_id)  values ('8',260);
insert into ticket(price_rule_id,seat_id)  values ('9',290);
insert into ticket(price_rule_id,seat_id)  values ('10',100);
insert into ticket(price_rule_id,seat_id)  values ('11',90);

select SUM(price_rule.price),  movie_session.movie_id  
from ticket 
left join price_rule on ticket.price_rule_id = price_rule.id
left join movie_session on price_rule.session_id = movie_session.id 
group by movie_session.movie_id order by SUM(price_rule.price) desc 
limit 1;

/*DROP database cinema_eav;*/
