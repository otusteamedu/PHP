<?php
/** Universal stackable classloader.
*
* @version SVN: $Id: classloader.php 1001 2019-03-10 20:40:08Z anrdaemon $
*/

namespace AnrDaemon\Net;

return \call_user_func(
  function()
  {
    $nsl = \strlen(__NAMESPACE__);
    return \spl_autoload_register(
      function($className)
      use($nsl)
      {
        if(\strncmp($className, __NAMESPACE__, $nsl) !== 0)
          return;

        $className = \substr($className, $nsl);
        if($className[0] !== "\\")
          return;

        $path = __DIR__ . \strtr("$className.php", '\\', '/');
        if(\file_exists($path))
        {
          return include $path;
        }
      }
    );
  }
);
