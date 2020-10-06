<?php

namespace Tests\_support\Model;

/**
 * Class ClientModel
 * @package Tests\_support\Model
 */
class ClientModel extends JsonDataDriver implements ModelInterface
{
    /* id категории клиента */
    public $categoryID;
    /* название категории клиента */
    public $categoryName;
    /* id группы клиента */
    public $groupID;
    /* название группы клиента */
    public $groupName;
    /* тип регистрации: 1 - физическое лицо, 2 - юр. лицо */
    public $userType;
    /* название организации для юр. лиц */
    public $organizationName;
    /* фамилия клиента */
    public $surname;
    /* имя клиента */
    public $name;
    /* отчество клиента */
    public $secondName;
    /* контактный телефон */
    public $phone;
    /* мобильный телефон */
    public $mobilePhone;
    /* e-mail */
    public $email;
    /* ICQ */
    public $icq;
    /* Skype */
    public $skype;
    /* логин */
    public $login;
    /* пароль */
    public $password;
    /* id вида деятельности */
    public $businessID;
    /* страна */
    public $country;
    /* область */
    public $region;
    /* город */
    public $city;
    /* использование кредитного лимита */
    public $useCreditLimit;
    /* кредитный лимит */
    public $creditLimit;
    /* id менеджера клиента */
    public $managerID;
    /* логин менеджера клиента */
    public $managerLogin;
    /* комментарий менеджера */
    public $managerComment;
    /* ФИО */
    public $fullName;

    protected $jsonFileName = 'client_data.json';

    /**
     * @return mixed
     */
    public function getCategoryID()
    {
        return $this->categoryID;
    }

    /**
     * @param mixed $categoryID
     */
    public function setCategoryID($categoryID)
    {
        $this->categoryID = $categoryID;
    }

    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * @param mixed $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    /**
     * @return mixed
     */
    public function getGroupID()
    {
        return $this->groupID;
    }

    /**
     * @param mixed $groupID
     */
    public function setGroupID($groupID)
    {
        $this->groupID = $groupID;
    }

    /**
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param mixed $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param mixed $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    /**
     * @return mixed
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * @param mixed $organizationName
     */
    public function setOrganizationName($organizationName)
    {
        $this->organizationName = $organizationName;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * @param mixed $secondName
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @param mixed $mobilePhone
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getIcq()
    {
        return $this->icq;
    }

    /**
     * @param mixed $icq
     */
    public function setIcq($icq)
    {
        $this->icq = $icq;
    }

    /**
     * @return mixed
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * @param mixed $skype
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getBusinessID()
    {
        return $this->businessID;
    }

    /**
     * @param mixed $businessID
     */
    public function setBusinessID($businessID)
    {
        $this->businessID = $businessID;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getUseCreditLimit()
    {
        return $this->useCreditLimit;
    }

    /**
     * @param mixed $useCreditLimit
     */
    public function setUseCreditLimit($useCreditLimit)
    {
        $this->useCreditLimit = $useCreditLimit;
    }

    /**
     * @return mixed
     */
    public function getCreditLimit()
    {
        return $this->creditLimit;
    }

    /**
     * @param mixed $creditLimit
     */
    public function setCreditLimit($creditLimit)
    {
        $this->creditLimit = $creditLimit;
    }

    /**
     * @return mixed
     */
    public function getManagerID()
    {
        return $this->managerID;
    }

    /**
     * @param mixed $managerID
     */
    public function setManagerID($managerID)
    {
        $this->managerID = $managerID;
    }

    /**
     * @return mixed
     */
    public function getManagerLogin()
    {
        return $this->managerLogin;
    }

    /**
     * @param mixed $managerLogin
     */
    public function setManagerLogin($managerLogin)
    {
        $this->managerLogin = $managerLogin;
    }

    /**
     * @return mixed
     */
    public function getManagerComment()
    {
        return $this->managerComment;
    }

    /**
     * @param mixed $managerComment
     */
    public function setManagerComment($managerComment)
    {
        $this->managerComment = $managerComment;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

}