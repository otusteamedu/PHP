# Docker environment

Contains following services: MySQL database engine, Redis server, php-fpm CGI server, nginx web-server.
Each service has dedicated directory for its conf and data files.

## Usage

```bash
docker-compose up -d
```

# Company description

Our company is successful startup which develops and supports software product for optimize vehicle routes to decrease net spending.
Company has around 50 specialists in different areas of computer science. Most our specialists work remotely.

__Technology stack we use includes next ones:__
- MySQL
- Amazon DynamoDB
- Google Datastore
- Google BigQuery
- Elasticsearch

All our infrastructure deployed in clouds with using couple dozen Kubernetes clusters.

On the initialization stage our Earners made decision that it would be optimal for different level of load.

Such a structure allow us to have minimum spending to maintain our testing, staging and production environment without significant overhead