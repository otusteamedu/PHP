<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 06.01.21
 * Time: 16:26
 */

namespace WorkloadPhpFpm;


class WorkloadPhpFpm
{

    public function __construct()
    {
        echo "<form action='/' method='post'>
                <input name='count_users' placeholder='Число фейковых соединений'>
                <br/>
                <input type='submit' value='Посетить'>
              </form>";

    }

    /**
     * @param int $count
     */
    public function review (int $count)
    {
        $start = microtime(true);

        $url = self::getUrl();

        //создаем набор дескрипторов cURL
        $mh = curl_multi_init();
        $ch = array();

        for (;$count > 0; $count--) {
            $ch[$count] = curl_init();
            curl_setopt($ch[$count], CURLOPT_URL, $url);
            curl_setopt($ch[$count], CURLOPT_HEADER, 0);
            curl_multi_add_handle($mh, $ch[$count]);
        }

        //запускаем множественный обработчик
        do {
            $status = curl_multi_exec($mh, $active);
            if ($active) {
                curl_multi_select($mh);
            }
        } while ($active && $status == CURLM_OK);

        foreach ($ch as $elem) {
            curl_multi_remove_handle($mh, $elem);
        }

        curl_multi_close($mh);

        $finish = microtime(true);
        $delta = $finish - $start;
        echo $delta . ' сек.';
    }

    public function getUrl() {
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        return $url[0];
    }
}