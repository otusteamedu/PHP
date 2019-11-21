CREATE DATABASE hw;

CREATE TABLE IF NOT EXISTS products(
    id serial PRIMARY KEY,
    title VARCHAR (255) NOT NULL,
    description VARCHAR (255) NOT NULL,
    price INTEGER NOT NULL
);

insert into products VALUES(1, 'table', 'great for putting things', 3000);
insert into products VALUES(2, 'chair', 'great for sitting', 2000);
insert into products VALUES(3, 'spoon', 'great for eating soup', 100);
insert into products VALUES(4, 'fork', 'great for eating steak', 100);
insert into products VALUES(5, 'plate', 'great for putting food', 500);