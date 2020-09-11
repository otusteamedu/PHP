<?php


namespace Otus\Http;


class Validator
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate(string $key): bool
    {
        if (! $this->keyExists($key)) {
            return false;
        }

        if (! $this->validValue($key)) {
            return false;
        }

        if (! $this->validBracketsOrder($key)) {
            return false;
        }

        return true;
    }

    private function keyExists(string $key): bool
    {
        return $this->request->has($key);
    }

    private function validValue(string $key): bool
    {
        $pattern = '/[^\(\)]/';
        $sanitizedValue = preg_replace($pattern, '', $this->request->get($key));

        if ($sanitizedValue !== $this->request->get($key)) {
            return false;
        }

        if ($sanitizedValue === '') {
            return false;
        }
        
        if (strlen($sanitizedValue) % 2 !== 0) {
            return false;
        }
        
        return true;
    }

    private function validBracketsOrder(string $key): bool
    {
        $pattern = '/[^\(\)]/';
        $sanitizedValue = preg_replace($pattern, '', $this->request->get($key));

        $counter = 0;
        $length = strlen($sanitizedValue);
        for ($i = 0; $i < $length; $i++) {
            if ($sanitizedValue[$i] === '(') {
                $counter++;
            }

            if ($sanitizedValue[$i] === ')') {
                $counter--;
            }

            if ($counter < 0) {
                return false;
            }
        }

        return $counter === 0;
    }
}
