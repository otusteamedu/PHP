<?php
namespace AZ\Zolotukhin\Mail;

interface CheckerInterface {
    public function mailCheck($email);
}

class Mailchecker implements CheckerInterface
{
    /**
     * @param $email string
     * @return array
     */
    public function mailCheck($email)
    {

        try {

            $result = false;

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return  [false, false];
            }

            list($user, $domain) = explode('@', $email);
            $response = dns_get_record($domain,DNS_MX);
            if(
                !empty($response)
                &&
                $response[0]['host'] === $domain
                &&
                !empty($response[0]['target'])
            )
            {
                $result = $response[0]['target'];
            }

            return [$result, $response];

        } catch (\Exception $e) {
            return [false, $e->getMessage()];
        }

    }

}