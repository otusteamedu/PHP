FROM percona:5.7
RUN chown -R mysql:mysql /var/lib/mysql/
ADD my.cnf /etc/mysql/conf.d/my.cnf
CMD ["mysqld"]
WORKDIR /app
EXPOSE 3306
