<?
declare(strict_types = 1);

namespace Paa\Models\RowGateway;

use Paa\App\PostgresqlController;

use PDO;
use PDOStatement;
use PDOException;

class RowGatewayFinderModel extends PostgresqlController
{

    private $id;
    private $idHall;
    private $cinemaName;
    private $seatHall;

    private $selectStmt;

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
        
        $this->selectStmt = $this->pdo->prepare(
                'select "id", "idHall", "cinemaName", "seatHall" from "cinemaHall" where "id" = ?'
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
   
    public function select(int $id)
    {
	$this->selectStmt->execute([$id]);
	return $this->selectStmt->fetchAll();
    }


}
