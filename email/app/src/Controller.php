<?php

namespace Marchenko;

class Controller
{
    private $context;

    public function __construct(array $list)
    {
        $this->context = new RuleContext($list);
    }

    public function process()
    {
        $basePath = __DIR__ . DIRECTORY_SEPARATOR . RuleFactory::getDir();
        $files = scandir($basePath);
        $excludeDir = ['.', '..'];

        $result = [];

        foreach ($files as $file) {
            if (in_array($file, $excludeDir)) {
                continue;
            }

            try {
                $rule = RuleFactory::getRule($file);
                $rule->execute($this->context);
                $result = $this->context->getResult();
                if (!empty($old_result)) {
                    foreach ($result as $email => $flag) {
                        $result[$email] = $old_result[$email] && $flag;
                    }
                }
                $old_result = $result;

            } catch (\Exception $e) {
                $view = new View([$e->getMessage()]);
                $view->render($type = 'error');
                exit();
            }
        }
        $view = new View($result);
        $view->render($type = 'default');
    }
}
