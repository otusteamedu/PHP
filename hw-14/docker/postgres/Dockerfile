FROM postgres:10.14

RUN apt-get update

COPY docker-entrypoint-initdb.d/00_create-otus-db.sh /docker-entrypoint-initdb.d/
COPY docker-entrypoint-initdb.d/01_migrations.sh /docker-entrypoint-initdb.d/
COPY docker-entrypoint-initdb.d/02_seeds.sh /docker-entrypoint-initdb.d/

RUN chmod +x  /docker-entrypoint-initdb.d/00_create-otus-db.sh
RUN chmod +x  /docker-entrypoint-initdb.d/01_migrations.sh
RUN chmod +x  /docker-entrypoint-initdb.d/02_seeds.sh

EXPOSE 5433

