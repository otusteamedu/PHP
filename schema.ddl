drop table if exists products_orders_rel;
drop table if exists delivery_services_orders_rel;
drop table if exists discounts_orders_rel;
drop table if exists orders;
drop table if exists products;
drop table if exists clients;
drop table if exists delivery_services;
drop table if exists discounts;

create table if not exists delivery_services
(
    id    int primary key auto_increment,
    name  varchar(255)  default '',
    price decimal(7, 2) default 0.0
) character set utf8
  collate utf8_unicode_ci
  engine = innodb;

insert into delivery_services (id, name, price)
values (1, 'Отправкин', 100),
       (2, 'Доставкин', 200),
       (3, 'Потеряшкин', 300);

create table if not exists discounts
(
    id       int primary key auto_increment,
    label    varchar(255)        default '',
    val      decimal(7, 2)       default 0.0,
    percents tinyint(2) unsigned default 0
) character set utf8
  collate utf8_unicode_ci
  engine = innodb;
insert into discounts (id, label, val, percents)
values (1, 'Сезонная скидка', 0, 50),
       (2, 'Промо код 1000', 1000.00, 0);

create table if not exists clients
(
    id       int primary key auto_increment,
    type     enum ('b2b', 'b2c') default 'b2c',
    name     varchar(255)        default '',
    address  text                default '',
    inn      varchar(15),
    passport varchar(15)
) character set utf8
  collate utf8_unicode_ci
  engine = innodb;
insert into clients (id, type, name, address, inn, passport)
values (1, 'b2b', 'ООО \"Рога и копыта\"',
        'г. Козьмодемьянск, ул. Петрова, д. 1', '5900000000001', null),
       (2, 'b2b', 'ООО \"Копыта и рога\"',
        'г. Чебоксары, ул. Сидорова, д. 12', '5900000000001', null),
       (3, 'b2c', 'Груня Колыванова',
        'г. Тудысюдыев, ул. Коекакова, д. 13, п-д 2, спросить тётю Груню', null,
        '1357 484518'),
       (4, 'b2c', 'Кощей Бессмертный',
        'г. Дремучий, ул. Топкая, д. 1313', null, '7898 460809');


create table if not exists products
(
    id     int primary key auto_increment,
    title  varchar(255)  default ''  not null,
    price  decimal(7, 2) default 0.0 not null,
    weight float         default 0.0
) character set utf8
  collate utf8_unicode_ci
  engine = innodb;
insert into products (id, title, price, weight)
values (1, 'Товар 1', 200.00, 0.200),
       (2, 'Товар 2', 50.00, 0.500),
       (3, 'Товар 3', 1320.00, 0.100),
       (4, 'Товар 4', 90.50, 0.150),
       (5, 'Товар 5', 300.00, 0.250),
       (6, 'Товар 6', 100.00, 1.300),
       (7, 'Товар 7', 100.00, 0.200),
       (8, 'Товар 8', 150.00, 0.150),
       (9, 'Товар 9', 5200.00, 5.450),
       (10, 'Товар 10', 400.00, 2.000),
       (11, 'Товар 11', 4699.00, 6.730),
       (12, 'Товар 12', 300.00, 0.520);


create table if not exists orders
(
    id           int primary key auto_increment,
    client_id    int not null default 0,
    state        int not null default 0,
    date_created datetime     default current_timestamp
) character set utf8
  collate utf8_unicode_ci
  engine = innodb;
insert into orders (id, client_id, state, date_created)
values (1, 1, 0, current_timestamp()),
       (2, 1, 1, current_timestamp()),
       (3, 2, 2, current_timestamp()),
       (4, 3, 0, current_timestamp()),
       (5, 3, 0, current_timestamp()),
       (6, 4, 1, current_timestamp()),
       (7, 4, 0, current_timestamp()),
       (8, 1, 1, current_timestamp()),
       (9, 2, 0, current_timestamp()),
       (10, 4, 2, current_timestamp());

alter table orders
    add constraint orders_clients_id_fk foreign key (client_id) references clients (id) on update cascade on delete cascade;

# По хорошему должна быть возможность добавлять несколько одинаковых товаров:
#  добавить поле product_count
create table if not exists products_orders_rel
(
    order_id   int,
    product_id int
) character set utf8
  collate utf8_unicode_ci
  engine = innodb;
create unique index order_product_uidx on products_orders_rel (order_id, product_id);

alter table products_orders_rel
    add constraint products_orders_rel_orders_id_fk foreign key (order_id) references orders (id) on update cascade;
alter table products_orders_rel
    add constraint products_orders_rel_products_id_fk foreign key (product_id) references products (id) on update cascade on delete set null;

create table if not exists discounts_orders_rel
(
    order_id    int,
    discount_id int
) character set utf8
  collate utf8_unicode_ci
  engine = innodb;
create unique index order_discount_uidx on discounts_orders_rel (order_id, discount_id);
alter table discounts_orders_rel
    add constraint discounts_orders_rel_discounts_id_fk foreign key (discount_id) references discounts (id) on update cascade;
alter table discounts_orders_rel
    add constraint discounts_orders_rel_orders_id_fk foreign key (order_id) references orders (id) on update cascade on delete cascade;

create table if not exists delivery_services_orders_rel
(
    order_id    int,
    delivery_id int
) character set utf8
  collate utf8_unicode_ci
  engine = innodb;
create unique index order_delivery_service_uidx on delivery_services_orders_rel (order_id, delivery_id);
alter table delivery_services_orders_rel
    add constraint delivery_services_orders_rel_delivery_services_id_fk foreign key (delivery_id) references delivery_services (id) on update cascade;

alter table delivery_services_orders_rel
    add constraint delivery_services_orders_rel_orders_id_fk foreign key (order_id) references orders (id) on update cascade on delete cascade;