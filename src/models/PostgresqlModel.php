<?
namespace Paa\Models;

use Paa\App\PostgresqlController;

class PostgresqlModel extends PostgresqlController
{
    public function __construct() 
    {
	global $config;
        $this->pdo = parent::__construct();
    }
    
    public function insertMess(string $msgText = '') {
	$msgUnique = md5(microtime(true).mt_Rand());
        $this->pdo->prepare('insert into "feedback" ("msgText", "msgDate", "msgAnswer", "msgStatus", "msgUnique") values (?, current_timestamp, \'\', 0, ?)')->execute([$msgText, $msgUnique]);
    }

    public function selectMess() {
	$this->selectStmt = $this->pdo->prepare('select "msgText", "msgDate", "msgAnswer", "msgStatus" from "feedback" where "msgStatus" = 1 order by "msgDate" desc');
	$this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute();
        return $this->selectStmt->fetchAll();
    }

    public function selectMessNew() {
	$this->selectStmt = $this->pdo->prepare('select "id", "msgText", "msgDate", "msgAnswer", "msgStatus" from "feedback" where "msgStatus" = 0 order by "msgDate" desc');
	$this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute();
        return $this->selectStmt->fetchAll();
    }

    public function updateMess(int $msgId = 0, string $msgAnswer = '', int $msgStatus = 0) {
	$this->selectStmt = $this->pdo->prepare('update "feedback" set "msgAnswer" = ?, "msgStatus" = ? where "id" = ?');
        return $this->selectStmt->execute([$msgAnswer, $msgStatus, $msgId]);
    }


}
