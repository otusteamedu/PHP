<?php

namespace crazydope\validation;

class EmailAddressValidator
    extends AbstractValidator
{
    protected const INVALID = 'The input is not a valid. String expected. ';
    protected const INVALID_FORMAT = 'The input is not a valid email address. ';
    protected const LENGTH_EXCEEDED = 'The input exceeds the allowed length. ';
    protected const DOT_ATOM = ' can not be matched against dot-atom format. ';
    protected const QUOTED_STRING = ' can not be matched against quoted-string format. ';
    protected const INVALID_LOCAL_PART = ' is not a valid local part for the email address. ';
    protected const INVALID_MX_RECORD = ' does not have any valid MX for the email address. ';
    protected const INVALID_HOSTNAME = ' is not a valid hostname for the email address. ';

    /**
     * @var string
     */
    protected $localPart;

    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var array
     */
    protected $mxRecord = [];

    /**
     * @return bool
     */
    protected function validateLocalPart(): bool
    {
        // Dot-atom: 1*text *("." 1*text)
        // text: ALPHA / DIGIT / "!", "#", "$", "%", "&", "'", "*",
        // "+", "-", "/", "=", "?", "^", "_", "`", "{", "|", "}", "~"
        $text = 'a-zA-Z0-9\x21\x23\x24\x25\x26\x27\x2a\x2b\x2d\x2f\x3d\x3f\x5e\x5f\x60\x7b\x7c\x7d\x7e';
        if ( preg_match('/^[' . $text . ']+(\x2e+[' . $text . ']+)*$/', $this->localPart) ) {
            return true;
        }

        // Quoted format
        // Quoted-string: DQUOTE *(text/quoted-pair) DQUOTE
        $text = '\x20-\x21\x23-\x5b\x5d-\x7e'; // %d32-33 / %d35-91 / %d93-126
        $quotedPair = '\x20-\x7e'; // %d92 %d32-126
        if ( preg_match('/^"([' . $text . ']|\x5c[' . $quotedPair . '])*"$/', $this->localPart) ) {
            return true;
        }

        $this->addError($this->localPart . self::DOT_ATOM);
        $this->addError($this->localPart . self::QUOTED_STRING);
        $this->addError($this->localPart . self::INVALID_LOCAL_PART);

        return false;
    }

    /**
     * @return bool
     */
    protected function validateMXRecords(): bool
    {
        $mxHosts = [];
        $weight = [];

        $result = getmxrr($this->hostname, $mxHosts, $weight);

        if ( !empty($mxHosts) && !empty($weight) ) {
            $this->mxRecord = array_combine($mxHosts, $weight) ?: [];
        }

        arsort($this->mxRecord);

        if ( !$result ) {
            $this->addError($this->hostname . self::INVALID_MX_RECORD);
        }

        return $result;
    }

    /**
     * @return bool
     */
    protected function validateHostnamePart(): bool
    {
        if ( !( new HostValidator )->isValid($this->hostname) ) {
            $this->addError($this->hostname . self::INVALID_HOSTNAME);
        }

        return $this->validateMXRecords();
    }

    /**
     * @param $value
     * @return bool
     */
    protected function splitEmail( $value ): bool
    {
        $value = is_string($value) ? $value : '';

        if ( strpos($value, '..') !== false
            || !preg_match('/^(.+)@([^@]+)$/', $value, $matches)
        ) {
            return false;
        }

        $this->localPart = $matches[1];
        $this->hostname = $matches[2];

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isValid( $value ): bool
    {
        if ( !is_string($value) ) {
            $this->addError(self::INVALID);
            return false;
        }

        if ( !$this->splitEmail($value) ) {
            $this->addError(self::INVALID_FORMAT);
            return false;
        }

        if ( ( strlen($this->localPart) > 64 ) || ( strlen($this->hostname) > 255 ) ) {
            $this->addError(self::LENGTH_EXCEEDED);
            return false;
        }

        if ( $this->validateLocalPart() && $this->validateHostnamePart() ) {
            return true;
        }

        return false;
    }
}