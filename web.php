<?php
ob_start();
phpinfo(~(2+64));
print str_ireplace('.e {background', '.e {white-space: nowrap; background', ob_get_clean());
?><ul><li><?=PHP_SAPI?></li><?php array_map(function($name) { print "<li>{$name}</li>"; }, get_loaded_extensions()); ?></ul>
