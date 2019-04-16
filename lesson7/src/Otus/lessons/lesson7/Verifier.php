<?php

namespace Otus\Lessons\Lesson7;


class Verifier
{

    private $mails = array();
    private $result = array();

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
                    $this->result[$mail]['checked'] = true;
                    $this->result[$mail]['MX'] = $mxHosts;
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
}