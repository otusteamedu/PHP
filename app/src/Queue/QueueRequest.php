<?php


namespace App\Queue;


class QueueRequest extends QueueObject
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
