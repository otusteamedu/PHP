<?php
declare(strict_types = 1);
namespace App;


class ActiveRecord
{
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $login;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var string
     */
    private $tel;
    /**
     * @var string
     */
    private $address;
    /**
     * @var string
     */
    private $created;
    /**
     * @var string
     */
    private $updated;
    /**
     * @var string
     */
    private $admin;
     /**
     * @var array
     */
    private $admins;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;
    /**
     * @var int
     */
    private $age;
     /**
     * @var array
     */
    private $ids;
    /**
     * @var array
     */
    private $logins;
    /**
     * @var array
     */
    private $names;
    /**
     * @var array
     */
    private $lastNames;
    /**
     * @var array
     */
    private $tels;
    /**
     * @var array
     */
    private $addresss;
    /**
     * @var array
     */
    private $createds;
    /**
     * @var array
     */
    private $updateds;
    /**
     * @var array
     */
    private $emails;
    /**
     * @var array
     */
    private $passwords;
    /**
     * @var array
     */
    private $ages;
    /**
     * @var int
     */
    private $adminCoint;
    /**
     * @var \PDOStatement
     */
    private $insertStmt;
    /**
     * @var \PDOStatement
     */
    private $updateStmt;
    /**
     * @var \PDOStatement
     */
    private $deleteStmt;
    /**
     * @var \PDOStatement
     */
    private static $selectQueryGetById = "select login, name, surname, age, tel, address, created, updated, admin, email, password from users where id = ?";
    /**
     * @var \PDOStatement
     */
    private static $selectQueryGetByNames = "select login, name, surname, age, tel, address, created, updated, admin, email, password  from users where name LIKE 'a%' ORDER by name DESC ";
    /**
     * @var \PDOStatement
     */
    private static $selectQueryGetByDateBetween = "select login, name, surname, age, tel, address, created, updated, admin, email, password  FROM users where created BETWEEN '1998-06-21 05:43:41' AND '2020-01-24 11:41:42'";
    /**
     * @var \PDOStatement
     */
    private static $selectQueryGetByAdmin = "select count(admin) as admins FROM users WHERE admin ='yes'";
      /**
     * @param int 
     * @return ActiveRecord
     */
    public function setCountAdmins(int $adminCoint):self
    {
        $this->adminCoint = $adminCoint;
        return $this;
    }
      /**
     * @return int
     */
    public function getCountAdmins():int
    {
        return $this->adminCoint;
    }
     /**
     * @param int $id
     * @return ActiveRecord
     */
    public function setId(int $id):self
    {
        $this->id = $id;
        return $this;
    }

      /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }
       /**
     * @param string
     * @return ActiveRecord
     */
    public function setLogin(string $login):self
    {
        $this->login = $login;
        return $this;
    }
    public function getLogin()
    {
        return $this->login;
    }
      /**
     * @param string
     * @return ActiveRecord
     */
    public function setName($name):self
    {
        $this->name = $name;
        return $this;
    }
     /**
     * @return string
     */
    public function getName()
    {
        return  $this->name;
    }
     /**
     * @param string
     * @return ActiveRecord
     */
    public function setLastName(string $lastName):self
    {
        $this->lastName = $lastName;
        return $this;
    }
      /**
     * @return string
     */
    public function getLastName():string
    {
        return  $this->lastName;
    }
    /**
     * @param string
     * @return ActiveRecord
     */
    public function setTel(string $tel):self
    {
        $this->tel = $tel;
        return $this;
    }
     /**
     * @return string
     */
    public function getTel():string
    {
        return $this->tel;
    }
       /**
     * @param string
     * @return ActiveRecord
     */
    public function setAddress(string $address):self
    {

        $this->address = $address;
        return $this;
    }
      /**
     * @return string
     */
    public function getAddress():string
    {

        return  $this->address;
    }
      /**
     * @param string
     * @return ActiveRecord
     */
    public function setCreated(string $created):self
    {
        $this->created = $created;
        return $this;
    }
    /**
     * @return string
     */
    public function getCreated():string
    {
        return $this->created;
    }
    /**
     * @param string
     * @return ActiveRecord
     */
    public function setUpdated(string $updated):self
    {
        $this->updated = $updated;
        return $this;
    }
     /**
     * @return string
     */

    public function getUpdated():string
    {
        return $this->updated;
    }
    /**
     * @param string
     * @return ActiveRecord
     */
    public function setAdmin(string $admin):self
    {
        $this->admin = $admin;
        return $this;
    }
     /**
     * @return string
     */

    public function getAdmin():string
    {
        return $this->admin;
    }
        /**
     * @param string
     * @return ActiveRecord
     */
    public function setEmail(string $email):self
    {
        $this->email = $email;
        return $this;
    }
       /**
     * @return string
     */

    public function getEmail():string
    {
        return   $this->email;
    }
            /**
     * @param string
     * @return ActiveRecord
     */
    public function setPassword(string $password):self
    {
        $this->password = $password;
        return $this;
    }
        /**
     * @return string
     */

    public function getPassword():string
    {
        return $this->password;
    }
    public function setAge(int $age):self
    {
        $this->age = $age;
        return $this;
    }
     /**
     * @return int
     */

    public function getAge():int
    {
        return  $this->age;
    }

     /**
     * @param array
     * @return ActiveRecord
     */
    public function setIds(array $ids):self
    {
        $this->ids = $ids;
        return $this;
    }

      /**
     * @return array
     */
    public function getIds():array
    {
        return $this->ids;
    }
       /**
     * @param array
     * @return ActiveRecord
     */
    public function setLogins(array $login):self
    {
        $this->login = $login;
        return $this;
    }
     /**
     * @return array
     */
    public function getLogins():array
    {
        return $this->logins;
    }
      /**
     * @param array
     * @return ActiveRecord
     */
    public function setNames(array $names):self
    {
        $this->names = $names;
        return $this;
    }
     /**
     * @return array
     */
    public function getNames():array
    {
        return  $this->names;
    }
     /**
     * @param array
     * @return ActiveRecord
     */
    public function setLastNames(array $lastNames):self
    {
        $this->lastNames = $lastNames;
        return $this;
    }
      /**
     * @return array
     */
    public function getLastNames():array
    {
        return  $this->lastNames;
    }
    /**
     * @param array
     * @return ActiveRecord
     */
    public function setTels(array $tels):self
    {
        $this->tels = $tels;
        return $this;
    }
     /**
     * @return array
     */
    public function getTels():array
    {
        return $this->tels;
    }
       /**
     * @param array
     * @return ActiveRecord
     */
    public function setAddresss(array $addresss):self
    {

        $this->addresss = $addresss;
        return $this;
    }
      /**
     * @return array
     */
    public function getAddresss():array
    {

        return  $this->addresss;
    }
      /**
     * @param array
     * @return ActiveRecord
     */
    public function setCreateds(array $created):self
    {
        $this->created = $created;
        return $this;
    }
    /**
     * @return array
     */
    public function getCreateds():array
    {
        return $this->createds;
    }
    /**
     * @param array
     * @return ActiveRecord
     */
    public function setUpdateds(array $updateds):self
    {
        $this->updateds = $updateds;
        return $this;
    }
     /**
     * @return array
     */

    public function getUpdateds():array
    {
        return $this->updateds;
    }
    /**
     * @param array
     * @return ActiveRecord
     */
    public function setAdmins(array $admins):self
    {
        $this->admins = $admins;
        return $this;
    }
     /**
     * @return array
     */

    public function getAdmins():array
    {
        return $this->admins;
    }
        /**
     * @param array
     * @return ActiveRecord
     */
    public function setEmails(array $emails):self
    {
        $this->emails = $emails;
        return $this;
    }
       /**
     * @return array
     */

    public function getEmails():array
    {
        return $this->emails;
    }
            /**
     * @param array
     * @return ActiveRecord
     */
    public function setPasswords(array $passwords):self
    {
        $this->passwords = $passwords;
        return $this;
    }
        /**
     * @return array
     */

    public function getPasswords():array
    {
        return $this->passwords;
    }
    /**
     * @param array
     * @return ActiveRecord
     */
    public function setAges(array $ages):self
    {
        $this->ages = $ages;
        return $this;
    }
     /**
     * @return array
     */

    public function getAges():array
    {
        return  $this->ages;
    }

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->insertStmt = $pdo->prepare("insert into users (login, name, surname, age, tel, address, created,  admin, email, password) values (?, ?, ?, ?, ?, ?,?,?,?,?)");
        $this->updateStmt = $pdo->prepare(
            "update users set login = ?, name = ?, surname = ?, age = ?, tel = ?, address = ?, updated=?, admin=?, email=?, password=?  where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from users where id = ?");
    }
        /**
     * @param \PDO $pdo
     * @param int $id
     *
     * @return ActiveRecord
     */
    public static function getById(\PDO $pdo, int $id): self
    {
        $selectStmt = $pdo->prepare(self::$selectQueryGetById);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch();
        return (new self($pdo))
            ->setId($id)
            ->setName($result['name'])
            ->setLastName($result['surname'])
            ->setAge($result['age'])
            ->setLogin($result['login'])
            ->setTel($result['tel'])
            ->setAddress($result['address'])
            ->setUpdated($result['updated'])
            ->setCreated($result['created'])
            ->setAdmin($result['admin'])
            ->setEmail($result['email'])
            ->setPassword($result['password']);
    }
        /**
     * @param \PDO $pdo
     *
     * @return ActiveRecord
     */
    public static function getByNamesLikeAUsers(\PDO $pdo): self
    {
        $selectStmt = $pdo->prepare(self::$selectQueryGetByNames);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute();
        $result = $selectStmt->fetchAll();
        foreach ($result as $value) {
            $ids[] = $value['$id'];
            $names[] = $value['name'];
            $surnames[] = $value['surname'];
            $ages[] = $value['age'];
            $logins[] = $value['login'];
            $tels[] = $value['tel'];
            $addresss[] = $value['address'];
            $updateds[] = $value['updated'];
            $createds[] = $value['created'];
            $admins[] = $value['admin'];
            $emails[] = $value['email'];
            $passwords[] = $value['password'];
        }
        return (new self($pdo))
            ->setIds($ids)
            ->setNames($names)
            ->setLastNames($surnames)
            ->setAges($ages)
            ->setLogins($logins)
            ->setTels($tels)
            ->setAddresss($addresss)
            ->setUpdateds($updateds)
            ->setCreateds($createds)
            ->setAdmins($admins)
            ->setEmails($emails)
            ->setPasswords($passwords);
    }
        /**
     * @param \PDO $pdo
     *
     * @return ActiveRecord
     */
    public static function getByDateBetweenUsers(\PDO $pdo): self
    {
        $selectStmt = $pdo->prepare(self::$selectQueryGetByDateBetween);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute();
        $result = $selectStmt->fetchAll();
        foreach ($result as $value) {
            $ids[] = $value['$id'];
            $names[] = $value['name'];
            $surnames[] = $value['surname'];
            $ages[] = $value['age'];
            $logins[] = $value['login'];
            $tels[] = $value['tel'];
            $addresss[] = $value['address'];
            $updateds[] = $value['updated'];
            $createds[] = $value['created'];
            $admins[] = $value['admin'];
            $emails[] = $value['email'];
            $passwords[] = $value['password'];
        }
        return (new self($pdo))
            ->setIds($ids)
            ->setNames($names)
            ->setLastNames($surnames)
            ->setAges($ages)
            ->setLogins($logins)
            ->setTels($tels)
            ->setAddresss($addresss)
            ->setUpdateds($updateds)
            ->setCreateds($createds)
            ->setAdmins($admins)
            ->setEmails($emails)
            ->setPasswords($passwords);
    }
        /**
     * @param \PDO $pdo
     *
     * @return ActiveRecord
     */
    public static function getByAdmins(\PDO $pdo): self
    {
        $selectStmt = $pdo->prepare(self::$selectQueryGetByAdmin);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute();
        $result = $selectStmt->fetch();

        return (new self($pdo))
            ->setCountAdmins($result['admins']);
    }
        /**
     *
     * @return bool
     */
    public function insert():bool
    {
        $result = $this->insertStmt->execute([
            $this->login,
            $this->name,
            $this->lastName,
            $this->age,
            $this->tel,
            $this->address,
            $this->created,
            $this->admin,
            $this->email,
            $this->password
        ]);
        $this->id = $this->pdo->lastInsertId();
        return $result;
    }
      /**
     *
     * @return bool
     */
    public function update(): bool
    {

        return $this->updateStmt->execute([
            $this->login,
            $this->name,
            $this->lastName,
            $this->age,
            $this->tel,
            $this->address,
            $this->updated,
            $this->admin,
            $this->email,
            $this->password,
            $this->id
        ]);
    }
            /**
     *
     * @return bool
     */
    public function delete(): bool
    {
        $id = $this->id;
        $this->id = null;
        return $this->deleteStmt->execute([$id]);
    }
}
