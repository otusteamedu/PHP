<?php

namespace rudin\otus11\DataMapper;

use rudin\otus11\Entities\User;
use rudin\otus11\Entities\DB;

class UsersMapper {
	public function __construct() {
		$this->pdo = DB::pdo();
	}

	public function findById($id) {
		$sql = "SELECT * FROM users WHERE id = :id";
		$sth = $this->pdo->prepare($sql);
		$sth->execute(["id"=>$id]);
		$u = $sth->fetch(\PDO::FETCH_ASSOC);
		$userEntity = new User($u["id"], $u["name"], $u["email"], $u["password"], $u["token"]);
		return $userEntity;
	}

	public function getListUsers() {
		$sql = "SELECT id, name FROM users;";
		$sth = $this->pdo->prepare($sql);
		$sth->execute();
		$users = $sth->fetchAll(\PDO::FETCH_ASSOC);
		return $users;
	}

	public function findByEmail($email) {
		$sql = "SELECT * FROM users WHERE email = :email";
		$sth = $this->pdo->prepare($sql);
		$sth->execute(["email"=>$email]);
		$users = [];
		$userEntities = $sth->fetchAll(\PDO::FETCH_ASSOC);
		foreach($userEntities as $entity) {			
			$users[] = new User($entity["id"], $entity["name"], $entity["email"], $entity["password"], $entity["token"]);
		}
		return $users;
	}

	public function create(User $user) {
		if($user->getId() == 0) {
			// создать пользователя
			$sql = "INSERT INTO users (name, email, password, token) VALUES (:name, :email, :password, :token)";
			try {
				$this->userValidation($user);

				$sth = $this->pdo->prepare($sql);
				$sth->bindParam("name", $user->getUser()["name"]);
				$sth->bindParam("email", $user->getUser()["email"]);
				$sth->bindParam("password", $user->getUser()["password"]);
				$sth->bindParam("token", $user->getUser()["token"]);
				$sth->execute();
				$cnt = $sth->rowCount();
				if($cnt == 0) throw new \Exception($sth->errorInfo()[2], 1);
				

				return $cnt;				
			} catch(\Exception $e) {
				throw new \Exception($e->getMessage(), 1);
				
			}
		} else {
			// вызвать ошибку
			throw new \Exception("Пользователь существует", 1);			
		}
	}

	private function userValidation(User $user) {
		if(trim($user->getUser()["name"]) == "") throw new \Exception("Имя пользователя пустое", 1);
		if(trim($user->getUser()["email"]) == "") throw new \Exception("Пустой email", 1);
		if(trim($user->getUser()["password"]) == "") throw new \Exception("Пустой пароль", 1);
		if(!filter_var($user->getUser()["email"], FILTER_VALIDATE_EMAIL))
			throw new \Exception("Некорректный Email", 1);
		if(count($this->findByEmail($user->getUser()["email"])) > 0) throw new \Exception("Такой пользователь уже существует", 1);
	}
}