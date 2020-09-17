<?php


namespace Source;

use \Controllers\Contracts\Curl;
use Exception\CardValidatorExceptions\CurlException;
use Exception\CardValidatorExceptions\CurlExceptionMessage;

class CurlRequest implements Curl
{
    private ?string $url;
    private array $data;

    public function __construct(?string $url = null, array $data = [])
    {
        $this->url = $url;
        $this->data = $data;
    }

    /**
     * Метод отправки запроса на внешний ресурс через Curl
     * @return string
     */
    public function send(): string
    {
        if ($this->url && !empty($this->data)) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            curl_close($ch);

        } else {
            Throw new CurlException(CurlExceptionMessage::VARIABLES_INCORRECT);
        }

        if ($httpCode === '403')
            Throw new CurlException(CurlExceptionMessage::ERROR_403);

        return $httpCode;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }
}