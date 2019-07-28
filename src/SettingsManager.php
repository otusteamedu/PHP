<?php

namespace AnrDaemon\CcWeb;

use AnrDaemon\CcWeb\Exceptions;
use AnrDaemon\CcWeb\Interfaces;

class SettingsManager
implements Interfaces\SettingsManager
{
  protected $config = [];

  protected $cache;
  protected $pdo;
  protected $reg;
  protected $tpl;
  protected $sec;

// Interfaces\SettingsManager

  public function getRouter()
  {
    return $this->reg['handler'];
  }

  public function getCacheManager()
  {
    return $this->cache['handler'];
  }

  public function getDatabaseManager()
  {
    return $this->pdo['handler'];
  }

  public function getSecurityManager()
  {
    return $this->sec['handler'];
  }

  public function getTemplateManager()
  {
    return $this->tpl['handler'];
  }

  // Options handling

  public function getOption(/*TODO:PHP7 string */$optName, /*TODO:PHP7 string */$optGroup = null)
  {
    return null;
  }

  // Setters

  protected function defineManager($key, $handler)
  {
    if(isset($this->$key))
      throw new \LogicException("Unable to redefine configuration", 0, $this->{$key}['defined']);

    $this->{$key}['handler'] = $handler;
    $this->{$key}['defined'] = new \LogicException("Already defined in");
  }

  public function setRouter(Interfaces\Router $reg)
  {
    $this->defineManager("reg", $reg);
  }

  public function setCacheManager(Interfaces\CacheManager $cache)
  {
    $this->defineManager("cache", $cache);
  }

  public function setDatabaseManager(Interfaces\DatabaseManager $pdo)
  {
    $this->defineManager("pdo", $pdo);
  }

  public function setSecurityManager(Interfaces\SecurityManager $sec)
  {
    $this->defineManager("sec", $sec);
  }

  public function setTemplateManager(Interfaces\TemplateManager $tpl)
  {
    $this->defineManager("tpl", $tpl);
  }

// Magic!

  public function __construct(...$args)
  {
    foreach($args as $key)
    {
      if($key instanceof Interfaces\CacheManager)
        $this->setCacheManager($key);
      elseif($key instanceof Interfaces\DatabaseManager)
        $this->setDatabaseManager($key);
      elseif($key instanceof Interfaces\Router)
        $this->setRouter($key);
      elseif($key instanceof Interfaces\SecurityManager)
        $this->setSecurityManager($key);
      elseif($key instanceof Interfaces\TemplateManager)
        $this->setTemplateManager($key);
      elseif(is_array($key))
        $this->config = $key;
      else
        throw new Exceptions\InvalidConfigurationException("Unknown construction argument");
    }
  }
}
