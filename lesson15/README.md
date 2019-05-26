# Lesson 15
###Prepare

`$ composer install` and edit config.ini if it need.

For using config.ini define "APP_DIR" before using Otus\Client

If you haven't Redis server you can use docker image. Start it by this command:

`$ docker run -it -p 6379:6379 --name some-redis -d redis` 

####Examples

    <?php
        $manager = new EventManager();
		//add eventItem in redis
		$manager->addEventToList($eventItem);
		
		//get n EventItems in $events
		$events = $manager->getAllEventsByConditions(['color' => 'black']);
		
		//get 1 EventItems in $event
		$event = $manager->getEventByConditions(['color' => 'black']);
		
		//clear all EventItems and their conditions from redis
		$manager->clearData(); 
    ?>
    
See more in examles folder =)