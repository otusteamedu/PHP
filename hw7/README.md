**Email Checker App**

App works via HTTP protocol and returns results as JSON.

Required params for HTTP request:
* action
* email

Avaliable actions in the "action" param:
* check - checks if email is valid and has MX records
* is_valid - only checks if email is valid
* has_mx - only checks if email has MX records

Request examples:
```
http://localhost/?action=check&email=test@test
http://localhost/?action=is_valid&email=test@test
http://localhost/?action=has_mx&email=test@test
```

***How to run the App:***
```
docker-compose up -d
cd app
composer install
```

*Notice:* composer has to be installed on your host machine