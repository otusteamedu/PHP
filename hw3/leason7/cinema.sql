-- зал

create table if not exists hall (
id int not null auto_increment,
name varchar(50) not null comment "Название зала",
primary key (id)
) engine InnoDB default character set utf8;

-- фильм
create table if not exists film (
id int not null auto_increment,
name varchar(100) not null comment "Название фильма",
primary key (id)
) engine InnoDB default character set utf8;

-- сеанс
create table if not exists seanse (
id int not null auto_increment,
hall int not null comment "Зал",
film int not null comment "Фильм",
start_show time not null comment "Начало сеанса",
primary key (id)
) engine InnoDB default character set utf8;

-- билет
create table if not exists ticket (
id int not null auto_increment,
seanse int not null comment "Сеанс",
row int not null comment "Ряд",
col int not null comment "Место",
coast numeric(6,2) comment "Цена",
primary key (id)
) engine InnoDB default character set utf8;
