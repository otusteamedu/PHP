<?php
declare(strict_types = 1);

namespace Controllers\Orders;

use Controllers\Contracts\CardValidatorInterface;
use Exception\CardValidatorExceptions\CardValidatorException;
use Exception\CardValidatorExceptions\CardValidatorExceptionMessage;
use Controllers\Orders\CardData;
use DateTime;
use Logger\Logger;
use Source\HttpResponses;

class CardValidator implements CardValidatorInterface
{

    /**
     * Валидирует номер банковской карты на длину, не число
     * @param string $cardNumber номер банковской карты
     * @throws CardValidatorException
     * @return bool
     */
    public function isValidCardNumber(string $cardNumber): bool
    {
        $cardNumber = str_replace(' ', '', $cardNumber);

        //  проверка на количество символов
        if (strlen($cardNumber) !== CardData::NUMBER_DIGIT_COUNT)
            Throw new CardValidatorException(CardValidatorExceptionMessage::NUMBER_COUNT_INCORRECT);

        // проверка на число
        if (!filter_var($cardNumber, FILTER_VALIDATE_INT))
            Throw new CardValidatorException(CardValidatorExceptionMessage::NUMBER_NOT_INT);

        return true;
    }

    /**
     * Валидация имени и фамилии держателя банковской карты
     * @param string $cardHolder имя держателя карты
     * @return bool
     */
    public function isValidCardHolder(string $cardHolder): bool
    {
        $cardHolder = strtoupper(trim($cardHolder));

        //   проверка на длину
        if (
            strlen($cardHolder) < CardData::NAME_LENGTH_MIN ||
            strlen($cardHolder) > CardData::NAME_LENGTH_MAX
        )
            Throw new CardValidatorException(CardValidatorExceptionMessage::NUMBER_COUNT_INCORRECT);

        //  проверка по регулярному выражению
        if (!preg_match(CardData::NAME_REG_EX, $cardHolder))
            Throw new CardValidatorException(CardValidatorExceptionMessage::NAME_REG_EX_ERROR);

        return true;

    }

    /**
     * Проверка даты окончания действия на корректность
     * @param string $cardExpiration дата окончания действия в формате мм/гг
     * @return bool
     */
    public function isValidCardExpiration(string $cardExpiration): bool
    {
        $cardExpiration = str_replace(' ', '', $cardExpiration);

        if (!preg_match(CardData::DATE_EXPIRE_REG_EX, $cardExpiration)) {
            Throw new CardValidatorException(CardValidatorExceptionMessage::DATE_EXP_FORMAT_ERROR);
        }

        $cardExpiration = \DateTime::createFromFormat('m/y', $cardExpiration);
        $currentDate = new \DateTime();

        if ($cardExpiration < $currentDate) {
            Throw new CardValidatorException(CardValidatorExceptionMessage::DATE_EXP_EXPIRED);
        }

        return true;
    }

    /**
     * Функция проверки кода CVV на корректность
     * @param int $cvv
     * @return bool
     */
    public function isValidCVV(int $cvv): bool
    {
        if(strlen((string) $cvv) !== CardData::CVV_DIGIT_COUNT) {
            Throw new CardValidatorException(CardValidatorExceptionMessage::CVV_LENGTH_INCORRECT);
        }

        return true;
    }

    /**
     * Валидация полученных данных карты
     * @param array $data массив данных для проверки
     * @return void
     */
    public function validateCardData(array $data): bool
    {
        try {
            $this->isValidCardExpiration($data['card_expiration']);
            $this->isValidCardHolder($data['card_holder']);
            $this->isValidCardNumber($data['card_number']);
            $this->isValidCVV($data['cvv']);
        } catch (CardValidatorException $e) {

            Logger::logToFile(PaymentData::LOG_FILE_NAME, $e->getMessage());

            http_response_code(400);

            echo HttpResponses::response(400, $e->getMessage());
        }

        return true;
    }
}