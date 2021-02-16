<?php


namespace Otushw;


/**
 * Class ContentWatcher
 *
 * @package Otushw
 */
class ContentWatcher
{
    /**
     * @var array
     */
    private array $all = [];

    /**
     * @var null
     */
    private static $instance = null;

    /**
     * ContentWatcher constructor.
     */
    private function __construct() { }

    /**
     * @return ContentWatcher
     */
    public static function instance(): ContentWatcher
    {
        if (is_null(self::$instance)) {
            self::$instance = new ContentWatcher();
        }
        return self::$instance;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    private function getKey(int $id): string
    {
        return Content::class . '.' . $id;
    }

    /**
     * @param Content $content
     */
    public static function store(Content $content)
    {
        $instance = self::instance();
        $key = $instance->getKey($content->getId());
        $instance->all[$key] = $content;
    }

    /**
     * @param int $id
     *
     * @return Content|null
     */
    public static function getItem(int $id): ?Content
    {
        $instance = self::instance();
        $key = $instance->getKey($id);
        if (isset($instance->all[$key])) {
            return $instance->all[$key];
        }

        return null;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public static function remove(int $id): bool
    {
        $instance = self::instance();
        $key = $instance->getKey($id);
        if (isset($instance->all[$key])) {
            unset($instance->all[$key]);
            return true;
        }
        return false;
    }
}