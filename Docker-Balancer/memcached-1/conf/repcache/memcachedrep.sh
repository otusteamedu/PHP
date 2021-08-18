#! /bin/sh
   ### BEGIN INIT INFO
   # Provides:             memcached
   # Required-Start:       $syslog
   # Required-Stop:        $syslog
   # Should-Start:         $local_fs
   # Should-Stop:          $local_fs
   # Default-Start:        2 3 4 5
   # Default-Stop:         0 1 6
   # Short-Description:    memcached - Memory caching daemon    replicated
   # Description:          memcached - Memory caching daemon  replicated
   ### END INIT INFO
   # Author: Marcus Spiegel <marcus.spiegel@gmail.com>

   PATH=/sbin:/usr/sbin:/bin:/usr/bin
   DESC="memcachedrep"
   NAME=memcached
   DAEMON=/usr/local/bin/$NAME
   DAEMON_ARGS="--options args"
   PIDFILE=/var/run/memcachedrep.pid
   SCRIPTNAME=/etc/init.d/$DESC
   VERBOSE="yes"
   # Exit if the package is not installed
   [ -x "$DAEMON" ] || exit 0
   # Read configuration variable file if it is present
   [ -r /etc/default/$DESC ] && . /etc/default/$DESC
   # Load the VERBOSE setting and other rcS variables
   . /lib/init/vars.sh
   # Define LSB log_* functions.
   # Depend on lsb-base (>= 3.0-6) to ensure that this file is   present.
   . /lib/lsb/init-functions
   #
   # Function that starts the daemon/service
   #
   do_start()
   {
	start-stop-daemon --start --quiet --pidfile $PIDFILE --exec $DAEMON --test > /dev/null \
		|| return 1
	start-stop-daemon --start --quiet --pidfile $PIDFILE --exec $DAEMON -- \
		$DAEMON_ARGS \
		|| return 2
   }
   #
   # Function that stops the daemon/service
   #
   do_stop()
   {
      start-stop-daemon --stop --quiet --retry=TERM/30/KILL/5 --pidfile $PIDFILE --name $NAME
      RETVAL="$?"
      [ "$RETVAL" = 2 ] && return 2
	start-stop-daemon --stop --quiet --oknodo --retry=0/30/KILL/5 --exec $DAEMON
	[ "$?" = 2 ] && return 2
	# Many daemons don't delete their pidfiles when they exit.
	rm -f $PIDFILE
	return "$RETVAL"
   }
   #
   # Function that sends a SIGHUP to the daemon/service
   #
   do_reload() {
	start-stop-daemon --stop --signal 1 --quiet --pidfile $PIDFILE --name $NAME
	return 0
   }
   case "$1" in
     start)
	[ "$VERBOSE" != no ] && log_daemon_msg "Starting $DESC" "$NAME"
	do_start
	case "$?" in
		0|1) [ "$VERBOSE" != no ] && log_end_msg 0 ;;
		2) [ "$VERBOSE" != no ] && log_end_msg 1 ;;
	esac
	;;
     stop)
	[ "$VERBOSE" != no ] && log_daemon_msg "Stopping $DESC" "$NAME"
	do_stop
	case "$?" in
		0|1) [ "$VERBOSE" != no ] && log_end_msg 0 ;;
		2) [ "$VERBOSE" != no ] && log_end_msg 1 ;;
	esac
	;;
     restart|force-reload)
	log_daemon_msg "Restarting $DESC" "$NAME"
	do_stop
	case "$?" in
	  0|1)
		do_start
		case "$?" in
			0) log_end_msg 0 ;;
			1) log_end_msg 1 ;; # Old process is still running
			*) log_end_msg 1 ;; # Failed to start
		esac
		;;
	  *)
	  	# Failed to stop
		log_end_msg 1
		;;
	esac
	;;
     *)
	#echo "Usage: $SCRIPTNAME {start|stop|restart|reload|force-reload}" >&2
	echo "Usage: $SCRIPTNAME {start|stop|restart|force-reload}" >&2
	exit 3
	;;
   esac
   exit 0