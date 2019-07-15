<?php


namespace Otus\Basic;


/**
 * Class Request
 * @package Otus\Basic
 */
class Request
{
    /**
     * @return string
     */
    public function getPathInfo()
    {
        $path_info = parse_url(($_SERVER['REQUEST_URI']), PHP_URL_PATH);
        $path_info = trim($path_info, '/');
        return empty($path_info) ? '/' : $path_info;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if ($this->has($key))
            return $_REQUEST[$key];
        else
            return $default;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return key_exists($key, $_REQUEST);
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $_POST;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $_GET;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        if (isset($_POST)) {
            return true;
        }
        return false;
    }
}