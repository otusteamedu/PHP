<?php


namespace EmailVerifier;


class ErrorPrinter
{
    const SIMPLE_FORMAT = '%s<br>';

    public static function print(array $errors, ?string $format = self::SIMPLE_FORMAT): void
    {
        echo self::getFormattedErrors($errors, $format);
    }

    public static function getFormattedErrors(array $errors, ?string $format = self::SIMPLE_FORMAT): ?string
    {
        if (empty($errors)) {
            return null;
        }

        $result = '';

        foreach ($errors as $error) {
            $result .= sprintf($format, $error);
        }

        return $result;
    }
}