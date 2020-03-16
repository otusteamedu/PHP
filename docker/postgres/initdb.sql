CREATE TABLE public.customers (id SERIAL PRIMARY KEY, name VARCHAR(512), address VARCHAR(512));
CREATE TABLE public.discounts (id SERIAL PRIMARY KEY, promocode VARCHAR(16), value INT);
CREATE TABLE public.products (id SERIAL PRIMARY KEY, title VARCHAR(256), sum DECIMAL);
CREATE TABLE public.orders (
    id SERIAL PRIMARY KEY,
    customer_id INT REFERENCES public.customers (id) NOT NULL,
    discount_id INT REFERENCES public.discounts (id),
    created_at TIMESTAMP,
    sum DECIMAL,
    status VARCHAR(32),
    type VARCHAR(32)
);
CREATE TABLE public.order_products(
    id SERIAL PRIMARY KEY,
    order_id INT REFERENCES public.orders (id) NOT NULL,
    product_id INT REFERENCES public.products (id) NOT NULL,
    sum DECIMAL
);
CREATE TABLE public.shipping_systems (id SERIAL PRIMARY KEY, title VARCHAR(256), sum DECIMAL);
CREATE TABLE public.shipments (
    id SERIAL PRIMARY KEY,
    shipping_system_id INT REFERENCES public.shipping_systems (id) NOT NULL,
    date TIMESTAMP,
    sum DECIMAL
);
CREATE TABLE public.order_product_shipments (
    order_product_id INT REFERENCES public.order_products (id),
    shipment_id INT REFERENCES public.shipments (id),
    PRIMARY KEY (order_product_id, shipment_id)
);

INSERT INTO public.customers (name, address) VALUES ('Кайл Брофловски', 'South Park 1');
INSERT INTO public.customers (name, address) VALUES ('Эрик Картман', 'South Park 2');
INSERT INTO public.customers (name, address) VALUES ('Кенни Маккормик', 'South Park 3');
INSERT INTO public.customers (name, address) VALUES ('Стэнли Марш', 'South Park 4');

INSERT INTO public.discounts (promocode, value) VALUES ('sale20', 20);
INSERT INTO public.discounts (promocode, value) VALUES ('sale50', 50);

INSERT INTO public.products (title, sum) VALUES ('Product1', 1000);
INSERT INTO public.products (title, sum) VALUES ('Product2', 2000);
INSERT INTO public.products (title, sum) VALUES ('Product3', 3000);
INSERT INTO public.products (title, sum) VALUES ('Product4', 0);

INSERT INTO public.shipping_systems (title, sum) VALUES ('Курьер', 500);
INSERT INTO public.shipping_systems (title, sum) VALUES ('Почта России', 200);
