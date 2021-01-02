<?php

namespace RoistatToActiveCampaign\traits;
trait curlConnector {

    private $curlConnection;
    private $basicOptions;


    private function initConnection() {
        $this->curlConnection = curl_init();
        $this->setBasicOptions();
    }

    private function setBasicOptions() {
        $this->basicOptions = array(
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1
        );
    }


    private function setOptions($options) {
        foreach ($options as $optionName => $optionValue) {
            curl_setopt($this->curlConnection,$optionName,$optionValue);
        }
    }

    private function returnResult() : string {
        $output = curl_exec($this->curlConnection);
        curl_close($this->curlConnection);

        return json_decode($output,1);
    }

    public function getContent($url,$httpHeaders) {
        $this->initConnection();

        $options = array_merge($this->basicOptions,array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $httpHeaders,

        ));

        $this->setOptions($options);

        return $this->returnResult();
    }

    public function setContent($url, $httpHeaders, $params) {

        $this->initConnection();

        $options = array_merge($this->basicOptions,array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $httpHeaders,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_POST => true

        ));

        $this->setOptions($options);

        return $this->returnResult();
    }

    public function putContent($url, $httpHeaders, $params) {

        $this->initConnection();

        $options = array_merge($this->basicOptions,array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $httpHeaders,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => "PUT"

        ));

        $this->setOptions($options);

        return $this->returnResult();
    }

}
