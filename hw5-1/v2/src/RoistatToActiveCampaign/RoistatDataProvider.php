<?php


namespace RoistatToActiveCampaign;


class RoistatDataProvider
{
    const ROISTAT_FIELD_ID = '45';
    const FINISHED_STAGES = array(13,6);
    const BASIC_LEAD_STAGE_ID = 1;
    const BASIC_MANAGER_ID = 10;
    const CUSTOM_FIELDS = array(
        'utmSource' =>  36,
        'utmContent' => 38,
        'utmMedium' => 37,
    );


    private $crmConnector;

    public function __construct(CrmConnector $crmConnector)
    {
        $this->crmConnector = $crmConnector;
    }

    public function exportLeads($params)
    {
        $rawOrders = $this->crmConnector->getLeads($params);
        $orders = array();

        foreach ($rawOrders['deals'] as $row) {
            $roistat = $this->crmConnector->getCustomFieldValue($row['id'], self::ROISTAT_FIELD_ID);

            $orders[] = array(
                'id' => $row['id'],
                'name' => strip_tags($row['description']),
                'date_create' => $this->crmConnector->formateDateToTomestamp($row['cdate']),
                'date_update' => $this->crmConnector->formateDateToTomestamp($row['mdate']),
                'status' => $row['stage'],
                'price' => $row['value'],
                'cost' => '0',
                'roistat' => $roistat,
                'client_id' => $row['contact'],
                'manager_id' => $row['owner'],
                'fields' => $this->setOrderCustomFields($row['id'])
            );
        }

        $orders['total'] = $this->crmConnector->getTotal($rawOrders);

        $response = array(
            'orders' => $orders,
            'pagination' => array(
                'limit' => $params['limit'],
                'total_count' => $orders['total'],
            ),
        );

        echo json_encode($response);
    }


    public function createLead($params)
    {
        $params['status'] = self::BASIC_LEAD_STAGE_ID;
        $params['manager'] = self::BASIC_MANAGER_ID;
        $client = $this->crmConnector->getClient($params['email'],$params['phone']);

        if(!is_null($client)) {
            $lastLead = $this->getClientLastLead($client['id']);
            if(!is_null($lastLead)) {
                if(!in_array($lastLead['stage'],self::FINISHED_STAGES)){
                    echo json_encode(array('status' => 'ok' , 'order_id' => $lastLead['id']));
                } else {
                    $newLeadId = $this->crmConnector->createLead($params, $client['id']);
                    $this->crmConnector->setCustomField($newLeadId, self::ROISTAT_FIELD_ID, $params['visit']);
                    echo json_encode(array('status' => 'ok' , 'order_id' => $newLeadId));
                }
            } else {
                $newLeadId = $this->crmConnector->createLead($params, $client['id']);
                $this->crmConnector->setCustomField($newLeadId, self::ROISTAT_FIELD_ID, $params['visit']);
                echo json_encode(array('status' => 'ok' , 'order_id' => $newLeadId));
            }

        } else {
            $client = $this->crmConnector->createClient($params['clientName'], $params['phone'], $params['email']);
            if(!empty($client)) {
                $newLeadId = $this->crmConnector->createLead($params, $client['id']);
                $this->crmConnector->setCustomField($newLeadId, self::ROISTAT_FIELD_ID, $params['visit']);
                echo json_encode(array('status' => 'ok' , 'order_id' => $newLeadId));
            }
        }
    }

    public function getScheme()
    {
        $response = array();
        $response['managers'] = $this->crmConnector->getUsers();
        $response['statuses'] = $this->crmConnector->getStatuses();
        $response['fields'] = $this->getPreparedFields();

        echo (json_encode($response));
    }

    public function exportClients($params)
    {
        $rawClients = $this->crmConnector->getContacts($params);
        $clients = array();
        foreach ($rawClients['contacts'] as $client) {
            $clients[] = array(
                'id' => $client['id'],
                'name' => $client['firstName'] . $client['lastName'],
                'phone' => $client['phone'],
                'email' => $client['email'],
            );
        }

        $totalCount = $this->crmConnector->getTotal($rawClients);

        $response = array(
            'clients' => $clients,
            'pagination' => array(
                'limit' => $params['limit'],
                'total_count' => $totalCount,
            ),
        );

        echo json_encode($response);
    }

    private function getPreparedFields() :array
    {
        $fields = array();
         foreach (self::CUSTOM_FIELDS as $name => $id) {
            array_push(
                $fields,
                array(
                    'id' => $id,
                    'name' => $name
                )
            );
        }
         return $fields;
    }

    private function setOrderCustomFields($leadId) : array
    {
        $fields = array();
        foreach (self::CUSTOM_FIELDS as $fieldName => $fieldId) {
            $fieldValue = $this->crmConnector->getCustomFieldValue($leadId,$fieldId);
            array_push($fields, array($fieldName => $fieldValue));
        }
        return $fields;
    }

    private function getClientLastLead($id) {
        $leads = $this->crmConnector->getLeadsByClientId($id);

        if (!is_array($leads) || count($leads['deals']) == 0) {
            return null;
        } else {
            return end($leads['deals']);
        }
    }

}