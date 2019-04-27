CREATE TABLE IF NOT EXISTS `cinemaHall` (
    `id` int(11) NOT NULL auto_increment,
    `idHall` int(11) NOT NULL DEFAULT 0,
    `cinemaName` varchar(254) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
);

insert into `cinemaHall` values (1, 0, 'Illuzion');
insert into `cinemaHall` values (2, 1, 'Illuzion_room_1');
insert into `cinemaHall` values (3, 1, 'Illuzion_room_2');

CREATE TABLE IF NOT EXISTS `cinemaSeance` (
    `id` int(11) NOT NULL auto_increment,
    `idCinemaHall` int(11) NOT NULL DEFAULT 0,
    `seanceName` varchar(254) NOT NULL DEFAULT '',
    `seansePrice` DECIMAL(11,2) NOT NULL DEFAULT '0.0',
    FOREIGN KEY (`idCinemaHall`) REFERENCES `cinemaHall`(`id`),
    PRIMARY KEY (`id`)
);

insert into `cinemaSeance` values (1, 2, 'Game of Thrones', '900');
insert into `cinemaSeance` values (2, 3, 'Axcel', '700');

CREATE TABLE IF NOT EXISTS `cinemaSoldTikets` (
    `id` int(11) NOT NULL auto_increment,
    `idSeance` int(11) NOT NULL DEFAULT 0,
    `soldPrice` DECIMAL(11,2) NOT NULL DEFAULT '0.0',
    FOREIGN KEY (`idSeance`) REFERENCES `cinemaSeance`(`id`),
    PRIMARY KEY (`id`)
);
                    
insert into `cinemaSoldTikets` values (1, 1, '900');
insert into `cinemaSoldTikets` values (2, 1, '900');
insert into `cinemaSoldTikets` values (3, 1, '900');
insert into `cinemaSoldTikets` values (4, 1, '900');
insert into `cinemaSoldTikets` values (5, 2, '700');
insert into `cinemaSoldTikets` values (6, 2, '700');
insert into `cinemaSoldTikets` values (7, 2, '700');
insert into `cinemaSoldTikets` values (8, 2, '700');


select cinemaSeance.seanceName, sum(cinemaSoldTikets.soldPrice) as totalSold 
    from cinemaSoldTikets 
    left join cinemaSeance ON cinemaSeance.id = cinemaSoldTikets.idSeance 
    group by cinemaSoldTikets.soldPrice 
    order by totalSold 
    desc limit 0, 1;
    
    
