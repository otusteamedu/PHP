<?php

namespace Classes;

class ClientSocketDataBuilder {

    private $domainClientSocketFilePath;
    private $domainServerSocketFilePath;
    private $maxByteForRead;
    private $protocolFamilyForSocket;
    private $typeOfDataExchange;
    private $protocol;
    private $error;

    public function setDomainClientSocketFilePath($domainClientSocketFilePath) {
        $this->domainClientSocketFilePath = $domainClientSocketFilePath;
        return $this;
    }

    public function setDomainServerSocketFilePath($domainServerSocketFilePath)
    {
        $this->domainServerSocketFilePath = $domainServerSocketFilePath;
        return $this;
    }

    public function setMaxByteForRead($maxByteForRead) {
        $this->maxByteForRead = $maxByteForRead;
        return $this;
    }
    public function setProtocolFamilyForSocket($protocolFamilyForSocket) {
        $this->protocolFamilyForSocket = $protocolFamilyForSocket;
        return $this;
    }

    public function setTypeOfDataExchange($typeOfDataExchange) {
        $this->typeOfDataExchange = $typeOfDataExchange;
        return $this;
    }

    public function setProtocol($protocol) {
        $this->protocol = $protocol;
        return $this;
    }

    public function built() {
        $this->validate();
        if (!empty($this->error)) {
            throw new \RuntimeException(implode(';' , $this->error));
        }
        return new SocketClient($this, new SocketLogger());
    }
    private function validate() {

        if (empty($this->domainClientSocketFilePath)) {
            $this->error[] = 'Не передан путь к файлу клиента доменного сокета Unix';
        }

        if (empty($this->domainServerSocketFilePath)) {
            $this->error[] = 'Не передан путь к файлу сервера доменного сокета Unix';
        }

        if (empty($this->maxByteForRead)) {
            $this->error[] = 'Не задано максимальное количество байт для чтения';
        }

        if (!is_numeric($this->maxByteForRead)) {
            $this->error[] = 'Максимальное количество байт для чтения должно быть числом';
        }

        if (empty($this->protocolFamilyForSocket)) {
            $this->error[] = 'Не задано семейство протоколов, используемых сокетами';
        }

        if (!is_numeric($this->protocolFamilyForSocket)) {
            $this->error[] = 'семейство протоколов, используемых сокетами должно быть числом';
        }

        if (empty($this->typeOfDataExchange)) {
            $this->error[] = 'Не задан тип обмена данными, который будет использоваться сокетом';
        }

        if (!is_numeric($this->typeOfDataExchange)) {
            $this->error[] = 'Тип обмена данными, который будет использоваться сокетом должно быть числом';
        }

    }

    public function getDomainClientSocketFilePath() {
        return $this->domainClientSocketFilePath;
    }

    public function getDomainServerSocketFilePath() {
        return $this->domainServerSocketFilePath;
    }

    public function getMaxByteForRead() {
        return $this->maxByteForRead;
    }

    public function getProtocolFamilyForSocket() {
        return $this->protocolFamilyForSocket;
    }

    public function getTypeOfDataExchange() {
        return $this->typeOfDataExchange;
    }

    public function getProtocol() {
        return $this->protocol;
    }

}
