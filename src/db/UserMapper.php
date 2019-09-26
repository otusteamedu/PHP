<?php
namespace MyApp;

class UserMapper {

    private $db;

    private $select;

    private $insert;

    private $update;

    private $delete;

    public function __construct(\PDO $dbh)
    {
        $this->db = $dbh;

        $this->select = $dbh->prepare(
            "SELECT 
                          firstname, 
                          lastname, 
                          phone, 
                          company 
                       FROM 
                          users 
                       WHERE 
                          user_id = ?"
        );
        $this->insert = $dbh->prepare(
            "INSERT INTO 
                          users 
                        SET 
                          firstname = ?, 
                          lastname = ?, 
                          phone = ?, 
                          company = ?"
        );

        $this->update = $dbh->prepare(
            "UPDATE 
                          users 
                       SET 
                          firstname = ?, 
                          lastname = ?, 
                          phone = ?, 
                          company = ?
                       WHERE
                          user_id = ?"
        );
        $this->delete = $dbh->prepare("DELETE FROM users WHERE user_id = ?");
    }


    public function findById($userId)
    {
        $this->select->setFetchMode(\PDO::FETCH_ASSOC);
        $this->select->execute([$userId]);

        if ($this->select->rowCount()) {
            $result = $this->select->fetch();

            return new User(
                $userId,
                $result['firstname'],
                $result['lastname'],
                $result['phone'],
                $result['company']
            );
        }

        return null;

    }


    public function insert($newUser)
    {

        $this->insert->execute([
            $newUser['firstname'],
            $newUser['lastname'],
            $newUser['phone'],
            $newUser['company']
        ]);

        $lastId = $this->db->lastInsertId();

        if (!empty($lastId)) {
            return $this->findById($lastId);
        }

        return null;

    }


    public function update($user)
    {
        return $this->update->execute([
            $user->getFirstname(),
            $user->getLastname(),
            $user->getPhone(),
            $user->getCompany(),
            $user->getUserId()
        ]);
    }


    public function delete($user)
    {
        return $this->delete->execute([$user->getUserId()]);
    }
}