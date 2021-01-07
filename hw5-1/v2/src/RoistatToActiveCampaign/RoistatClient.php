<?php


namespace RoistatToActiveCampaign;


class RoistatClient
{
    const LIMIT = 20;

    private $action;
    private $dataProvider;
    private $exportParams;
    private $leadCreationParams;

    public function __construct(string $action)
    {
        $this->action = $action;
        $crmConnector = new ActiveCampaignConnector(
            'https://move-and-care.api-us1.com/api/3/',
            'ba02c260195344a08a64d294d8d5825a9804ed613f2d82743b82a109970d3477cc61ece'
        );
        $this->dataProvider = new RoistatDataProvider($crmConnector);
    }


    public function getData()
    {
        switch ($this->action) {
            case 'export':
                $this->setExportParams();
                $this->dataProvider->exportLeads($this->exportParams);
                break;
            case 'lead':
                $this->setLeadCreationParams();
                $this->dataProvider->createLead($this->leadCreationParams);
                break;
            case 'import_scheme':
                $this->dataProvider->getScheme();
                break;
            case 'export_clients':
                $this->setExportParams();
                $this->dataProvider->exportClients($this->exportParams);
                break;
            default :
                $this->setExportParams();
                $this->dataProvider->exportLeads($this->exportParams);
                break;
        }
    }

    private function setExportParams()
    {
        $editDate = isset($_REQUEST['date']) ? $_REQUEST['date'] : time() - 31 * 24 * 60 * 60;
        $offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
        $limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : self::LIMIT;

        $this->exportParams = array(
            'limit' => $limit,
            'date' => $editDate,
            'offset' => $offset,
        );
    }

    private function setLeadCreationParams()
    {
        $this->leadCreationParams = array(
            'data' => json_decode($_REQUEST['data'],1),
            'email' => $_GET['email'],
            'phone' => $_GET['phone'],
            'clientName' => $_GET['name'],
            'visit' => $_GET['visit'],
            'title' => $_GET['title'],
        );
    }
}