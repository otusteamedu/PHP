<?php

namespace crazydope\calculator;

class Expression
    implements ExpressionInterface
{
    /**
     * @var int
     */
    protected $aIdx;
    /**
     * @var int
     */
    protected $bIdx;
    /**
     * @var string
     */
    protected $operator;

    protected $result;

    /**
     * Expression constructor.
     * @param int $aIdx
     * @param int $bIdx
     * @param string $operator
     */
    public function __construct( int $aIdx, int $bIdx, string $operator )
    {
        $this->aIdx = $aIdx;
        $this->bIdx = $bIdx;
        $this->operator = $operator;
    }

    /**
     * @return int
     */
    public function getAIdx(): int
    {
        return $this->aIdx;
    }

    /**
     * @return int
     */
    public function getBIdx(): int
    {
        return $this->bIdx;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult( $result ): void
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    public function toArray(): array
    {
        return [
            'a'      => $this->aIdx,
            'b'      => $this->bIdx,
            'result' => $this->result
        ];
    }

    public function __toString()
    {
        return implode(' ', $this->toArray());
    }

    /**
     * @param int $aIdx
     */
    public function setAIdx( int $aIdx ): void
    {
        $this->aIdx = $aIdx;
    }

    /**
     * @param int $bIdx
     */
    public function setBIdx( int $bIdx ): void
    {
        $this->bIdx = $bIdx;
    }
}