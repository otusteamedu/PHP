drop index if exists "sessionDate";
drop index if exists "ticketsSession";
drop index if exists "userEmail";

-- 1. Добавить индекс к полю даты таблицы tSessions
create index "sessionDate" on "tSessions" using btree ("date");

-- 2. Добавить индекс к полю session_id таблицы tTickets:
create index "ticketsSession" on "tTickets" using btree ("session_id");

-- 3. Добавить функциональный индекс к tUsers, для поиска по домену
create index "userEmail" on "tUsers" using btree ("email") where "email" like '%ru';
