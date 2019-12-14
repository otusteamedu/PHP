###Requirements:
* Docker CE

###Running:
* `docker-compose up -d`
* `cp .env.example .env`
* Put the client secret file from the Google Developers Console (YouTube Data API must be enabled) to var directory (default path: var/client_secret.json).
* Open http://localhost:8082 in a browser to authorize the client.


###How to fill the storage via Spider:
`docker-compose exec php-cli php spider.php`

###How to view statistics for the channel:
`docker-compose exec php-cli php statistics.php`
