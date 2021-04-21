<?php


namespace Service\Mailer;


use App\Service\Mailer\EmailService;
use PHPUnit\Framework\TestCase;

class EmailServiceTest extends TestCase
{
    public function testCanCreateService()
    {
        $host = 'mailercatcher';
        $port = 1025;
        $username = '';
        $password = '';

        $service = new EmailService($host, $port, $username, $password);

        $this->assertInstanceOf(EmailService::class, $service);
    }

    public function testSendEmail()
    {
        $host = 'mailercatcher';
        $port = 1025;
        $username = '';
        $password = '';

        $service = new EmailService($host, $port, $username, $password);

        $result = $service->sendEmail('user@mail.com', 'Test mail', 'Test body');
        $this->assertTrue($result);

    }

}
