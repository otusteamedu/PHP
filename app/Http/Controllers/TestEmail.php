<?php


namespace app\Http\Controllers;


use app\Exceptions\Validator\BadValidatorException;
use app\Services\Validators\ValidatorFactory;
use app\Http\SystemInformation\SysInfo;
use app\Http\Request\Email\ValidatorRequest;
use app\Http\Response\Email\ValidatorResponse;


class TestEmail
{
    /**
     * Метод контроллера по умолчанию.
     * Запрашивает данные для проверки, проверяет и возвращает ответ.
     * Если установлен GET параметр showInfo в любое значение кроме 'showInfo=no',
     * на экран выведется служебная информация
     *
     * @throws BadValidatorException
     */
    public function run():void
    {
        $validator = ValidatorFactory::factory($_ENV['EMAIL_VALIDATOR']);
        $validator->setDataToValidate(ValidatorRequest::getData());
        $result = $validator->validate();
        if (isset($_GET['showInfo']) && mb_strtolower($_GET['showInfo']) !== 'no') {
            SysInfo::showInfo();
            print_r($validator->getFormatEmailList());
            print_r($result);
        }
        ValidatorResponse::sendData(ValidatorResponse::OK, "Результат проверки Email адресов", $result);
    }

}