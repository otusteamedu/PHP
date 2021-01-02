<?php
namespace RoistatToActiveCampaign;
class MoveAndCareAdapter
{
    public const BASEURL = 'https://move-and-care.api-us1.com/api/3/';
    public const KEY = 'ba02c260195344a08a64d294d8d5825a9804ed613f2d82743b82a109970d3477cc61ecee';

    use curlConnector;

    function __construct() {
    }

    public function getDeals($date, $offset = 0) {
        $url = self::BASEURL . 'deals?';
        $parameters = array(
                'filters' => array(
                    'updated_after' => $date,
                ),
                'offset' => isset($_GET['offset']) ? $_GET['offset'] : 0,
                'limit'  => 20,
        );

        $deals = $this->getContent($url . http_build_query($parameters), array('Api-Token: ' . self::KEY));

        return $deals;
    }

    public function searchDeal($phone) {
        $url = self::BASEURL . 'deals?search=' . $phone;

        $deals = $this->getContent($url, array('Api-Token: ' . self::KEY));

        return $deals;
    }

    public function getDealContact($dealId) {
        $url = self::BASEURL . 'deals/'.$dealId.'/contact?';
        $contact = $this->getContent($url, array('Api-Token: ' . self::KEY));
        return $contact;
    }

    public function getDealStage($dealId) {
        $url = self::BASEURL . 'deals/'.$dealId.'/stage?';
        $stage = $this->getContent($url, array('Api-Token: ' . self::KEY));

        return $stage;
    }

    public function getDealCustomFields($dealId) {
        $url = self::BASEURL . 'deals/'.$dealId.'/dealCustomFieldData?';
        $fields = $this->getContent($url, array('Api-Token: ' . self::KEY));

        return $fields;
    }



    public function createCustomField($name) {
        $url = self::BASEURL . 'dealCustomFieldMeta';
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

        $info = $this->setContent($url, array('Api-Token: ' . self::KEY), $parameters);

        return $info;

    }

    public function getStages() {
        $url = self::BASEURL . 'dealStages';
        $stages = $this->getContent($url, array('Api-Token: ' . self::KEY));

        return $stages;
    }

    public function getUsers() {
        $url = self::BASEURL . 'users';
        $users = $this->getContent($url, array('Api-Token: ' . self::KEY));

        return $users;
    }


    public function getCustomFields() {
        $url = self::BASEURL . 'dealCustomFieldMeta';
        $fields = $this->getContent($url, array('Api-Token: ' . self::KEY));

        return $fields;
    }

    public function getContacts($date,$offset = 0) {
        $url = self::BASEURL . 'contacts?';
        $params = array(
            'filters' => array(
                'created_after' => $date,
                'nextdate_range' => 'upcoming'
            ),
            'offset' => $offset
        );

        $contacts = $this->getContent($url . http_build_query($params), array('Api-Token: ' . self::KEY));

        return $contacts;

    }

    public function getClientByPhoneOrMail($email, $phone) {
        $url = self::BASEURL . 'contacts?';
        $params = array(
            'search' => $phone
        );
        $contacts = $this->getContent($url . http_build_query($params), array('Api-Token: ' . self::KEY));
        if(!is_array($contacts)||$contacts['meta']['total'] == 0) {
            if(!empty($email)) {
                $params = array(
                    'search' => $email
                );
                $contacts = $this->getContent($url . http_build_query($params), array('Api-Token: ' . self::KEY));
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
        $url = self::BASEURL . 'contacts/'.$clientId.'/deals';
        $deals = $this->getContent($url, array('Api-Token: ' . self::KEY));
        return $deals;
    }

    public function createDeal($title, $clientId, $stage,$manager) {
        $url = self::BASEURL . 'deals';
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
        $deal = $this->setContent($url, array('Api-Token: ' . self::KEY), $params);

        return $deal;

    }

    public function setLeadCustomField($leadId, $visit, $roistatFieldId) {
        $url = self::BASEURL . 'dealCustomFieldData';
        $params = array(
            'dealCustomFieldDatum' => array(
                'dealId' => $leadId,
                'fieldValue' => $visit,
                'customFieldId' => $roistatFieldId
            )
        );

        return $this->setContent($url, array('Api-Token: ' . self::KEY), $params);
    }

    public function setLeadResponsible($leadId, $userId) {
        $url = self::BASEURL . 'deals/'.$leadId;
        $params = array(
            'deal' => array(
                'owner' => $userId,
            )
        );

        return $this->putContent($url, array('Api-Token: ' . self::KEY), $params);
    }

    public function createContact($clientName, $phone, $email = null) {
        if(empty($email)) {
            $email = $phone . '@Fakemail.com';
        }

        if(strpos($clientName,'Звонок') !== false) {
            $clientName = 'Call from '. $phone;
        }

        $url = self::BASEURL . 'contacts';
        $params = array(
          'contact' => array(
              'email' => $email,
              'firstName' => $clientName,
              'phone' => $phone
          )
        );

        $contact = $this->setContent($url, array('Api-Token: ' . self::KEY), $params);

        return $contact;
    }

}