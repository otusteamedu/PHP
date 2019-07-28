<?php

namespace AnrDaemon\CcWeb\Exceptions;

use AnrDaemon\CcWeb\Interfaces;

class InvalidMetadataException
extends \UnexpectedValueException
implements Interfaces\FrameworkException
{
}
