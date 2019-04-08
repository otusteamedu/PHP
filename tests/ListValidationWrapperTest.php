<?php

namespace HW7_1;

use PHPUnit\Framework\TestCase;

class ListValidationWrapperTest extends TestCase
{
    public function getContent(): array
    {
        return [
            [
                <<<'TAG'
pawigor@gmail.com
inbox@pieware.pro    
TAG
                ,
                'valid' => true,
            ],
            [
                <<<'TAG'
pawigor@gmail@com
it_s_not_valid_email@дрын-дын-дын.com
It's not valid email@gmail.com                    
TAG
                ,
                'valid' => false
            ]
        ];
    }

    /**
     * @dataProvider getContent
     * @param $content
     * @param $valid
     */
    public function testValidate($content, $valid): void
    {
        $val = new ListValidationWrapper(new ComplexValidation([new RegexpValidation(), new CheckDNSValidation()]));
        $emails = explode("\n", $content);
        $validateArray = $val->validateArray($emails);
        foreach ($validateArray as $email => $result) {
            self::assertContains($email, $emails);
            self::assertSame($result, $valid);
        }
    }
}
