FROM postgres

COPY ./sql /docker-entrypoint-initdb.d/
COPY ./scripts /home/scripts

RUN mkdir /home/indexes && \
    chown postgres:postgres /home/indexes && \
    chmod +x /home/scripts/*.sh && \
    mv -v /home/scripts/* /usr/local/bin && \
    chown -R postgres:postgres /docker-entrypoint-initdb.d/* && \
    chmod -R 755 /docker-entrypoint-initdb.d/*

CMD ["postgres"]