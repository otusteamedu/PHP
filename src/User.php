<?php
namespace MyApp;

class User {

    private $user_id;

    private $firstname;

    private $lastname;

    private $phone;

    private $company;

    public function __construct(
        $user_id,
        $fistname,
        $lastname,
        $phone,
        $company
    ) {
        $this->user_id = $user_id;
        $this->firstname = $fistname;
        $this->lastname = $lastname;
        $this->phone = $phone;
        $this->company = $company;
    }

    public function getUserId()
    {
        return $this->user_id;
    }


    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }


    public function getFirstname()
    {
        return $this->firstname;
    }


    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }


    public function getLastname()
    {
        return $this->lastname;
    }


    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }


    public function getPhone()
    {
        return $this->phone;
    }


    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }


    public function getCompany()
    {
        return $this->company;
    }


    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }


}