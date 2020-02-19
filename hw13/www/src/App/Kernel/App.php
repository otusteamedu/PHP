<?php declare(strict_types=1);

namespace App\Kernel;

use App\Database\PsqlDatabaseConnection;
use App\Database\PsqlQueries;
use App\Repository\Repository;

class App
{
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var PsqlQueries
     */
    private $queries;
    /**
     * @var Request
     */
    private $request;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->pdo = (new PsqlDatabaseConnection)->connect();
        $this->queries = new PsqlQueries();
        $this->request = new Request();
    }

    public function run()
    {
        $repository = new Repository($this->pdo, $this->queries);
        $mapper = $repository->load($this->request->getEntity());

        // todo Router - Strategy

        // example
        $item = $mapper->findById((int) $this->request->get("id"));

        $view = new Response();
        $view->renderView(($item->getFirstName()));
        $view->send();
    }
}