#!/bin/bash

#create admin account to memcached using SASL
if [ -z "$MEMCACHED_ANON" ]; then
	/create_memcached_admin_user.sh
else
    echo "Memcached running with no auth"
fi

memcached -u root \
    ${MEMCACHED_VERBOSE:--vvvv} \
    -P ${MEMCACHED_PID_FILE:-/var/run/memcachedrep.pid} \
    -p ${MEMCACHED_TCP_PORT:-11211} \
    -U ${MEMCACHED_UDP_PORT:-11211} \
    -m ${MEMCACHED_MEMORY:-64} \
    -c ${MEMCACHED_MAX_CONN:-1024} \
    -t ${MEMCACHED_THREADS:-4} \
    -x ${MEMCACHED_SLAVE_IP:-memcached-2}