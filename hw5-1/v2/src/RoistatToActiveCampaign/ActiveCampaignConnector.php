<?php


namespace RoistatToActiveCampaign;


use RoistatToActiveCampaign\traits\CurlConnectorTrait;

class ActiveCampaignConnector implements CrmConnector
{

    use CurlConnectorTrait;

    function __construct($baseurl, $key)
    {
        $this->setBaseUrl($baseurl);
        $this->setAdditionalHeaders(array('Api-Token: ' . $key));
    }

    public function getLeads($params) : array
    {
        $method = 'deals?';
        $parameters = array(
            'filters' => array(
                'updated_after' => $this->formatDateToCRM($params['date']),
            ),
            'offset' => $params['offset'],
            'limit'  => $params['limit'],
        );

        return $this->getContent($method . http_build_query($parameters));
    }


    public function searchDeal($phone) : array
    {
        $method = 'deals?search=' . $phone;
        return $this->getContent($method);
    }

    public function getDealContact($dealId) : array
    {
        $method = 'deals/'.$dealId.'/contact?';
        return $this->getContent($method);
    }

    public function getDealStage($dealId) : array
    {
        $method = 'deals/'.$dealId.'/stage?';
        return $this->getContent($method);
    }

    public function getDealCustomFields($dealId) : array
    {
        $method = 'deals/'.$dealId.'/dealCustomFieldData?';
        return $this->getContent($method);
    }

    public function getCustomFieldValue($dealId, $fieldId) {
        $fields = $this->getDealCustomFields($dealId);

        foreach ($fields['dealCustomFieldData'] as $field) {
            if($field['dealCustomFieldMetumId'] == $fieldId) {
                return $field['fieldValue'];
            }
        }
        return null;
    }

    public function createCustomField($name)
    {
        $method = 'dealCustomFieldMeta';
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

        return $this->setContent($method, array(), $parameters);
    }

    public function getStatuses() : array
    {
        $method = 'dealStages';
        return $this->getContent($method);
    }

    public function getUsers() : array
    {
        $method = 'users';
        return $this->getContent($method);
    }

    public function getCustomFields() : array
    {
        $method = 'dealCustomFieldMeta';
        return $this->getContent($method);
    }

    public function getContacts($params) : array
    {
        $method = 'contacts?';
        $parameters = array(
            'filters' => array(
                'created_after' => $this->formatDateToCRM($params['date']),
                'nextdate_range' => 'upcoming'
            ),
            'offset' => $params['offset']
        );

        return $this->getContent($method . http_build_query($parameters));

    }

    public function getClient($email, $phone) : array
    {
        $method = 'contacts?';
        $params = array(
            'search' => $phone
        );
        $contacts = $this->getContent($method . http_build_query($params));

        if(!is_array($contacts) || $contacts['meta']['total'] == 0) {
            if(!empty($email)) {
                $params = array(
                    'search' => $email
                );
                $contacts = $this->getContent($method . http_build_query($params));
                if(!is_array($contacts)|| $contacts['meta']['total'] == 0) {
                    return array();
                }
            }
            else {
                return array();
            }

        }

        return $contacts['contacts'][0];
    }

    public function getLeadsByClientId($clientId) : array
    {
        $method = 'contacts/'.$clientId.'/deals';
        return $this->getContent($method);
    }

    public function createDeal($title, $clientId, $stage, $manager) : array
    {
        $method = 'deals';
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
        $deal = $this->setContent($method, array(), $params);

        return $deal;
    }

    public function setLeadCustomField($leadId, $fieldValue, $fieldId)
    {
        $method = 'dealCustomFieldData';
        $params = array(
            'dealCustomFieldDatum' => array(
                'dealId' => $leadId,
                'fieldValue' => $fieldValue,
                'customFieldId' => $fieldId
            )
        );

        return $this->setContent($method, array(), $params);
    }

    public function setLeadResponsible($leadId, $userId)
    {
        $method =  'deals/'.$leadId;
        $params = array(
            'deal' => array(
                'owner' => $userId,
            )
        );

        return $this->putContent($method, array(), $params);
    }

    public function createContact($clientName, $phone, $email = null)
    {
        if(empty($email)) {
            $email = $phone . '@Fakemail.com';
        }

        $method = 'contacts';
        $params = array(
            'contact' => array(
                'email' => $email,
                'firstName' => $clientName,
                'phone' => $phone
            )
        );

        $contact = $this->setContent($method, array(), $params);

        return $contact;
    }

    public function formatDateToCRM($date) {
        $date =  \DateTime::createFromFormat('U',$date);
        $editDateFormatted = $date->format('Y-m-dTh:i:s');

        return $editDateFormatted;
    }


    public function formateDateToTomestamp($date) {
        $date = str_replace('T', ' ', $date);
        $date =  \DateTime::createFromFormat('Y-m-d H:i:s',substr($date,0,19));
        $editDateFormatted = $date->modify('+5 hours')->format('Y-m-d H:i:s');

        return $editDateFormatted;
    }

    public function getTotal($instance) : int {
        return $instance['meta']['total'];
    }

    public function createLead(array $basicParams,$clientId)
    {
        $url = 'deals';
        $params = array(
            'deal' => array(
                'title' => $basicParams['title'],
                'contact' => $clientId,
                'value' => 0,
                'currency' => 'usd',
                'stage' => $basicParams['status'],
                'owner' => $basicParams['manager'],
            )
        );
        $lead = $this->setContent($url, array(), $params);

        return $lead['deal']['id'];
    }

    public function setCustomField($leadId, $fieldId, $value)
    {
        $url = 'dealCustomFieldData';
        $params = array(
            'dealCustomFieldDatum' => array(
                'dealId' => $leadId,
                'fieldValue' => $value,
                'customFieldId' => $fieldId
            )
        );

        return $this->setContent($url, $params);
    }

    public function createClient($clientName, $phone, $email)
    {
        if(empty($email)) {
            $email = $phone . '@Fakemail.com';
        }

        $url = 'contacts';
        $params = array(
            'contact' => array(
                'email' => $email,
                'firstName' => $clientName,
                'phone' => $phone
            )
        );

        $contact = $this->setContent($url, array(), $params);

        return $contact;
    }
}