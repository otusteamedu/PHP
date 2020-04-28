<?php

namespace rudin\otus11\Entities;

class User {
	private $id;
	private $name;
	private $email;
	private $password;
	private $token;

	public function __construct($id, $name, $email, $password, $token=null) {
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
		$this->password = $password;
		$this->token = $token == null ? "" : $token;
	}

	public function getRoles() {
		$rolesMapper = new \rudin\otus11\DataMapper\RolesMapper();
		return $rolesMapper->findByUserId($this->id);
	}

	public function getId()	 {
		return $this->id;
	}

	public function getUser() {
		return ["name"=>$this->name, "email"=>$this->email, "password"=>$this->password];
	}

	public function getFullData() {
		return ["id"=>$this->id, 
				"name"=>$this->name, 
				"email"=>$this->email, 
				"password"=>$this->password,
				"token"=>$this->token
			];
	}

	public function printRoles() {
		$roles = $this->getRoles();
		$result = [];
		foreach($roles as $role) {
			$result[] = $role->getRoleName();
		}
		echo implode(", ", $result)."\n";
	}
}