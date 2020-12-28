FROM postgres:10.14

RUN apt-get update

COPY docker-entrypoint-initdb.d/create-docker-db.sh /docker-entrypoint-initdb.d/
RUN chmod +x  /docker-entrypoint-initdb.d/create-docker-db.sh

EXPOSE 5433

