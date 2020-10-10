<?php

use Dotenv\Dotenv;
use Otus\ORM;

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$orm = new ORM();

// Insert data
$mail = $orm->insert([
    'mailbox_id'     => 1,
    'received_at'    => (new DateTime())->format('Y-m-d H:i:s'),
    'message_id'     => 'a12312bcfn123',
    'subject'        => 'Test subject',
    'from_name'      => 'Ivan Ivanov',
    'from_email'     => 'ivan@example.com',
    'sender_name'    => 'Ivan Ivanov',
    'sender_email'   => 'ivan@example.com',
    'plain_text'     => 'Test text',
    'html'           => '<p>Test text</p>',
    'to_email'       => 'igor@example.com',
    'cc_email'       => 'igor@example.com',
    'bcc_email'      => 'igor@example.com',
    'reply_to_email' => 'igor@example.com',
]);
dump($mail);

// Find data and check identity map
$mail1 = $orm->find($mail->getId());
$mail2 = $orm->find($mail->getId());
dump($mail1 === $mail2);

// Test update
$mail->setSubject('Test Update');
$result = $orm->update($mail);
dump($result);

// Test delete
$result = $orm->delete($mail);
dump($result);

// Test select collection
$mails = $orm->all();
dump($mails);
