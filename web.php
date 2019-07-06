<?php
ob_start();
phpinfo(~(2+64));
print str_ireplace('.e {background', '.e {white-space: nowrap; background', ob_get_clean());
