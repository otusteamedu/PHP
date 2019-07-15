FROM postgres

RUN mkdir /home/indexes
RUN chown postgres:postgres /home/indexes

COPY ./sql /docker-entrypoint-initdb.d/
COPY ./scripts /home/scripts

RUN chmod +x /home/scripts/*.sh && mv -v /home/scripts/* /usr/local/bin
RUN chown -R postgres:postgres /docker-entrypoint-initdb.d/* && chmod -R 755 /docker-entrypoint-initdb.d/*

CMD ["postgres"]