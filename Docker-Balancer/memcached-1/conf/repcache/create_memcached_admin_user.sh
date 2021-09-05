#!/bin/bash

USER=${MEMCACHED_USER:-admin}
PASS=${MEMCACHED_PASS:-password}
#generate pasword
_word=$( [ ${MEMCACHED_PASS} ] && echo "preset" || echo "random" )

if [ -f /.memcached_admin_created ]; then
    echo "Memcached '${USER}' user already created!"
    exit 0
fi


echo "=> Creating an admin user with a ${_word} password in Memcached"
echo mech_list: plain > /usr/lib/sasl2/memcached.conf
echo $PASS | saslpasswd2 -a memcached -c ${USER} -p
echo "=> Done"
touch /.memcached_admin_created

echo "========================================================================"
echo "You can now connect to this Memcached server using:"
echo ""
echo "    USERNAME:$USER      PASSWORD:$PASS"
echo ""
echo "Please remember to change the above password as soon as possible!"
echo "========================================================================"