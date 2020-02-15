CREATE TABLE public.customers (id SERIAL PRIMARY KEY, name VARCHAR(512), address VARCHAR(512));
CREATE TABLE public.orders (id SERIAL PRIMARY KEY, created_at TIMESTAMP, sum DECIMAL, customer_id INT REFERENCES public.customers (id));
INSERT INTO public.customers (name, address) VALUES ('Кайл Брофловски', 'South Park 1');
INSERT INTO public.customers (name, address) VALUES ('Эрик Картман', 'South Park 2');
INSERT INTO public.customers (name, address) VALUES ('Кенни Маккормик', 'South Park 3');
INSERT INTO public.customers (name, address) VALUES ('Стэнли Марш', 'South Park 4');
