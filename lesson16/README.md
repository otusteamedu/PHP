# YouTube Mongo Grabber

###Prepare
Clone or dowload project, then install requirements

`$ composer install`

Fill APP_DIR/config.ini by your youtube accessToken. 
You can take it at https://developers.google.com/youtube/v3/quickstart/php
If you haven't Mongo you can get it by docker

`$ docker run --name some-mongo -p 27017:27017 -d mongo`


###Usage

    <?php
        // define APP_DIR location
		// APP_DIR . '/config.ini keep your youtube token and base api url
		define('APP_DIR', __DIR__ . '/..' );
		require APP_DIR . '/vendor/autoload.php';

		use Otus\{Grabber, Informer, BaseRecord};

		// Configure connection to MongoDB
		BaseRecord::$connection = new MongoDB\Client();
		BaseRecord::$database = 'myapp';
		
		try {
			$grabber = new Grabber();
			echo 'Grab channel' . PHP_EOL;
			$grabber->grabChannel('SOME_CHANNEL_ID');
			echo 'Rate channels by likes/dislikes' . PHP_EOL;
			$rate = Informer::getTopChannelsByValue(2);
			foreach ($rate as $channel) {
				echo '_id: ' . $channel->getID() . ', ' . $channel->getTitle() . ', rate: ' . $channel->getRates() . PHP_EOL;
    	 } catch (\Exception $e) {
 			   echo $e->getMessage() . PHP_EOL;
		}
    ?>
    
Also you can add channels and videos manual

 	<?php
 		// define APP_DIR location
		// APP_DIR . '/config.ini keep your youtube token and base api url
		define('APP_DIR', __DIR__ . '/..' );
		require APP_DIR . '/vendor/autoload.php';

		use Otus\{Channel, BaseRecord};

		// Configure connection to MongoDB
		BaseRecord::$connection = new MongoDB\Client();
		BaseRecord::$database = 'myapp';
		$channel = new Channel();
		$channel->setTitle('some title');
		//you can add to object custom fields but before saving, they will be destroyed
		$channel->setSomeStrangeField('strange field value');
		$channel->save();
		//also you can create new object with params like this
		$channel = new Channel(['title'=>'some_title']);
	 ?>

More examples in Example dir.
