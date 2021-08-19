FROM ubuntu:trusty
MAINTAINER Yolanda Robla <info@ysoft.biz>

#install repcached
RUN apt-get update && \
    apt-get install -y gcc make build-essential libevent-1.4-2 libevent-core-1.4-2 libevent1-dev libsasl2-2 sasl2-bin libsasl2-2 libsasl2-dev libsasl2-modules wget pwgen

RUN wget -v -O repcached.tar.gz http://downloads.sourceforge.net/project/repcached/repcached/2.2.1-1.2.8/memcached-1.2.8-repcached-2.2.1.tar.gz
RUN tar xzf repcached.tar.gz
RUN cd memcached-1.2.8-repcached-2.2.1 && ./configure --prefix=/usr/local/ --exec-prefix=/usr/local/ --enable-64bit --enable-replication && make && make install

ADD ./conf/repcache/create_memcached_admin_user.sh /create_memcached_admin_user.sh
ADD ./conf/repcache/run.sh /run.sh
RUN chmod 755 /*.sh

EXPOSE 11211

CMD ["/run.sh"]

