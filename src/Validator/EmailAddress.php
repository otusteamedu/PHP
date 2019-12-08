<?php

namespace AnrDaemon\Validator;

class EmailAddress
{
  public function validateSyntax($address)
  {
    $tail = \strrchr($address, "@");

    if(\strlen($tail) === \strlen($address))
    {
      throw new \UnexpectedValueException("No user part of address in '{$address}'");
    }

    if(strlen($tail) < 2)
    {
      throw new \UnexpectedValueException("No domain part of address in '{$address}'");
    }

    return true;
  }

  public function validateDomain($address)
  {
    $domain = \idn_to_ascii(\substr(\strrchr($address, "@"), 1), \IDNA_DEFAULT, \INTL_IDNA_VARIANT_UTS46);

    if(!(\checkdnsrr($domain, 'MX') || \checkdnsrr($domain, 'A') || \checkdnsrr($domain, 'AAAA')))
    {
      throw new \UnexpectedValueException("No MX/A/AAAA DNS RR found for domain '{$domain}' of address '{$address}'");
    }

    return true;
  }

  public function validate($address)
  {
    return $this->validateSyntax($address) && $this->validateDomain($address);
  }
}
