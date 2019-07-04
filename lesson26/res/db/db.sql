CREATE DATABASE test_db;
\connect test_db;
CREATE SCHEMA cinema;
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
CREATE TABLE cinema.message (
	id varchar NOT NULL DEFAULT uuid_generate_v1(),
	message text NOT NULL,
	deleted int NULL DEFAULT 0,
	status int NULL DEFAULT 0,
	"type" int NULL DEFAULT 0
);
CREATE UNIQUE INDEX message_id_idx ON cinema.message (id);