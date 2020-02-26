### Server run:

`php index.php -r server`

### Client run:

`php index.php -r client -m ping`

### Server output

```
Ready to receive...
Received ping from /var/www/html/test.local/src//client.sock
Request processed
Ready to receive...
```

### Client output

```
Server (/var/www/html/test.local/src//server.sock) answered: "pong"
Client exits
```