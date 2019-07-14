-- Database initialization script

CREATE USER "user1" WITH PASSWORD '12345';
CREATE USER "user2" WITH PASSWORD '67890' SUPERUSER;

CREATE TABLESPACE "tsFastIndex" OWNER "user1" LOCATION '/var/lib/postgresql/fsindex';
CREATE DATABASE "cinema" OWNER "user1";
