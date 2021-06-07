<?php

namespace App\Services\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
    private PHPMailer $mailClient;

    public function __construct()
    {
        $this->mailClient = new PHPMailer();
        $this->mailClient->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mailClient->isSMTP();
        $this->mailClient->Host       = env('MAIL_HOST');
        $this->mailClient->SMTPAuth   = true;
        $this->mailClient->Username   = env('MAIL_USERNAME');
        $this->mailClient->Password   = env('MAIL_PASSWORD');
        $this->mailClient->SMTPSecure = env('MAIL_ENCRYPTION');
        $this->mailClient->Port       = env('MAIL_PORT');
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send()
    {
        $this->mailClient->send();
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function setFrom(string $email, string $name = '') : self
    {
        $this->mailClient->setFrom($email, $name);
        return $this;
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function addAddress(string $email, string $name = '') : self
    {
        $this->mailClient->addAddress($email, $name);
        return $this;
    }

    public function setSubject(string $subject) : self
    {
        $this->mailClient->Subject = $subject;
        return $this;
    }

    public function setBody(string $body) : self
    {
        $this->mailClient->Body = $body;
        return $this;
    }
}