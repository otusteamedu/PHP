<?php
declare(strict_types=1);

use App\App;

require 'vendor/autoload.php';

try {
    (new App())->run();
} catch (\Throwable $e) {
    echo sprintf(
        "[%s] %s\n",
        get_class($e),
        $e->getMessage()
    );
}
