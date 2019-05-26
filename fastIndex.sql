-- sudo -u postgres mkdir /Library/PostgreSQL/11/data/tsFastIndex
CREATE TABLESPACE "tsFastIndex" LOCATION '/Library/PostgreSQL/11/data/tsFastIndex';
ALTER INDEX ALL IN TABLESPACE pg_default SET TABLESPACE "tsFastIndex";
