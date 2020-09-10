FROM percona:8

RUN chown -R mysql:mysql /var/lib/mysql/

ADD ./conf/my.cnf /etc/mysql/conf.d/my.cnf

CMD ["mysqld"]

EXPOSE 3306
