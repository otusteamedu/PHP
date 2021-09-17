<?php


namespace VideoPlatform\traits;
use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;

trait RequestTrait
{
    /**
     * @param string $method
     * @param $url
     * @param array $data
     * @return array|mixed
     * @throws GuzzleException
     */
    public function sendRequest(string $method, $url, $data = [])
    {
        try {
            $client = new GuzzleHttp\Client();
            $result = $client->request($method, $url, $data);
            return !empty($result) ? json_decode($result->getBody(), true) : [];
        }catch (\Exception $e){
            http_response_code($e->getCode());
            throw $e;
        }
    }
}
