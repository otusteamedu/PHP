<?php
include_once 'vendor/autoload.php';
$router = new \Tirei01\Hw12\Router($_SERVER['REQUEST_URI']);
$router->addRule('#^\/admin\/(?P<controller>[a-z]+)\/(?P<action>[a-z]+)\/(?P<id>[0-9]+)\/?#', ['model' => 'Tirei01\Hw12\Mvc\Model\Admin', 'action' => 'index']);
$router->addRule('#^\/admin\/(?P<controller>[a-z]+)\/?#', ['model' => 'Tirei01\Hw12\Mvc\Model\Admin', 'action' => 'index']);
$router->addRule('#/admin/#', array('model' => 'Tirei01\Hw12\Mvc\Model\Admin', 'controller' => 'admin'));
$router->addRule('#/#', array('model' => 'Tirei01\Hw12\Mvc\Model\Admin', 'controller' => 'admin'));
try {
   echo $router->run();
}catch (Exception $e){
    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    echo $e->getMessage();
    echo "</pre>";
}