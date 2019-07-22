<?
namespace Paa\Models;

use Paa\App\PostgresqlController;

class PostgresqlModel extends PostgresqlController
{

    public function __construct() 
    {
	global $config;
        $this->pdo = parent::__construct();
        print_r($this->pdo);
        
    }


}
