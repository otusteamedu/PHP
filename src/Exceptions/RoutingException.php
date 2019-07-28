<?php

namespace AnrDaemon\CcWeb\Exceptions;

use AnrDaemon\CcWeb\Interfaces;

class RoutingException
extends \Exception
implements Interfaces\FrameworkException
{
  protected $location;

  public function getLocation()
  {
    return $this->location;
  }

  public function __construct(
    /*TODO:PHP7 string */$message = "",
    /*TODO:PHP7 int */$code = 0,
    /*TODO:PHP7 string */$location = null,
    \Exception /*TODO:PHP7 \Throwable */$previous = null
  )
  {
    parent::__construct($message, $code, $previous);
    $this->location = $location;
  }
}
