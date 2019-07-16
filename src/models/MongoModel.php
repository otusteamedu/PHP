<?
namespace Paa\Models;

use Paa\App\MongoController;
use MongoDB;

class MongoModel extends MongoController
{

    protected $manager;
    
    public function __construct() 
    {
	global $config;
        $this->manager = parent::__construct();
        $this->dbName = $config['mongo']['dbName'];
        $this->youtubeChannelsTable = $config['youtube']['tableChannels'];
        $this->youtubeVideosTable = $config['youtube']['tableVideos'];
    }
    
    public function selectMongo(string $channelId = '')
    {
	$dbName = $this->dbName;
        $youtubeChannelsTable = $this->youtubeChannelsTable;
        $youtubeVideosTable = $this->youtubeVideosTable;

	try {
	    $manager = $this->manager;

	    $where = [  ]; 
	    $options = [ 'sort' => [ 'channelLikes' => -1, 'channelDislikes' => 1 ], 'limit' => 10 ];
	    
	    $query = new MongoDB\Driver\Query($where, $options);  

	    $rows = $manager->executeQuery( $dbName . '.' . $youtubeChannelsTable, $query);
        
    	} catch (MongoDB\Driver\Exception\Exception $e) {
    	    //echo "Exception:", $e->getMessage(), "\n";
    	    return false;
    	}

        return $rows;
    }
    
    public function insertMongoChannel(string $channelId = '', string $channelTitle = '', int $channelViews = 0, int $channelLikes = 0, int $channelDislikes = 0)
    {
	$dbName = $this->dbName;
        $youtubeChannelsTable = $this->youtubeChannelsTable;

	// Check for present indexes and create if need
	$collection = (new MongoDB\Client)->selectCollection($dbName, $youtubeChannelsTable);
	$indxPresent = 0;
	foreach ($collection->listIndexes() as $index) {
	    if ($index['name'] == 'channelId') $indxPresent = 1;
	}
	
	if ($indxPresent == 0) {
	    $collection->createIndex(['channelId' => 1], ['unique' => true]);
	    $collection->createIndex(['channelViews' => 1, 'channelLikes' => 1, 'channelDislikes' => 1]);
	}

	try {
	    $manager = $this->manager;
	    $bulk = new MongoDB\Driver\BulkWrite;
	    $doc = ['channelId' => $channelId, 'channelTitle' => $channelTitle, 'channelViews' => $channelViews, 'channelLikes' => $channelLikes, 'channelDislikes' => $channelDislikes ];
	    $bulk->insert($doc);
	    $manager->executeBulkWrite( $dbName . '.' . $youtubeChannelsTable, $bulk );

    	} catch (MongoDB\Driver\Exception\Exception $e) {
    	    //echo "Exception:", $e->getMessage(), "\n";
    	    // if dupe record
    	    return false;
    	}
    	
        return true;
    }

    public function insertMongoVideo(string $videoId = '', string $channelId = '', string $videoTitle = '', int $videoViews = 0, int $videoLikes = 0, int $videoDislikes = 0)
    {
	$dbName = $this->dbName;
        $youtubeVideosTable = $this->youtubeVideosTable;

	// Check for present indexes and create if need
	$collection = (new MongoDB\Client)->selectCollection($dbName, $youtubeVideosTable);
	$indxPresent = 0;
	foreach ($collection->listIndexes() as $index) {
	    if ($index['name'] == 'channelId') $indxPresent = 1;
	}
	
	if ($indxPresent == 0) {
	    $collection->createIndex(['videoId' => 1], ['unique' => true]);
	    $collection->createIndex(['videoLikes' => 1, 'videoDislikes' => 1]);
	}

	try {
	    $manager = $this->manager;
	    $bulk = new MongoDB\Driver\BulkWrite;
	    $doc = [ 'videoId' => $videoId, 'channelId' => $channelId, 'videoTitle' => $videoTitle, 'videoViews' => $videoViews, 'videoLikes' => $videoLikes, 'videoDislikes' => $videoDislikes ];
	    $bulk->insert($doc);
	    $manager->executeBulkWrite( $dbName . '.' . $youtubeVideosTable, $bulk );

    	} catch (MongoDB\Driver\Exception\Exception $e) {
    	    //echo "Exception:", $e->getMessage(), "\n";
    	    // if dupe record
    	    return false;
    	}
    	
        return true;
    }



    public function updateMongoChannel(string $channelId = '', string $channelTitle = '', int $channelViews = 0, int $channelLikes = 0, int $channelDislikes = 0)
    {
	$dbName = $this->dbName;
        $youtubeChannelsTable = $this->youtubeChannelsTable;

	try {
	    $manager = $this->manager;
	    $bulk = new MongoDB\Driver\BulkWrite;
	    $doc = ['channelTitle' => $channelTitle, 'channelViews' => $channelViews, 'channelLikes' => $channelLikes, 'channelDislikes' => $channelDislikes ];
    	    $where = ['channelId' => $channelId ];
	    $bulk->update($where, [ '$set' => $doc ]);
	    $manager->executeBulkWrite( $dbName . '.' . $youtubeChannelsTable, $bulk );
    	} catch (MongoDB\Driver\Exception\Exception $e) {
    	    //echo "Exception:", $e->getMessage(), "\n";
    	    return false;
    	}
    	return true;

    }

    public function updateMongoVideo(string $videoId = '', string $channelId = '', string $videoTitle = '', int $videoViews = 0, int $videoLikes = 0, int $videoDislikes = 0)
    {
	$dbName = $this->dbName;
        $youtubeVideosTable = $this->youtubeVideosTable;

	try {
	    $manager = $this->manager;
	    $bulk = new MongoDB\Driver\BulkWrite;
	    $doc = ['videoTitle' => $videoTitle, 'videoViews' => $videoViews, 'videoLikes' => $videoLikes, 'videoDislikes' => $videoDislikes ];
    	    $where = ['channelId' => $channelId, 'videoId' => $videoId ];
	    $bulk->update($where, [ '$set' => $doc ]);
	    $manager->executeBulkWrite( $dbName . '.' . $youtubeVideosTable, $bulk );
    	} catch (MongoDB\Driver\Exception\Exception $e) {
    	    //echo "Exception:", $e->getMessage(), "\n";
    	    return false;
    	}
    	return true;

    }

    public function deleteMongo(string $channelId = '')
    {
	$dbName = $this->dbName;
        $youtubeChannelsTable = $this->youtubeChannelsTable;
        $youtubeVideosTable = $this->youtubeVideosTable;

	try {
	    $youtubeTable = $this->youtubeTable;
	    $bulk = new MongoDB\Driver\BulkWrite;
	    $where = ['channelId' => $channelId ];
	    $bulk->delete($where);
    	    $manager->executeBulkWrite( $dbName . '.' . $youtubeChannelsTable, $bulk );
    	    $manager->executeBulkWrite( $dbName . '.' . $youtubeVideosTable, $bulk );
    	} catch (MongoDB\Driver\Exception\Exception $e) {
    	    //echo "Exception:", $e->getMessage(), "\n";
    	    return false;
    	}
        return true;
    }


}
