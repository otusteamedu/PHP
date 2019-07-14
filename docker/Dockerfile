FROM postgres:11-alpine

ENV LANG=C.UTF-8

COPY *.sql *.sh pgpass /var/lib/postgresql/

RUN mv /var/lib/postgresql/pgpass /root/.pgpass \
    && chmod u=rw,go= /root/.pgpass \
    && mkdir --parents /var/lib/postgresql/fsindex \
    && chown -R postgres /var/lib/postgresql \
    && chmod +x /var/lib/postgresql/*.sh
