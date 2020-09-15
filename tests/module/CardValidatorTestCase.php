<?php
declare(strict_types = 1);

namespace module;

require "vendor/autoload.php";

use Exception\CardValidatorExceptions\CardValidatorException;
use PHPUnit\Framework\TestCase;
use Controllers\Orders\CardValidator;

class CardValidatorTestCase extends TestCase
{
    /**
     * @dataProvider numberPositiveProvaider
     * @param string $number номер карты
     * @return void
     */
    public function testNumberPositive(string $number): void
    {
        $validator = new CardValidator();
        $result = $validator->isValidCardNumber($number);

        static::assertTrue($result);
    }

    /**
     * @dataProvider numberNegativeProvaider
     * @param string $number номер карты
     * @return void
     */
    public function testNumberNegative(string $number): void
    {
        $validator = new CardValidator();

        $this->expectException(CardValidatorException::class);

        $validator->isValidCardNumber($number);
    }

    public function numberPositiveProvaider(): array
    {
        return [
            'numeric' => ['1113111122221111'],
            'spaces' => ['1113 1111 2222 1111'],
            'spaces2' => ['11 131111 2222 1 111']
        ];
    }

    public function numberNegativeProvaider(): array
    {
        return [
            'wrong_count' => ['1111 2222 2'],
            'not_a_number' => ['aaaa aaaa bbbb cccc'],
            'not_a_number2' => ['1234 a121 12vc1111'],
            'russian_letters' => ['ж123 ф123 1111 1111'],
            'empty' => [''],
            'negative' => ['-1-1-1-1 1111 1111 2222']
        ];
    }


    /**
     * @dataProvider holderPositiveProvaider
     * @param string $name имя пользователя карты
     * @return void
     */
    public function testHolderPositive(string $name): void
    {
        $validator = new CardValidator();
        $result = $validator->isValidCardHolder($name);

        static::assertTrue($result);
    }

    /**
     * @dataProvider holderNegativeProvaider
     * @param string $name имя пользователя карты
     * @return void
     */
    public function testHolderNegative(string $name): void
    {
        $validator = new CardValidator();

        $this->expectException(CardValidatorException::class);

        $validator->isValidCardNumber($name);
    }

    public function holderPositiveProvaider(): array
    {
        return [
            'lower_case' => ['Aleksei SOkolov'],
            'defis' => ['Aleksei SOkolov-Petrov'],
            'three_words' => ['Aleksei SOkolov Last'],
            'upper_case' => ['ALEKSEI SOKOLOV'],
            'many_spaces' => ['  Aleksei     SOKOLOV   ']
        ];
    }


    public function holderNegativeProvaider(): array
    {
        return [
            'wrong_count' => [''],
            'number_in_line' => ['Aleksei 1 Sokolov'],
            'numbers' => ['1111 11111'],
            'russian_letters' => ['Алексей Соколов']
        ];
    }

    /**
     * @dataProvider dateExpirePositiveProvaider
     * @param string $date дата окончания срока действия карты мм/гг
     * @return void
     */
    public function testDateExpiredPositive(string $date): void
    {
        $validator = new CardValidator();
        $result = $validator->isValidCardExpiration($date);

        static::assertTrue($result);
    }

    /**
     * @dataProvider dateExpireNegativeProvaider
     * @param string $name имя пользователя карты
     * @return void
     */
    public function testDateExpiredNegative(string $name): void
    {
        $validator = new CardValidator();

        $this->expectException(CardValidatorException::class);

        $validator->isValidCardExpiration($name);
    }

    public function dateExpirePositiveProvaider(): array
    {
        $plusMonth = (new \DateTime())->modify('+1 month')->format('m/y');
        $plusYear = (new \DateTime())->modify('+1 year')->format('m/y');
        $wrongString = " $plusYear ";
        $wrongString2 = (new \DateTime())->modify('+1 year')->format('m / y');

        return [
            '+1 month' => [$plusMonth],
            '+1 year' => [$plusYear],
            'wrong string' => [$wrongString],
            'wrong string 2' => [$wrongString2]
        ];
    }


    public function dateExpireNegativeProvaider(): array
    {
        $minusMonth = (new \DateTime())->modify('-1 month')->format('m/y');
        $minusYear = (new \DateTime())->modify('-1 year')->format('m/y');
        $wrongString = " $minusYear \\";
        $wrongString2 = 'aa/bb';
        $wrongString3 = '01/122';

        return [
            '+1 month' => [$minusMonth],
            '+1 year' => [$minusYear],
            'wrong string' => [$wrongString],
            'wrong string 2' => [$wrongString2],
            'wrong string 3' => [$wrongString3]
        ];
    }

}