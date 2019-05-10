# Homework 13
### How to use:
#### 1 - run composer
`$ composer install`
#### 2 - run createDB.php
`$ ./cdreateDB.php`

Options:
- --host' - host(default: localhost)
- --port' - port(default: 5432)
- --user' - user(default: postgres)
- --password' - password(default: adminPassword)
- --database' - database(default: test_db)
- --schema' - schema(default: test_db)
- -h || --help' - this message.

#### 2 - run insertData.php
`$ ./insertData.php --type [b or s]`

Options:
- --type' - type of inserting data ("s" - for small data(~10000 rows), "b" - for big data(~10000000 rows))
- --host' - host(default: localhost)
- --port' - port(default: 5432)
- --user' - user(default: postgres)
- --password' - password(default: adminPassword)
- --database' - database(default: test_db)
- --schema' - schema(default: test_db)
- -h || --help' - this message.

#### 3 - look example queries and plans in queries.sql