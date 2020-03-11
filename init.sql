DROP TABLE IF EXISTS "products" CASCADE;
CREATE TABLE "products" (
    id serial UNIQUE,
    name varchar(255) NOT NULL,
    description varchar,
    category_id int,
    CONSTRAINT products_pk PRIMARY KEY (id)
);

INSERT INTO "products" (name, description, category_id) VALUES ('Apple iPhone XR, 64GB, White', 'Renewed products work and look like new. These pre-owned products are not Apple certified but have been inspected and tested by Amazon-qualified suppliers. Box and accessories (no headphones included) may be generic. Wireless devices come with the 90-day Amazon Renewed Guarantee.', 12);
INSERT INTO "products" (name, description, category_id) VALUES ('Apple Watch Series 5 GPS + Cellular', 'Pre-owned products are not Apple certified but have been inspected and tested by Amazon-qualified suppliers.', 5);
INSERT INTO "products" (name, description, category_id) VALUES ('Apple Watch Series 5 GPS + Cellular', 'Pre-owned products are not Apple certified but have been inspected and tested by Amazon-qualified suppliers.', 5);
INSERT INTO "products" (name, description, category_id) VALUES ('Apple iPhone 8 Plus, 256GB, Red', 'These pre-owned products are not Apple certified but have been inspected and tested by Amazon-qualified suppliers. Box and accessories (no headphones included) may be generic.', 12);
INSERT INTO "products" (name, description, category_id) VALUES ('Samsung Galaxy Note 9 N960U 128GB Verizon', '', 12);
INSERT INTO "products" (name, description, category_id) VALUES ('Nokia Lumia 900 16GB Windows Smartphone', '', 12);
