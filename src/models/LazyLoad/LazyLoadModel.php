<?
declare(strict_types = 1);

namespace Paa\Models\LazyLoad;

use Paa\App\PostgresqlController;

use PDO;
use PDOStatement;
use PDOException;

class LazyLoadModel extends PostgresqlController
{
    private $selectStmt;

    public function __construct(bool $lazy = false) 
    {
	$this->lazy = $lazy;

        $this->pdo = parent::__construct();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        

        $this->selectStmt = $this->pdo->prepare(
                'SELECT "af"."id" AS "ID", "af"."filmName" AS "Film Name" FROM "allFilms" AS "af" INNER JOIN "filmsAttributesList" AS "fal1" ON "af"."id" = "fal1"."filmId" WHERE "af"."id" = ?'
        );

        $this->selectStmtLazy = $this->pdo->prepare(
                'SELECT "af"."id" AS "ID", "af"."filmName" AS "Film Name" FROM "allFilms" AS "af" WHERE "af"."id" = ?'
        );
        
    }
    
    public function select(int $id): array
    {
	if ($this->lazy) {
	    $query = $this->selectStmt;
	} else {
	    $query = $this->selectStmtLazy;
	}
		
        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->execute([$id]);
	return $query->fetch();

    }

}
