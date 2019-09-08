<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

require_once __DIR__ . '/vendor/autoload.php';

use Email\AddressValidation;

var_dump(AddressValidation::isValid('bazarov@tutu.ru'));
