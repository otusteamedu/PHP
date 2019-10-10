<?php
declare(strict_types = 1);

namespace Alex\Youtubestat;

class Helpers
{

    private $config;

    private $httpCodes = [
        '100' => 'Continue',
        '101' => 'Switching Protocol',
        '102' => 'Processing',
        '103' => 'Early Hints',
        '200' => 'OK',
        '201' => 'Created',
        '202' => 'Accepted',
        '203' => 'Non-Authoritative Information',
        '204' => 'No Content',
        '205' => 'Reset Content',
        '206' => 'Partial Content',
        '300' => 'Multiple Choice',
        '301' => 'Moved Permanently',
        '302' => 'Found',
        '303' => 'See Other',
        '304' => 'Not Modified',
        '305' => 'Use Proxy',
        '306' => 'Switch Proxy',
        '307' => 'Temporary Redirect',
        '308' => 'Permanent Redirect',
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '402' => 'Payment Required',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '405' => 'Method Not Allowed',
        '406' => 'Not Acceptable',
        '407' => 'Proxy Authentication Required',
        '408' => 'Request Timeout',
        '409' => 'Conflict',
        '410' => 'Gone',
        '411' => 'Length Required',
        '412' => 'Precondition Failed',
        '413' => 'Request Entity Too Large',
        '414' => 'Request-URI Too Long',
        '415' => 'Unsupported Media Type',
        '416' => 'Requested Range Not Satisfiable',
        '417' => 'Expectation Failed',
        '500' => 'Internal Server Error',
        '501' => 'Not Implemented',
        '502' => 'Bad Gateway',
        '503' => 'Service Unavailable',
        '504' => 'Gateway Timeout',
        '505' => 'HTTP Version Not Supported'
    ];

    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * @param $method
     * @return array
     */
    public function getFormData(string $method) {

        // if GET or POST: return data
        if ($method === 'GET') return $_GET;
        if ($method === 'POST') return $_POST;

        // PUT, PATCH or DELETE
        $data = array();
        $exploded = explode('&', file_get_contents('php://input'));

        foreach($exploded as $pair) {
            $item = explode('=', $pair);
            if (count($item) == 2) {
                $data[urldecode($item[0])] = urldecode($item[1]);
            }
        }

        return $data;
    }

    /**
     * @param string $type
     * @param string $id
     * @return string
     */
    public function queueAdd(string $type, string $id)
    {
        $redis = new \Redis();
        $redis->pconnect($this->config->redis_host, $this->config->redis_port);

        $range = $redis->lRange($type, 0, -1);

        $length = mt_rand(10, 20);
        $resultId = $this->generateRandomString($length);
        while(in_array($resultId, $range)) {
            $length = mt_rand(10, 20);
            $resultId = $this->generateRandomString($length);
        }

        $data4save = json_encode(['id' => $id, 'resultId' => $resultId]);

        $redis->rPush($type, $data4save);

        $redis->close();

        return $resultId;

    }

    /**
     * @param string $id
     * @return bool|string
     */
    public function queueGet(string $id)
    {
        $redis = new \Redis();
        $redis->pconnect($this->config->redis_host, $this->config->redis_port);

        $data = $redis->get($id);

        $redis->close();

        return $data;
    }

    /**
     * @param int $length
     * @return string
     */
    public function generateRandomString(int $length = 15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param int $code
     * @param array $data
     */
    public function sendResponse(int $code,array $data = [])
    {
        header('HTTP/1.1 ' . $code . ' ' . $this->httpCodes[$code]);
        echo json_encode($data);
    }

}