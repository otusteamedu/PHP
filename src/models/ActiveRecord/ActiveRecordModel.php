<?
namespace Paa\Models\ActiveRecord;

use Paa\App\PostgresqlController;

use PDO;
use PDOStatement;
use PDOException;

class ActiveRecordModel extends PostgresqlController
{

    private $pdo;

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
        
        $pdo = $this->pdo;
        
        $this->insertStmt = $pdo->prepare(
                "insert into cinemaHall (idHall, cinemaName, seatHall) values (?, ?, ?)"
	);
        
        $this->updateStmt = $pdo->prepare(
                "update cinemaHall set idHall = ?, cinemaName = ?, seatHall = ? where id = ?"
        );

        $this->selectStmt = $pdo->prepare(
                "select id, idHall, cinemaName, seatHall from cinemaHall where id = ?"
        );
        
        $this->deleteStmt = $pdo->prepare("delete from cinemaHall where id = ?");
        
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
   
    public function update(): bool
    {
	return $this->updateStmt->execute([
	    $this->idHall,
    	    $this->cinemaName,
            $this->seatHall,
	    $this->id
	]);
    }

    public function select(): array
    {
	$id = $this->id;
	$this->selectStmt->execute([$id]);
	return $this->selectStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(): bool
    {
	$id = $this->id;
	return $this->deleteStmt->execute([$id]);
    }

}
