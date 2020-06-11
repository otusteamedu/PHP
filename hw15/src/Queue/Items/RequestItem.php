<?php


namespace App\Queue\Items;


class RequestItem extends QueueItem
{

    private $id;
    private $content;

    protected function toArray()
    {
        return ['id' => $this->id, 'content' => $this->content];
    }

    protected function initByArray($data)
    {
        $this->id = $data['id'];
        $this->content = $data['content'];
        return true;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}