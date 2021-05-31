**Deploying instructions:**

1. Run docker-compose up -d --build
2. docker exec -it php-fpm bash
3. Run php bin/console consumer:reports to run consumer.

Go to /reports/bank-statement/index enter date and hit Submit. This message
containing entered dates would appear in console where consumer was launched.