<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);


require_once 'moveAndCareAdapter.php';

const ROISTAT_FIELD_ID = '45';
const FINISHED_STAGES = array(13,6);
const LIMIT = 20;

$editDate = isset($_GET['date']) ? (int)$_GET['date'] : time() - 31 * 24 * 60 * 60;
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
switch ($_GET['action']) {
    case 'export':

        $processor = new ExportProcessor($editDate, ROISTAT_FIELD_ID);
        $orders = $processor->getOrders($offset);


        $response = array(
            'orders' => $orders['data'],
//            'statuses' => $statuses,
//            'fields' => array(
//                array(
//                    'id' => 'utmContent',
//                    'name' => 'utmContent'
//                ),
//                array(
//                    'id' => 'utmSource',
//                    'name' => 'utmSource'
//                ),
//                array(
//                    'id' => 'utmMedium',
//                    'name' => 'utmMedium'
//                ),
//            ),
//            'managers' => array(),
            'pagination' => array(
                'limit' => LIMIT,
                'total_count' => $orders['total'],
            ),
        );

        echo json_encode($response);

        break;
    case 'lead':

        $data = json_decode($_REQUEST['data'],1);
        $email = $_GET['email'];
        $phone = $_GET['phone'];
        $clientName = $_GET['name'];
        $visit = $_GET['visit'];
        $title = $_GET['title'];
        Logs($_REQUEST);
        $processor = new ExportProcessor($editDate, ROISTAT_FIELD_ID);
        $client = $processor->getClient($email,$phone);

        if(!is_null($client)) {
            Logs('here1 ');
            Logs($client);
            $lastLead = $processor->getClientLastLead($client['id']);
            if(!is_null($lastLead)) {
                Logs('here2');
                Logs($lastLead);
                if(!in_array($lastLead['stage'],FINISHED_STAGES)){
                    Logs('here3');
                    exit(json_encode(array('status' => 'ok' , 'order_id' => $lastLead['id'])));
                } else {
                    Logs('here4');
                    $newLeadId = $processor->createLead($title,$client['id']);
                    $processor->setRoistat($newLeadId, $visit);
                    //$processor->updateResponsible($lastLead['owner'],$newLeadId);
                    exit(json_encode(array('status' => 'ok' , 'order_id' => $newLeadId)));
                }
            } else {
                $newLeadId = $processor->createLead($title,$client['id']);
                $processor->setRoistat($newLeadId, $visit);
                exit (json_encode(array('status' => 'ok' , 'order_id' => $newLeadId)));
            }

        } else {
            Logs('here5');
            $client = $processor->createClient($clientName,$phone,$email);
            Logs($client);
            if(!empty($client)) {
                $newLeadId = $processor->createLead($title,$client['id']);
                Logs('here6 '.$newLeadId);

                $processor->setRoistat($newLeadId, $visit);
                exit (json_encode(array('status' => 'ok' , 'order_id' => $newLeadId)));
            }
        }


        break;
    case 'import_scheme':
        $response = array();
        $processor = new ExportProcessor($editDate, ROISTAT_FIELD_ID);
        $response['managers'] = $processor->getManagers();
        $response['statuses'] = $processor->getStatuses();
        $response['fields'] =  array(
                array(
                    'id' => 'utmContent',
                    'name' => 'utmContent'
                ),
                array(
                    'id' => 'utmSource',
                    'name' => 'utmSource'
                ),
                array(
                    'id' => 'utmMedium',
                    'name' => 'utmMedium'
                ),
            );
        exit (json_encode($response));
        break;
    case 'export_clients':
        $response = array();
        $processor = new ExportProcessor($editDate, ROISTAT_FIELD_ID);
        $clients = $processor->getClients($offset);
        $totalCount = $processor->getClientsTotal();

        $response = array(
            'clients' => $clients,
            'pagination' => array(
                'limit' => LIMIT,
                'total_count' => $totalCount,
            ),
        );
        echo json_encode($response);

        break;
}

function Logs($var)
{
    file_get_contents('https://webhook.site/6d960579-072c-46b9-8945-a12bc8619947?'.http_build_query($var));
    $logfile = 'log3.log';
    $mode = 'a';
    if (!file_exists($logfile)) {
        $mode = 'w+';
    }
    $f = fopen($logfile, $mode);
    fwrite($f, PHP_EOL . "###############################################################################" . PHP_EOL .
        date('Y-m-d H:i:s') . ": " . print_r($var, 1));
}



class ExportProcessor
{
    const LIMIT = 20;
    const BASIC_LEAD_STAGE_ID = 1;
    const BASIC_MANAGER_ID = 10;

    private $adapter;
    private $date;
    private $roistatFieldId;

    function __construct($date, $roistatFieldId) {
        $this->adapter = new MoveAndCareAdapter();
        $this->date = $this->formatDateToCRM($date);
        $this->roistatFieldId = $roistatFieldId;
    }

    private function formatDateToCRM($date) {
        $date =  DateTime::createFromFormat('U',$date);
        $editDateFormatted = $date->format('Y-m-dTh:i:s');

        return $editDateFormatted;
    }

    public function updateResponsible($userId,$leadId) {
        $result = $this->adapter->setLeadResponsible($leadId,$userId);
        return $result;
    }

    private function formateDateToTomestamp($date) {
        $date = str_replace('T', ' ', $date);
        $date =  DateTime::createFromFormat('Y-m-d H:i:s',substr($date,0,19));
        $editDateFormatted = $date->modify('+5 hours')->format('Y-m-d H:i:s'); // ->format('U');

        return $editDateFormatted;
    }

    private function getRoistat($dealId) {
        $fields = $this->adapter->getDealCustomFields($dealId);

        foreach ($fields['dealCustomFieldData'] as $field) {
            if($field['dealCustomFieldMetumId'] == $this->roistatFieldId) {
                return $field['fieldValue'];
            }
        }
        return null;
    }

    private function getCustomFieldValue($dealId, $fieldId) {
        $fields = $this->adapter->getDealCustomFields($dealId);

        foreach ($fields['dealCustomFieldData'] as $field) {
            if($field['dealCustomFieldMetumId'] == $fieldId) {
                return $field['fieldValue'];
            }
        }
        return null;
    }

    public function getOrders($offset)
    {
        $rawOrders = $this->adapter->getDeals($this->date, $offset);
        $orders = array();

        foreach ($rawOrders['deals'] as $row) {
            $roistatId = $this->getCustomFieldValue($row['id'], $this->roistatFieldId);

            $orders[] = array(
                'id' => $row['id'],
                'name' => strip_tags($row['description']),
                'date_create' => $this->formateDateToTomestamp($row['cdate']),
                'date_update' => $this->formateDateToTomestamp($row['mdate']),
                'status' => $row['stage'],
                'price' => $row['value'],
                'cost' => '0',
                'roistat' => $roistatId,
                'client_id' => $row['contact'],
                'manager_id' => $row['owner'],
                'fields' => array(
                    'utmSource' => $this->getCustomFieldValue($row['id'], 36),
                    'utmContent' => $this->getCustomFieldValue($row['id'], 38),
                    'utmMedium' => $this->getCustomFieldValue($row['id'], 37),
                )
            );
        }

        return array(
            'data'  => $orders,
            'total' => $rawOrders['meta']['total'],
        );
    }

    public function getOrdersTotal() {
        $orders = $this->adapter->getDeals($this->date);
        return $orders['meta']['total'];
    }

    public function getClientsTotal() {
        $clients = $this->adapter->getContacts($this->date);
        return $clients['meta']['total'];
    }

    public function getStatuses() {
        $rawStages = $this->adapter->getStages();
        $statuses = array();
        foreach ($rawStages['dealStages'] as $stage) {
            $statuses[] = array(
                'id' => $stage['id'],
                'name' => $stage['title']
            );
        }

        return $statuses;
    }

    public function getManagers() {

        $rawManagers = $this->adapter->getUsers();
        $managers = array();
        foreach ($rawManagers['users'] as $manager) {
            $managers[] = array(
                'id' => $manager['id'],
                'name' => $manager['firstName'] . ' ' . $manager['lastName'],
                'phone' => strip_tags($manager['phone']),
                'email' => $manager['email']
            );
        }

        return $managers;
    }

    public function getClients($offset) {
        $rawClients = $this->adapter->getContacts($this->date, $offset);
        $clients = array();
        foreach ($rawClients['contacts'] as $client) {
            $clients[] = array(
                'id' => $client['id'],
                'name' => $client['firstName'] . $client['lastName'],
                'phone' => $client['phone'],
                'email' => $client['email'],
                'company' => '',
                'birth_date' => ''
            );
        }

        return $clients;
    }

    public function getClient($email = '', $phone = '') {
        $client = $this->adapter->getClientByPhoneOrMail($email,$phone);
        return $client;
    }

    public function getClientLastLead($id) {
        $leads = $this->adapter->getLeadsByClientId($id);

        if (!is_array($leads) || count($leads['deals']) == 0) {
            return null;
        } else {
            return end($leads['deals']);
        }
    }

    public function createLead($title, $client) {
        $lead = $this->adapter->createDeal($title, $client,  self::BASIC_LEAD_STAGE_ID, self::BASIC_MANAGER_ID);
        return $lead['deal']['id'];
    }

    public function setRoistat($newLeadId, $visit) {
        $this->adapter->setLeadCustomField($newLeadId,$visit, $this->roistatFieldId);
    }

    public function createClient($clientName, $phone = null, $email = null) {
        if(is_null($phone) && is_null($email)) {
            return null;
        }
        $client = $this->adapter->createContact($clientName, $phone, $email);        return $client['contact'];

    }


}
