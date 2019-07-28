<?php

namespace AnrDaemon\CcWeb\Exceptions;

use AnrDaemon\CcWeb\Interfaces;

class InvalidConfigurationException
extends \InvalidArgumentException
implements Interfaces\FrameworkException
{
}
