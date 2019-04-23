
-- # su - postgres
-- db:~$ mkdir -p /var/lib/postgresql/data/tsFastIndex

CREATE TABLESPACE "tsFastIndex" LOCATION '/var/lib/postgresql/data/tsFastIndex';

ALTER INDEX ALL IN TABLESPACE pg_default SET TABLESPACE "tsFastIndex";

-- db:~$ ls -lsa /var/lib/postgresql/data/tsFastIndex/
-- total 12
--      4 drwx------    3 postgres postgres      4096 Apr 23 02:57 .
--      4 drwxrwxrwx    4 postgres postgres      4096 Apr 23 02:56 ..
--      4 drwx------    3 postgres postgres      4096 Apr 23 02:58 PG_9.6_201608131
