<?php

namespace HW5_1;

use RuntimeException;

class InfixExpresion
{
    public const ADDITION = '+';
    public const SUBTRACTION = '-';
    public const DIVISION = '/';
    public const MODULO = '%';
    public const MULTIPLICATION = '*';
    public const LEFT_PARENTHESIS = '(';
    public const RIGHT_PARENTHESIS = ')';
    public const SEPARATOR = ' ';
    /**
     * @var string
     */
    private $expresion;
    /**
     * @var Stack
     */
    private $stack;
    /**
     * @var string
     */
    private $output;

    private $precedences = [
        self::ADDITION => 1,
        self::SUBTRACTION => 1,
        self::DIVISION => 2,
        self::MODULO => 2,
        self::MULTIPLICATION => 2,
    ];

    /**
     * Expresion constructor.
     * @param string $expresion
     */
    public function __construct(string $expresion)
    {
        if (!$this->isValid($expresion)) {
            throw new RuntimeException('Expresion is not valid');
        }
        $this->expresion = $expresion;
        $this->stack = new StackImpl();
    }

    private function isValid(string $expresion): bool
    {
        // todo add here infix record validation
        return true;
    }

    public function toPostfix(): string
    {
        $this->output = '';
        $input = mb_ereg_replace(self::SEPARATOR, '', $this->expresion);
        $strlen = strlen($input);
        for ($i = 0; $i < $strlen; $i++) {
            $ch = $input[$i];
            switch ($ch) {
                case self::ADDITION:
                case self::SUBTRACTION:
                    $this->gotOperation($ch, 1);
                    break;
                case self::MULTIPLICATION:
                case self::MODULO:
                case self::DIVISION:
                    $this->gotOperation($ch, 2);
                    break;
                case self::LEFT_PARENTHESIS:
                    $this->stack->push($ch);
                    break;
                case self::RIGHT_PARENTHESIS:
                    $this->gotRightParenthesis();
                    break;
                case preg_match('/[\d\.]/', $ch) > 0:
                    $str = '';
                    do {
                        $str .= $ch;
                        $i++;
                        if ($i >= $strlen) {
                            break;
                        }
                        $ch = $input[$i];
                    } while (preg_match('/[\d\.]/', $ch) > 0);
                    $i--;
                    $this->toOutput($str);
                    break;
                default:
            }
        }
        while (!$this->stack->isEmpty()) {
            $this->toOutput($this->stack->pop());
        }
        return trim($this->output);
    }

    private function gotOperation($opThis, int $precedence): void
    {
        while (!$this->stack->isEmpty()) {
            $ch = $this->stack->pop();
            if ($ch === self::LEFT_PARENTHESIS) {
                $this->stack->push($ch);
                break;
            }

            $precedenceTop = $this->precedences[$ch];
            if ($precedenceTop < $precedence) {
                $this->stack->push($ch);
                break;
            }

            $this->toOutput($ch);
        }
        $this->stack->push($opThis);
    }

    /**
     * @param $ch
     * @return string
     */
    private function toOutput($ch): string
    {
        return $this->output .= self::SEPARATOR . $ch;
    }

    private function gotRightParenthesis(): void
    {
        while (!$this->stack->isEmpty()) {
            $ch = $this->stack->pop();
            if ($ch === self::LEFT_PARENTHESIS) {
                break;
            }
            $this->toOutput($ch);
        }
    }
}
