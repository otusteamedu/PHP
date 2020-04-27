<?php

namespace rudin\otus11\Entities;

class Role {
	private $id;
	private $userId;
	private $roleName;

	public function __construct($id, $userId, $roleName) {
		$this->id = $id;
		$this->userId = $userId;
		$this->roleName = $roleName;
	}

	public function getRoleName() {
		return $this->roleName;
	}
}