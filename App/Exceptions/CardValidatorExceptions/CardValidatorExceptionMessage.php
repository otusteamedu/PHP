<?php


namespace Exception\CardValidatorExceptions;

use Controllers\Orders\CardData;

class CardValidatorExceptionMessage
{
    public const NUMBER_COUNT_INCORRECT = "Неверное количество символов в номере карты";
    public const NUMBER_NOT_INT = "Полученный номер не является числом";
    public const NAME_COUNT_INCORRECT = "Некорректное количество символов в CARD HOLDER";
    public const NAME_REG_EX_ERROR = "Некорректные символы в CARD HOLDER";
    public const DATE_EXP_FORMAT_ERROR = "Некорректный формат окончания срока действия карты";
    public const DATE_EXP_EXPIRED = "Срок действия карты истек";
    public const CVV_LENGTH_INCORRECT = "Некорректная длина CVV";
}