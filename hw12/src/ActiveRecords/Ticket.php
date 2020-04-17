<?php


namespace HW\ActiveRecords;


class Ticket extends ActiveRecord
{

    protected static function getTableName()
    {
        return 'tickets';
    }

    protected static function getFieldsNames()
    {
        return ['offer_id', 'place_id', 'customer_id', 'date'];
    }

    public function getOfferId()
    {
        return $this->getFieldValue('offer_id');
    }

    /**
     * @param mixed $offerId
     */
    public function setOfferId($offerId)
    {
        $this->setFieldValue('offer_id', $offerId);
    }

    /**
     * @return mixed
     */
    public function getPlaceId()
    {
        return $this->getFieldValue('place_id');
    }

    public function setPlaceId($placeId)
    {
        $this->setFieldValue('place_id', $placeId);
    }

    public function getCustomerId()
    {
        return $this->getFieldValue('customer_id');
    }

    public function setCustomerId($customerId)
    {
        $this->setFieldValue('customer_id', $customerId);
    }

    public function getDate()
    {
        return $this->getFieldValue('date');
    }

    public function setDate($date)
    {
        $this->setFieldValue('date', $date);
    }







}