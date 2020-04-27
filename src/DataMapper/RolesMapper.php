<?php

namespace rudin\otus11\DataMapper;

use rudin\otus11\Entities\User;
use rudin\otus11\Entities\Role;
use rudin\otus11\Entities\DB;

class RolesMapper {
	public function __construct() {
		$this->pdo = DB::pdo();
	}

	public function findByUserId($userId) {
		$sql = "SELECT * from roles WHERE user_id = :user_id";
		$sth = $this->pdo->prepare($sql);
		$sth->execute(["user_id"=>$userId]);
		$roles = $sth->fetchAll(\PDO::FETCH_ASSOC);
		$result = [];
		foreach($roles as $role) {
			$result[] = new Role($role["role_id"], $role["user_id"], $role["role_name"]);
		}
		return $result;
	}
}