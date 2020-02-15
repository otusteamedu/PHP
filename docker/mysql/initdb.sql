CREATE DATABASE shop;
USE shop;
CREATE TABLE customers (id SERIAL PRIMARY KEY, name VARCHAR(512), address VARCHAR(512));
CREATE TABLE orders (id SERIAL PRIMARY KEY, created_at TIMESTAMP, sum DECIMAL, customer_id INT REFERENCES public.customers (id));
INSERT INTO customers (name, address) VALUES ('Kyle Broflovski', 'South Park 1');
INSERT INTO customers (name, address) VALUES ('Eric Cartman', 'South Park 2');
INSERT INTO customers (name, address) VALUES ('Kenny McCormick', 'South Park 3');
INSERT INTO customers (name, address) VALUES ('Stan Marsh', 'South Park 4');
