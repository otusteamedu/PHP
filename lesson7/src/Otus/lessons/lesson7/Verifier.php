<?php

namespace Otus\Lessons\Lesson7;


class Verifier
{

    private $mails = array();
    private $result = array();
    private $_connection = null;

    const SMTP_CONNECT_SUCCESS = 220;
    const SMTP_QUIT_SUCCESS    = 221;
    const SMTP_GENERIC_SUCCESS = 250;

    /**
     * Verifier constructor.
     * @param array $mails
     */
    public function __construct($mails = array())
    {
        $this->mails = array_unique(is_array($mails) ? $mails : array($mails));
    }

    /**
     * Get list of mails
     *
     * @return array
     */
    public function getMails(): array
    {
        return $this->mails;
    }

    /**
     * Set array of mails or one mail by string
     * WARNING!!!
     * All old mails will be override
     *
     * @param $mails
     * @return array
     */
    public function setMails($mails): array
    {
        $this->mails = array_unique(is_array($mails) ? $mails : array($mails));
        return $this->mails;
    }

    /**
     * Add single mail by string or array of mails
     *
     * @param $mails
     * @return array
     */
    public function addMails($mails): array
    {
        $preparedMails = is_array($mails) ? $mails : array($mails);
        $this->mails = array_unique(array_merge($this->mails, $preparedMails));
        return $this->mails;
    }

    /**
     * Remove single mail from string or array of mails
     *
     * @param $mails
     * @return array
     */
    public function removeMails($mails): array
    {
        $preparedMails = is_array($mails) ? $mails : array($mails);
        $this->mails = array_diff($this->mails, $preparedMails);
        return $this->mails;
    }

    /**
     * Get result
     *
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * Clear result
     *
     * @return array
     */
    public function clearResult(): array
    {
        $this->result = array();
        return $this->result;
    }

    /**
     * Clear mails
     *
     * @return array
     */
    public function clearMails(): array
    {
        $this->mails = array();
        return $this->mails;
    }

    /**
     * Verifying e-mails
     */
    public function verify()
    {
        if ($this->result) {
            $this->clearResult();
        }
        if (count($this->mails) > 0) {
            foreach ($this->mails as $mail) {
                try {
                    $this->checkMailString($mail);
                    $mxHosts = $this->checkMXDomain($mail);
                    $this->checkResponse($mail, $mxHosts);
                    $this->result[$mail]['checked'] = true;
                } catch (\Exception $e) {
                    $this->result[$mail]['error'] = 'Fail: ' . $e->getMessage();
                    $this->result[$mail]['checked'] = false;
                }
            }
        }
    }

    /**
     * Checking mail by regexp
     *
     * @param string $mail
     * @throws \Exception
     */
    private function checkMailString(string $mail)
    {
        $stringValidate = preg_match('/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)*?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i', $mail);
        if (!$stringValidate) {
            throw new \Exception('Validation problem, "' . $mail . '"" looks not like e-mail');
        }
    }

    /**
     * Watching MX domains by mail
     *
     * @param string $mail
     * @return array
     * @throws \Exception
     */
    private function checkMXDomain(string $mail): array
    {
        $hostname = substr($mail, strrpos($mail, '@') + 1);
        $mxHosts = array();
        $check = getmxrr($hostname, $mxHosts);
        if (!$check) {
            throw new \Exception("No MX from Domain '$hostname'");
        }
        return $mxHosts;
    }

    /**
     * Connecting to SMTP and check if mail exists
     *
     * @param string $mail
     * @param array $mxHosts
     * @throws \Exception
     */
    private function checkResponse(string $mail, array $mxHosts)
    {
        foreach ($mxHosts as $host) {
            try {
                $this->makeConnection($host);
                $this->ehlo();
                $this->mailFrom();
                $this->rcpt($mail);
                $this->reset();
                $this->quit();
                $this->closeConnection();
                return;
            } catch (\Exception $e) {
                $this->result[$mail][$host] = 'Error: ' . $e->getMessage();
            }
        }
        throw new \Exception("No mail <$mail> in " . implode(', ', $mxHosts));
    }

    /**
     * Connect to SMTP
     *
     * @param $host
     * @throws \Exception
     */
    private function makeConnection($host)
    {
        $connection = fsockopen($host, 25, $errCode, $errStr, 10);
        if (!$connection) {
            throw new \Exception("($host): Error: $errCode, message: $errStr.");
        }
        $this->_connection = $connection;
        $this->getResponseFromSocket(self::SMTP_CONNECT_SUCCESS);
    }

    /**
     * Close connection
     */
    private function closeConnection()
    {
        fclose($this->_connection);
        $this->_connection = null;
    }

    /**
     * Sending EHLO command
     *
     * @throws \Exception
     */
    private function ehlo()
    {
        $this->send("EHLO user.domain");
        $this->getResponseFromSocket(self::SMTP_GENERIC_SUCCESS);
    }

    /**
     * Setting Mail from
     *
     * @throws \Exception
     */
    private function mailFrom()
    {
        $this->send("MAIL FROM:<user@domain.local>");
        $this->getResponseFromSocket(self::SMTP_GENERIC_SUCCESS);
    }

    /**
     * Setting mail to
     *
     * @param $mail
     * @throws \Exception
     */
    private function rcpt($mail)
    {
        $this->send("RCPT TO:<$mail>");
        $this->getResponseFromSocket(self::SMTP_GENERIC_SUCCESS);
    }

    /**
     * Resetting data on SMTP
     *
     * @throws \Exception
     */
    private function reset()
    {
        $this->send("RSET");
        $this->getResponseFromSocket(self::SMTP_GENERIC_SUCCESS);
    }

    /**
     * Logout from SMTP
     *
     * @throws \Exception
     */
    private function quit()
    {
        $this->send("QUIT");
        $this->getResponseFromSocket(self::SMTP_QUIT_SUCCESS);
    }

    /**
     * Sending commands to SMTP
     *
     * @param $cmd
     * @throws \Exception
     */
    private function send($cmd)
    {
        if (!$this->_connection) {
            throw new \Exception('Connection error.');
        }
        $result = fputs($this->_connection, $cmd . "\r\n");;
        if (false === $result) {
            throw new \Exception('Send failed on "' . $cmd . '"');
        }
    }

    /**
     * Reading response
     *
     * @param $expected
     * @return string
     * @throws \Exception
     */
    private function getResponseFromSocket($expected): string
    {
        if (!$this->_connection) {
            throw new \Exception('Connection error.');
        }


        $code = null;
        $text = '';

        try {
            $line = $this->getLine();
            $text = $line;
            while (preg_match('/^[0-9]+-/', $line)) {
                $line = $this->getLine();
                $text .= $line;
            }
            sscanf($line, '%d', $code);
            if ($code != $expected) {
                throw new \Exception($text);
            }
        } catch (\Exception $e) {
            $this->closeConnection();
            throw new \Exception($e->getMessage());
        }
        return $text;
    }

    /**
     * Getting response
     *
     * @return bool|string
     * @throws \Exception
     */
    private function getLine()
    {
        $line = fgets($this->_connection, 512);
        if (!$line) {
            throw new \Exception('No data');
        }
        return $line;
    }

}