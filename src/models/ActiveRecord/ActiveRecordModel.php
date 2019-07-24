<?
declare(strict_types = 1);

namespace Paa\Models\ActiveRecord;

use Paa\App\PostgresqlController;

use PDO;
use PDOStatement;
use PDOException;

class ActiveRecordModel extends PostgresqlController
{

    private $id;
    private $idHall;
    private $cinemaName;
    private $seatHall;

    private $updateStmt;
    private $insertStmt;
    private $selectStmt;
    private $deleteStmt;

/*
CREATE TABLE "cinemaHall" (
    id bigint DEFAULT nextval('cinemahall_id_seq'::regclass) NOT NULL,
    "idHall" integer DEFAULT 0 NOT NULL,
    "cinemaName" character varying(254) DEFAULT ''::character varying NOT NULL,
    "seatHall" integer DEFAULT 0 NOT NULL
);
*/

    public function __construct() 
    {
        $this->pdo = parent::__construct();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $this->insertStmt = $this->pdo->prepare(
    		'insert into "cinemaHall" ("idHall", "cinemaName", "seatHall") values (?, ?, ?)'
	);
        
        $this->updateStmt = $this->pdo->prepare(
                'update "cinemaHall" set "idHall" = ?, "cinemaName" = ?, "seatHall" = ? where "id" = ?'
        );

        $this->selectStmt = $this->pdo->prepare(
                'select "id", "idHall", "cinemaName", "seatHall" from "cinemaHall" where "id" = ?'
        );
        
        $this->deleteStmt = $this->pdo->prepare(
    		'delete from "cinemaHall" where "id" = ?'
    	);
        
    }
        
    public function getId(): int
    {
	return $this->id;
    }

    public function setId(int $id): self
    {
	$this->id = $id;
	return $this;
    }

    public function getIdHall(): int
    {
	return $this->idHall;
    }

    public function setIdHall(int $idHall): self
    {
	$this->idHall = $idHall;
	return $this;
    }

    public function getCinemaName(): string
    {
	return $this->cinemaName;
    }

    public function setCinemaName(string $cinemaName): self
    {
	$this->cinemaName = $cinemaName;
	return $this;
    }

    public function getSeatHall(): int
    {
	return $this->seatHall;
    }

    public function setSeatHall(string $seatHall): self
    {
	$this->seatHall = $seatHall;
	return $this;
    }
   
    public function update(): bool
    {
	return $this->updateStmt->execute([
	    $this->idHall,
    	    $this->cinemaName,
            $this->seatHall,
	    $this->id
	]);
    }
    
    public function insert()
    {
	$this->insertStmt->execute([ 
	    $this->idHall,
    	    $this->cinemaName,
            $this->seatHall
	]);
	
        return $this->pdo->lastInsertId();
    }
                                

    public function select()
    {
	$this->selectStmt->execute([$this->id]);
	return $this->selectStmt->fetchAll();
    }

    public function delete(): bool
    {
	return $this->deleteStmt->execute([$this->id]);
    }

}
