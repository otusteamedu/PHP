<?php


namespace App;


use App\Validator\BracesValidator;

class App
{
    private $path;
    private string $method;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }


    public function run()
    {
        if ($this->method === 'POST' && $this->path === '/') {
            $this->postHandler();
        } else {
            $this->index();
        }

    }

    private function index()
    {
        phpinfo();
        xdebug_info();
    }

    private function postHandler()
    {
        $validator = new BracesValidator();

        if (isset($_POST['string'])) {
            $braces = $_POST['string'];

        } else {
            $data = file_get_contents('php://input');

            list($key, $braces) = explode('=', $data);

            if ($key !== 'string') {
                $this->badRequest('Wrong format');
                return;
            }
        }

        if (! $validator->validate($braces)) {
            $this->badRequest(implode(PHP_EOL, $validator->getErrors()));
            return;
        }

        echo 'All good';
    }

    private function badRequest($msg)
    {
        header('Bad request', true, 400);
        echo $msg, PHP_EOL;
        echo 'All bad';
    }


}
