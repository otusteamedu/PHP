<?php

namespace AnrDaemon\CcWeb;

require __DIR__ . "/vendor/autoload.php";

$cfg = new SettingsManager;

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
  return Controllers\ValidateAddress::create($cfg)->run($_POST);
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'HEAD')
{
  return Controllers\Sample::create($cfg)->run();
}
else
{
  throw new Exceptions\RoutingException("Method not allowed", 405); // 405 Method not allowed
}
