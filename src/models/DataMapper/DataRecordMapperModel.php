<?
declare(strict_types = 1);

namespace Paa\Models\DataMapper;

use Paa\App\PostgresqlController;

use PDO;
use PDOStatement;
use PDOException;

class DataRecordMapperModel extends PostgresqlController
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

    public function update(DataRecordModel $datarecordmodel) : bool
    {
	return $this->updateStmt->execute([
	    $datarecordmodel->getIdHall(),
    	    $datarecordmodel->getCinemaName(),
            $datarecordmodel->getSeatHall(),
	    $datarecordmodel->getId()
	]);
    }

    public function select(int $id) : DataRecordModel
    {
	$this->selectStmt->execute([$id]);
	$result = $this->selectStmt->fetch();
	
	return new DataRecordModel ( 
	    $result['id'],
	    $result['idHall'],
	    $result['cinemaName'],
	    $result['seatHall']
	);
    }

    public function delete(int $id): bool
    {
	return $this->deleteStmt->execute([$this->id]);
    }

}
