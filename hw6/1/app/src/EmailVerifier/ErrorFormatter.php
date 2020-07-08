<?php


namespace EmailVerifier;


class ErrorFormatter
{
    const SIMPLE_FORMAT = '%s<br>';

    public static function format(array $errors, ?string $format = self::SIMPLE_FORMAT): ?string
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