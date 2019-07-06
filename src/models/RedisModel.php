<?
namespace Paa\Models;

use Paa\App\RedisController;

class RedisModel extends RedisController
{

    protected $redis;
    
    public function __construct() 
    {
        $this->redis = parent::__construct();
    }
    
    
    public function setEvent($priority = 0, $params = [])
    {
	$redis = $this->redis;

	$i = 1;
	foreach($params as $indx => $val) {
	    $comma = ($i > 1) ? ', ' : '';
	    $paramsJson .= $comma . '"' . $indx . '": "' . $val . '"';
	    $i++;
	}

	// Get max key id + 1
	$id = $this->getMaxId($redis->keys("*")) + 1;

	$val = '{ "priority": "' . $priority . '", "conditions": {' . $paramsJson . '} , "event": "::event::" } ';
        $redis->set($id, $val);

	// Check set values
        $getRedis = $redis->get($id);
        return $getRedis;

    }

    public function delEvents()
    {
	$redis = $this->redis;

	$allKeys = $redis->keys("*");

	foreach ($allKeys as $val) {
	    $redis->del($val);
        }
    }

    public function getEvents() : array
    {
	$redis = $this->redis;

	$allKeys = $redis->keys("*");

	$eventsList = [];
	foreach ($allKeys as $val) {
	    $eventsList[] = $redis->get($val);
        }
        return $eventsList;
    }

    private function getMaxId($idArray = []) : int
    {
	$maxId = 0;
	foreach ($idArray as $key => $val) {
	    if ($val > $maxId) $maxId = $val;
        }
	return $maxId;
    }

}
