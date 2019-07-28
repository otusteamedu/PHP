<?php
/** Common controller implementation methods.
*
* @version SVN: $Id$
*/

namespace AnrDaemon\CcWeb\Helpers;

use
  AnrDaemon\CcWeb\Exceptions,
  AnrDaemon\CcWeb\Interfaces;

trait ControllerBase
{
  protected $params;

  abstract protected function validateMetadata($meta = null);

// Interfaces\Controller

  abstract public function run($data = null);

  public static function create(Interfaces\SettingsManager $config, $meta = null)/*TODO:PHP7 : self*/
  {
    $self = new static($config);
    return empty($meta) ? $self : $self->setMetadata($meta);
  }

  public function setMetadata($meta = null)/*TODO:PHP7 : self*/
  {
    $meta = $this->validateMetadata($meta);

    $self = clone $this;
    $self->params = $meta;
    return $self;
  }

  public function getMetadata()/*TODO:PHP7 : ?array*/
  {
    return $this->params;
  }
}
