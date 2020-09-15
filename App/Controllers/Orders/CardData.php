<?php


namespace Controllers\Orders;


class CardData
{
    public const NUMBER_DIGIT_COUNT = 16;
    public const CVV_DIGIT_COUNT = 3;
    public const NAME_LENGTH_MIN = 0;
    public const NAME_LENGTH_MAX = 255;
    public const NAME_REG_EX = "/^[A-Z]+(([-]?[ ]*[A-Z])?[A-Z]*)*$/";
    public const DATE_EXPIRE_REG_EX = '/^[0-9]{2}\/[0-9]{2}$/';
}