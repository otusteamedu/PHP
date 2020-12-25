<?php

class MoveAndCareAdapter
{
    private $baseUrl;
    private $key;

    function __construct() {
        $this->baseUrl = 'https://move-and-care.api-us1.com/api/3/';
        $this->key = 'ba02c260195344a08a64d294d8d5825a9804ed613f2d82743b82a109970d3477cc61ecee';
    }

    private function getContents($url) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Api-Token: '.$this->key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output,1);
    }

    private function setContent($url, $params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Api-Token: '.$this->key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output,1);
    }

    private function putContent($url, $params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Api-Token: '.$this->key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output,1);
    }



    public function getDeals($date, $offset = 0) {
        $url = 'deals?';
        $parameters = array(
                'filters' => array(
                    'updated_after' => $date,
//                    'nextdate_range' => 'upcoming'
                ),
                'offset' => isset($_GET['offset']) ? $_GET['offset'] : 0,
                'limit'  => 20,
        );

        $deals = $this->getContents( $url . http_build_query($parameters));

        return $deals;
    }

    public function searchDeal($phone) {
        $url = 'deals?search=' . $phone;

        $deals = $this->getContents( $url );

        return $deals;
    }

    public function getDealContact($dealId) {
        $url = 'deals/'.$dealId.'/contact?';
        $contact = $this->getContents( $url);
        return $contact;
    }

    public function getDealStage($dealId) {
        $url = 'deals/'.$dealId.'/stage?';
        $stage = $this->getContents( $url );

        return $stage;
    }

    public function getDealCustomFields($dealId) {
        $url = 'deals/'.$dealId.'/dealCustomFieldData?';
        $fields = $this->getContents( $url );

        return $fields;
    }



    public function createCustomField($name) {
        $url = 'dealCustomFieldMeta';
        $parameters = array(
            'dealCustomFieldMetum' => array(
                'fieldLabel' => $name,
                'fieldType' => 'text',
                'fieldDefault' => '',
                'isFormVisible' => 1,
                'isRequired' => 0,
                'displayOrder' => 1
            )
        );

        $info = $this->setContent($url, $parameters);

        return $info;

    }

    public function getStages() {
        $url = 'dealStages';
        $stages = $this->getContents($url);

        return $stages;
    }

    public function getUsers() {
        $url = 'users';
        $users = $this->getContents($url);

        return $users;
    }


    public function getCustomFields() {
        $url = 'dealCustomFieldMeta';
        $fields = $this->getContents($url);

        return $fields;
    }

    public function getContacts($date,$offset = 0) {
        $url = 'contacts?';
        $params = array(
            'filters' => array(
                'created_after' => $date,
                'nextdate_range' => 'upcoming'
            ),
            'offset' => $offset
        );

        $contacts = $this->getContents($url . http_build_query($params));

        return $contacts;

    }

    public function getClientByPhoneOrMail($email, $phone) {
        $url = 'contacts?';
        $params = array(
            'search' => $phone
        );
        $contacts = $this->getContents($url . http_build_query($params));
        if(!is_array($contacts)||$contacts['meta']['total'] == 0) {
            if(!empty($email)) {
                $params = array(
                    'search' => $email
                );
                $contacts = $this->getContents($url . http_build_query($params));
                if(!is_array($contacts)|| $contacts['meta']['total'] == 0) {
                    return null;
                }
            }
            else {
                return null;
            }

        }

        return $contacts['contacts'][0];
    }

    public function getLeadsByClientId($clientId) {
        $url = 'contacts/'.$clientId.'/deals';
        $deals = $this->getContents($url);
        return $deals;
    }

    public function createDeal($title, $clientId, $stage,$manager) {
        $url = 'deals';
        $params = array(
            'deal' => array(
                'title' => $title,
                'contact' => $clientId,
                'value' => 0,
                'currency' => 'usd',
                'stage' => $stage,
                'owner' => $manager,
            )
        );
        $deal = $this->setContent($url,$params);

        return $deal;

    }

    public function setLeadCustomField($leadId, $visit, $roistatFieldId) {
        $url = 'dealCustomFieldData';
        $params = array(
            'dealCustomFieldDatum' => array(
                'dealId' => $leadId,
                'fieldValue' => $visit,
                'customFieldId' => $roistatFieldId
            )
        );

        return $this->setContent($url, $params);
    }

    public function setLeadResponsible($leadId, $userId) {
        $url = 'deals/'.$leadId;
        $params = array(
            'deal' => array(
                'owner' => $userId,
            )
        );

        return $this->putContent($url, $params);
    }

    public function createContact($clientName, $phone, $email = null) {
        if(empty($email)) {
            $email = $phone . '@Fakemail.com';
        }

        if(strpos($clientName,'Звонок') !== false) {
            $clientName = 'Call from '. $phone;
        }

        $url = 'contacts';
        $params = array(
          'contact' => array(
              'email' => $email,
              'firstName' => $clientName,
              'phone' => $phone
          )
        );

        $contact = $this->setContent($url, $params);

        return $contact;
    }

}