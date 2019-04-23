CREATE USER read_only_username LOGIN PASSWORD 's3cr3tp@ssw0rd';

GRANT SELECT ON ALL TABLES IN SCHEMA public TO read_only_username;

ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT ON TABLES TO read_only_username;