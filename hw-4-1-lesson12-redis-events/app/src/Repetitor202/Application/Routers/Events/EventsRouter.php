<?php


namespace Repetitor202\Application\Routers\Events;


use Repetitor202\Application\Routers\IRouter;
use Repetitor202\Domain\Services\Events\EventServise;

abstract class EventsRouter implements IRouter
{
    private const TYPE_SEARCH = 'search';
    private const TYPE_SAVE = 'save';
    private const TYPE_CLEAN = 'clean';

    public static function run(int $argvNumber = 1): void
    {
        $service = new EventServise();

        if(isset($_GET) && isset($_GET[self::TYPE_SEARCH])) {
            unset($_GET[self::TYPE_SEARCH]);
            $service->search($_GET);
        } elseif (isset($_POST) && isset($_POST['action'])) {
            $action = $_POST['action'];
            unset($_POST['action']);

            switch ($action) {
                case self::TYPE_SAVE:
                    $service->save($_POST);
                    break;
                case self::TYPE_CLEAN:
                    $service->clean();
                    break;
                default:
                    throw (new \Exception('Bad request!'));
            }
        } else {
            throw (new \Exception('Bad request!'));
        }
    }
}