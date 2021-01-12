<?php


namespace RoistatToActiveCampaign;


interface CrmConnector
{
    public function getLeads(array $params) : array;
    public function getContacts(array $params) : array;
    public function getClient($email,$phone) : array;
    public function getStatuses() : array;
    public function getCustomFieldValue($dealId, $fieldId);
    public function getUsers() : array;
    public function createLead(array $params, $clientId);
    public function setCustomField($leadId, $fieldId, $value);
    public function createClient($clientName, $phone, $email);
    public function getTotal($instance) : int;
}