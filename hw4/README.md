## Чат на UNIX сокетах  

Запуск сервера:  
```
$ php socket_server.php 
Wait connection...
```

Запуск интерактивного клиента:  
```
$ php socket_client.php
Connected to server!
```

После запуска в консоли сервера появится сообщение:  
```
Client connected!
```

С этого момента можно обмениваться сообщениями в интерактивном режиме в обоих терминалах.  

Пример такого общения:  
(Символом `>` отмечено входящее сообщение)
```
# Со стороны клиента:
$ php socket_client.php 
Connected to server!
Hi, server!
> Hi, client!

# Со стороны сервера:
$ php socket_server.php 
Wait connection...
Client connected!
> Hi, server!
Hi, client!
```
