<?php

namespace Otus\Entities;

use PDO;
use PDOStatement;

class MailMapper
{
    private PDO $pdo;

    private PDOStatement $findStmt;

    private PDOStatement $allStmt;

    private PDOStatement $insertStmt;

    private PDOStatement $updateStmt;

    private PDOStatement $deleteStmt;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->setFindStmt()
             ->setAllStmt()
             ->setInsertStmt()
             ->setUpdateStmt()
             ->setDeleteStmt();
    }

    private function setFindStmt(): self
    {
        $this->findStmt = $this->pdo->prepare(
            <<<SELECT_STMT
                select 
                       id, 
                       mailbox_id,
                       received_at, 
                       message_id, 
                       subject, 
                       from_name, 
                       from_email, 
                       sender_name, 
                       sender_email, 
                       plain_text, 
                       html,
                       to_email, 
                       cc_email, 
                       bcc_email, 
                       reply_to_email 
                from mails 
                where id = ?
            SELECT_STMT
        );

        return $this;
    }

    private function setAllStmt(): self
    {
        $this->allStmt = $this->pdo->prepare(
            <<<SELECT_STMT
                select 
                       id, 
                       mailbox_id,
                       received_at, 
                       message_id, 
                       subject, 
                       from_name, 
                       from_email, 
                       sender_name, 
                       sender_email, 
                       plain_text, 
                       html,
                       to_email, 
                       cc_email, 
                       bcc_email, 
                       reply_to_email 
                from mails 
            SELECT_STMT
        );

        return $this;
    }

    private function setInsertStmt(): self
    {
        $this->insertStmt = $this->pdo->prepare(
            <<<INSERT_STMT
                insert into mails (
                   mailbox_id,
                   received_at,
                   message_id,
                   subject,
                   from_name,
                   from_email,
                   sender_name,
                   sender_email,
                   plain_text,
                   html,
                   to_email,
                   cc_email,
                   bcc_email,
                   reply_to_email
                ) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            INSERT_STMT
        );

        return $this;
    }

    private function setUpdateStmt(): self
    {
        $this->updateStmt = $this->pdo->prepare(
            <<<UPDATE_STMT
                update mails set 
                     mailbox_id = ?, 
                     received_at = ?, 
                     message_id = ?, 
                     subject = ?, 
                     from_name = ?, 
                     from_email = ?, 
                     sender_name = ?, 
                     sender_email = ?, 
                     plain_text = ?, 
                     html = ?, 
                     to_email = ?, 
                     cc_email = ?, 
                     bcc_email = ?, 
                     reply_to_email = ? 
                where id = ?
            UPDATE_STMT
        );

        return $this;
    }

    private function setDeleteStmt(): self
    {
        $this->deleteStmt = $this->pdo->prepare("delete from mails where id = ?");

        return $this;
    }

    public function find(int $id): ?Mail
    {
        $this->findStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->findStmt->execute([$id]);
        if (! $result = $this->findStmt->fetch()) {
            return null;
        }

        return new Mail($result);
    }

    public function all(): MailCollection
    {
        $this->allStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->allStmt->execute();
        $result = $this->allStmt->fetchAll();

        return new MailCollection($result);
    }

    public function insert(array $data): Mail
    {
        $this->insertStmt->execute(array_values($data));

        $data['id'] = $this->pdo->lastInsertId();

        return new Mail($data);
    }

    public function update(Mail $mail): bool
    {
        return $this->updateStmt->execute([
            $mail->getMailboxId(),
            $mail->getReceivedAt(),
            $mail->getMessageId(),
            $mail->getSubject(),
            $mail->getFromName(),
            $mail->getFromEmail(),
            $mail->getSenderName(),
            $mail->getSenderEmail(),
            $mail->getPlainText(),
            $mail->getHtml(),
            $mail->getToEmail(),
            $mail->getCcEmail(),
            $mail->getBccEmail(),
            $mail->getReplyToEmail(),
            $mail->getId(),
        ]);
    }

    public function delete(Mail $mail): bool
    {
        return $this->deleteStmt->execute([$mail->getId()]);
    }
}
