Запуск: 
```bash
  docker-compose up
```

Для управления количеством серверов(nginx + php):
1. Изменить количество серверов в docker/balancer/balancer.conf
2. Добавить конфигурационный файл ushakovN.conf
3. Добавить php_N и nginx_server_Т
4. В переменную SERVER_INDEX у php_N указать номер сервера
