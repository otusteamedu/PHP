<?php
use App\Factory;
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

/**
 * Class App
 */
class App
{
    /**
     * @throws ErrorException
     */
    public static function init()
    {
        $command = explode("/", $_SERVER['REQUEST_URI']);
        $factory = new Factory();
        switch ($command[1]) {
            case 'send':
                if(isset($_POST['products'])
                    &&isset($_POST['type'])
                    &&isset($_POST['client'])
                    &&isset($_POST['coupon'])
                    &&isset($_POST['deliveryService'])){
                    $post=[
                        'products'=>$_POST['products'],
                        'type'=>(int)$_POST['type'],
                        'client'=>(int)$_POST['client'],
                        'coupon'=>(int)$_POST['coupon'],
                        'deliveryService'=>(int)$_POST['deliveryService']
                    ];
                    $post_json=json_encode($post);
                    $rpc= $factory->create('SendQueueRpcClient');
                    $response = $rpc->call($post_json);
                    echo ' уникальный номер заказа  ', $response, "\n";
                }else{
                   echo 'неправильный запрос ';

                }
                return;
            case 'find':
                if(isset($_POST['name'])) {
                    $Order = $factory->create('Order')->findByName($_POST['name']);
                    if($Order->getName() ){
                        echo 'ваш заказ сохранен!!! ваш номер '.$Order->getName().'!!!';
                    }else{
                        echo 'ваш заказ не сохранен!!!';
                    }
                }else{
                    echo 'неверный запрос';
                }
                return;
            default:
                return;
        }

    }
}
