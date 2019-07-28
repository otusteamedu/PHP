<?php

namespace AnrDaemon\CcWeb\Exceptions;

use AnrDaemon\CcWeb\Interfaces;

class UnroutableDestinationException
extends \Exception
implements Interfaces\FrameworkException
{
}
