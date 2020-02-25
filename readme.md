В качестве примера рассмотрим один мой старый проект, который не дожил до стадии продакшн.
###1. Уменьшение сложности иерархии
Диаграмма классов в файле `Static Structure diagram.png`. В прежней структуре проекта была иерархия из 3 классов контроллеров: FOSRestController -> ParentController -> реализации конкретных контроллеров. Я предлагаю исключить из этой иерархии ParentController, а protected-методы выделить в трейты. Это позволит понизить уровень иерархии, убрать обязательное наследование класса ParentController и повысит переиспользуемость методов проверки аутентификации.

###2. Кодстайл
Внедрим соблюдение PSR-2 и PSR-12. Таким образом код
```    
    public function get_routes( $src_lat, $src_lng, $dst_lat, $dst_lng, $time, $all = true){
       $data['origin'] = $src_lat.','.$src_lng;
       $data['destination'] = $dst_lat.','.$dst_lng;
       $data['mode'] = 'driving';
       $data['alternatives'] = $all ? 'true' : 'false';
       $data['traffic_model'] = 'best_guess';
       $data['departure_time'] = empty($time) ? 'now' : $time;
       $data['key'] = $this->apiKey;
       $url = $this->baseUrl . '/directions/json?' . http_build_query($data);
       return json_decode($this->send($url), true);
    }
```
превратится в
```
    public function getRoutes($srcLat, $srcLng, $dstLat, $dstLng, $time = null, $all = true)
    {
        $data['origin'] = $srcLat . ',' . $srcLng;
        $data['destination'] = $dstLat . ',' . $dstLng;
        $data['mode'] = 'driving';
        $data['alternatives'] = $all ? 'true' : 'false';
        $data['traffic_model'] = 'best_guess';
        $data['departure_time'] = $time === null ? 'now' : $time;
        $data['key'] = $this->apiKey;
        $url = $this->baseUrl . '/directions/json?' . http_build_query($data);

        return json_decode($this->send($url), true);
    }
```
###3. Декомпозиция сервисов
Был класс
```
class Google
{
    private $apiKey;

    private $baseUrl = 'https://maps.googleapis.com/maps/api';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    protected function send($url)
    {
        //send http request
    }

    public function getLocationByLatLng(string $lat, string $lng)
    {
        //some code
    }

    public function getRoutes(string $srcLat, string $srcLng, string $dstLat, string $dstLng, string $time = null, bool $all = true)
    {
        //some code
    }
}
```
Хорошей практикой будет инъекция в него класса-клиента HTTP (например GuzzleHttpClient). В этот класс мы выделим ответственность - отправка http-запросов ко внешним сервисам и получение ответов от них. Придерживаемся сразу 2 принципов - SRP и DIP. Получим примерно такой код
```
use GuzzleHttp\Client;

final class GoogleApiProvider
{
    /**
     * @var Client
     */
    private $client;

    private $apiKey;

    private $baseUrl = 'https://maps.googleapis.com/maps/api';

    public function __construct(Client $client, string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    public function getLocationByLatLng(string $lat, string $lng)
    {
        //some code
    }

    public function getRoutes(string $srcLat, string $srcLng, string $dstLat, string $dstLng, string $time = null, bool $all = true)
    {
        //some code
    }
}
```

###4. Внедрение шаблонов проектирования
Ещё одной важной доработкой будет внедрение паттерна "Абстрактная фабрика". Вместо самостоятельных классов реализации платежных систем создадим интерфейс и порождающий класс - фабрику.
Было так:
```
namespace AppBundle\Service\PaymentSystems;

class CloudPaymentsProvider
{
    public function __construct() {
        //some code
    }

    //some mandatory methods
}
```
Стало так:
```
namespace AppBundle\Service\PaymentSystems;

interface PaymentSystemInterface
{
    //some mandatory methods signatures
}
```
```
namespace AppBundle\Service\PaymentSystems;

final class CloudPaymentsProvider implements PaymentSystemInterface
{
    //implementation of mandatory methods
}
```
```
namespace AppBundle\Service\PaymentSystems;

use AppBundle\Service\PaymentSystems\Exception\UnknownPaymentSystemException;

class PaymentSystemsFactory
{
    private $paymentSystems = [];

    public function __construct(array $paymentSystems)
    {
        $this->paymentSystems = $paymentSystems;
    }

    public function createPaymentSystem(string $paymentSystemName): PaymentSystemInterface
    {
        $paymentSystemName = strtolower($paymentSystemName);
        if (!isset($this->paymentSystems[$paymentSystemName])) {
            throw new UnknownPaymentSystemException("Payment system $paymentSystemName not found");
        }

        return $this->paymentSystems[$paymentSystemName];
    }

    public function getPossiblePaymentSystemsNames(): array
    {
        return array_keys($this->paymentSystems);
    }
}
```