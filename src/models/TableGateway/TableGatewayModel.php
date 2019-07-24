<?
declare(strict_types = 1);

namespace Paa\Models\TableGateway;

use Paa\App\PostgresqlController;

use PDO;
use PDOStatement;
use PDOException;

class TableGatewayModel extends PostgresqlController
{

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
    
    public function select(int $id)
    {
	$this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        return $this->selectStmt->fetch();
    }

    public function insert(int $idHall, string $cinemaName, int $seatHall)
    {
	$this->insertStmt->execute([ $idHall, $cinemaName, $seatHall ]);
        return $this->pdo->lastInsertId();
    }

    public function update(int $id, int $idHall, string $cinemaName, int $seatHall): bool {
	$this->updateStmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $this->updateStmt->execute([ $idHall, $cinemaName, $seatHall,  $id ]);
    }
                                                                                                                                                                                
    public function delete(int $id): bool
    {
	return $this->deleteStmt->execute([$id]);
    }
                                                                                                                                                                        

}
