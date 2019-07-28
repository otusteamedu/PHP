<?php

namespace AnrDaemon\CcWeb\Interfaces;

interface SettingsManager
{
  public function getOption(/*TODO:PHP7 string */$optName, /*TODO:PHP7 string */$optGroup = null);
  public function getRouter();
  public function getCacheManager();
  public function getDatabaseManager();
  public function getSecurityManager();
  public function getTemplateManager();
  public function setRouter(Router $reg);
  public function setCacheManager(CacheManager $cache);
  public function setDatabaseManager(DatabaseManager $pdo);
  public function setSecurityManager(SecurityManager $sec);
  public function setTemplateManager(TemplateManager $tpl);
}
