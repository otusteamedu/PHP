create user timofey with superuser password 'timofey123';
create user readonly with password '123';
grant select on all tables in schema public to readonly;
grant select on all sequences in schema public to readonly;