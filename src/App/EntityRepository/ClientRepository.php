<?php

namespace App\EntityRepository;

use App\Entity\Client;
use App\Entity\CorporateClient;
use App\Entity\PrivateClient;
use App\EntityFilter\ClientFilter as Filter;
use App\EntityInterface\IEntity;
use PDO;
use PDOStatement;

class ClientRepository extends CommonEntityRepository
{
    /**
     * @inheritDoc
     */
    protected static function getSelectStatement(PDO $pdo): PDOStatement
    {
        return $pdo->prepare(
            'select id, type, name, address, inn, passport  from clients '
            . ' where (id = :' . Filter::ID . ' or :' . Filter::ID
            . ' = 0) and (type = :' . Filter::TYPE . ' or :' . Filter::TYPE
            . ' = \'\');'
        );
    }

    /**
     * @inheritDoc
     */
    protected function getCreateStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'insert into clients (id, type, name, address, inn, passport) values (:id, :type, :name, :address, :inn, :passport);'
        );
    }

    /**
     * @inheritDoc
     */
    protected function getUpdateStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'update clients set type = :type, name = :name, address = :address, inn = :inn, passport = :passport where id = :'
            . Filter::ID . ';'
        );
    }

    /**
     * @inheritDoc
     */
    protected function getDeleteStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'delete from clients where id = :' . Filter::ID . ';'
        );
    }

    /**
     * @param PDO   $pdo
     * @param array $row
     * @return Client|CorporateClient|PrivateClient
     */
    protected static function buildEntityFromRow(
        PDO $pdo,
        array $row
    ): Client {
        switch ($row['type']) {
            case Client::TYPE_B2C:
                return (new PrivateClient($pdo))->setId($row['id'])->setName(
                    $row['name']
                )->setAddress($row['address'])->setPassport($row['passport']);
            case Client::TYPE_B2B:
                return (new CorporateClient($pdo))->setId($row['id'])->setName(
                    $row['name']
                )->setAddress($row['address'])->setInn($row['inn']);
            default:
                return new Client($pdo);
        }
    }

    /**
     * @param IEntity|Client|CorporateClient|PrivateClient $client
     * @return array
     */
    protected function fetchParams(IEntity $client): array
    {
        return [
            'id'       => $client->getId(),
            'type'     => $client->getType(),
            'name'     => $client->getName(),
            'address'  => $client->getAddress(),
            'inn'      => $client instanceof CorporateClient ?
                $client->getInn() : null,
            'passport' => $client instanceof PrivateClient ?
                $client->getPassport() : null,
        ];
    }
}