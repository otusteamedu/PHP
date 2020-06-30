<?php
namespace Otus\RYakubov;

class Config {
    const CONFIG_FILE = 'config.ini';

    static function getSocketName() {
        return self::_getValue('unix_socket_file');
    }

    static function getResponseSocketName() {
        return self::_getValue('unix_response_socket_file');
    }

    /**
     * @param string $configField
     * @return bool|mixed
     */
    protected static function _getValue(string $configField) {
        $arIni = parse_ini_file(self::CONFIG_FILE);

        if ($arIni[$configField] == null) {
            return false;
        }

        return $arIni[$configField];
    }
}
