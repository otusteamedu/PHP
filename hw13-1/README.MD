# PostgreSQL

### Installing

* Restore DB dump from file `sql/dump_cinema.sql`
* Download PHP scripts to fill DB with test values from GIT branch `TimGa/hw13-1`
* Run `composer install`
* Configure DB connection in file `src/db.ini`
* Run script `php index.php NUM_OF_MOVIES` to fill DB with test values, where NUM_OF_MOVIES - number of movies to load into DB

### SQL files

* Three easy SQLs:
    * `sql/1 films begginig with.txt` - easy SQL#1 optimization example
    * `sql/2 closest scheduled films.txt` - easy SQL#2 optimization example
    * `sql/3 not sold tickets.txt` - easy SQL#3 optimization example
    * `sql/SQL_responses.rar` - SQL queries outputs
* Three complicated SQLs:
    * `sql/4 best profit.txt` - complicated SQL#1 optimization example
    * `sql/5 available seats for tooday.txt` - complicated SQL#2 optimization example
    * `sql/6 schedule for tooday.txt` - complicated SQL#3 optimization example
    * `sql/SQL_responses.rar` - SQL queries outputs
* DB Dump:
    * `sql/dump_cinema.sql` - dump to restore Cinema DB
* Indexes and Size analysis:
    * `sql/index_use_good.txt` - most used indexes 
    * `sql/index_use_bad.txt` - less used indexes
    * `sql/top_objects_size.txt` - top size DB objects