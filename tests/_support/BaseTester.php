<?php

use Codeception\Actor;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class BaseTester extends Actor
{
    use _generated\BaseTesterActions;

    public static function getReflectionMethod(string $class, string $method): ReflectionMethod {
        /** @noinspection PhpUnhandledExceptionInspection */
        $refl_method = (new ReflectionClass($class))->getMethod($method);
        $refl_method->setAccessible(true);
        return $refl_method;
    }

    /** @noinspection PhpUnused */
    public static function linarize(string $text): string {
        return trim(preg_replace('/\s+/', ' ', $text));
    }
}
