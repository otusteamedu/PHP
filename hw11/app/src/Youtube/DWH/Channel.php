<?php


namespace Youtube\DWH;


class Channel extends Item
{
    public function getTitle()
    {
        return $this->data['title'] ?? '';
    }

    public function setTitle($title)
    {
        $this->data['title'] = $title;
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data = array_merge($data, $this->data);
        return $data;
    }


}