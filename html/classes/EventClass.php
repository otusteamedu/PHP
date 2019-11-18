<?php

class EventClass
{
	private $redis;
	private $params;
	private $name;
	private $priority = 0;
	private const KEYPRIORITY = 'Priorities';
	private const PREEVENT = 'evn:';

	public function __construct(array $conditions = [])
	{
		$this->redis = new Redis();
		$this->redis->connect("redis");

		if (isset($conditions["name"]) && $conditions["name"] !== self::KEYPRIORITY) {
			$this->name = self::PREEVENT . $conditions["name"];
			unset($conditions["name"]);
		}

		if (isset($conditions["priority"])) {
			$this->priority = $conditions["priority"];
			unset($conditions["priority"]);
		}

		if (!empty($conditions)) {
			$this->params = $conditions;
		}
	}

	public function addEvent()
	{
		if (!$this->name || empty($this->params)) {
			return false;
		}
		$this->redis->multi()
			->zAdd(self::KEYPRIORITY, $this->priority, $this->name)
			->hMSet($this->name, $this->params)
			->exec();

		return true;
	}

	public function checkEvent()
	{
		$allKeys = $this->redis->keys(self::PREEVENT . '*');
		$maxRank = null;
		$relEvent = "¯\_(ツ)_/¯";
		foreach ($allKeys AS $key) {
			$arrEvent = $this->redis->hGetAll($key);
			if ($arrEvent == array_intersect_assoc($arrEvent, $this->params)) {
				$rank = $this->redis->zRank(self::KEYPRIORITY, $key);
				if ($rank >= $maxRank) {
					$maxRank = $rank;
					$relEvent = $key;
				}

			}
		}

		return preg_replace('/^' . preg_quote(self::PREEVENT, '/') . '/', '', $relEvent);
	}

	public function flushall()
	{
		return $this->redis->flushAll();
	}
}