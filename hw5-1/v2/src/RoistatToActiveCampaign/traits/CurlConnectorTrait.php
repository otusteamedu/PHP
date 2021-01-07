<?php

namespace RoistatToActiveCampaign\traits;

trait CurlConnectorTrait {

    private $curlConnection;
    private $basicOptions;
    private $baseUrl;
    private $additionalHeaders;

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function setAdditionalHeaders($headers)
    {
        $this->additionalHeaders = $headers;
    }


    public function getContent(string $url,array $httpHeaders = array()) : array
    {
        $this->initConnection();

        $options = $this->prepareConnection(array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $httpHeaders
        ));

        $this->setOptions($options);

        return $this->returnResult();
    }

    public function setContent(string $url,array $httpHeaders = array(),array $params = array())
    {
        $this->initConnection();

        $options = $this->prepareConnection(array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $httpHeaders,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_POST => true

        ));

        $this->setOptions($options);

        return $this->returnResult();
    }

    public function putContent(string $url, array $httpHeaders = array(), array $params = array())
    {
        $this->initConnection();

        $options = $this->prepareConnection(array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $httpHeaders,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => "PUT"

        ));

        $this->setOptions($options);

        return $this->returnResult();
    }

    private function prepareConnection($options)
    {
        $resultOptions = array();
        foreach ($this->basicOptions as $basicOption => $value) {
            $resultOptions[$basicOption] = $value;
        }
        foreach ($options as $option => $value) {
            $resultOptions[$option] = $value;
        }

        return $resultOptions;
    }

    private function initConnection()
    {
        $this->curlConnection = curl_init();
        $this->setBasicOptions();
    }

    private function setBasicOptions()
    {
        $this->basicOptions = array(
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1
        );
    }


    private function setOptions($options)
    {
        foreach ($options as $optionName => $optionValue) {

            if(isset($this->baseUrl) && $optionName == CURLOPT_URL) {
                $optionValue = $this->baseUrl . $optionValue;
            }

            curl_setopt($this->curlConnection,$optionName,$optionValue);
        }
    }

    private function returnResult() : array
    {
        if(isset($this->additionalHeaders) ) {
            curl_setopt($this->curlConnection,CURLOPT_HTTPHEADER, $this->additionalHeaders);
        }

        $output = curl_exec($this->curlConnection);
        curl_close($this->curlConnection);

        if(!strlen($output)) {
            throw new \Exception('response from crm is not valid');
        }

        return json_decode($output,1);
    }

}
