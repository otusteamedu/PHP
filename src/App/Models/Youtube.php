<?php
namespace Ozycast\App\Models;

use Exception;

Class Youtube
{
    /**
     * Данные канала
     * @param $id
     * @return mixed|null
     * @throws Exception
     */
    public static function getChannel($id)
    {
        $answer = self::exec('channels', [
            'part' => 'snippet',
            'id' => $id,
        ]);

        if (empty($answer->items))
            return null;

        return $answer->items[0];
    }

    /**
     * Видео канала
     * @param $id
     * @param array $params
     * @return bool|mixed|string
     * @throws Exception
     */
    public static function getVideosForChannel($id, $params = [])
    {
        $params = array_merge($params, [
            'part' => 'snippet',
            'type' => "video",
            'channelId' => $id,
        ]);
        $answer = self::exec('search', $params);
        return $answer;
    }

    /**
     * Информация о видео
     * @param $id
     * @param array $params
     * @return bool|mixed|string
     * @throws Exception
     */
    public static function getVideo($id, $params = [])
    {
        $params = array_merge($params, [
            'type' => "video",
            'id' => $id,
        ]);
        $answer = self::exec('videos', $params);
        return $answer;
    }

    /**
     * Запрос на YouTube API
     * @param $path
     * @param $request
     * @return bool|mixed|string
     * @throws \Exception
     */
    public static function exec($path, $request)
    {
        $base_url = 'https://www.googleapis.com/youtube/v3/';
        $request['key'] = getenv('GOOGLE_API_KEY');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $base_url . $path . '?' . http_build_query($request));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error)
            throw new Exception($error);

        try {
            $result = json_decode($result);
        } catch (Exception $e) {
            throw new Exception('Error parsing');
        }

        if (isset($result->error))
            throw new Exception($result->error->message);

        return $result;
    }
}