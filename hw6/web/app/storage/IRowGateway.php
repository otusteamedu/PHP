<?php

namespace storage;

interface IRowGateway
{
    public function getAttributes();
    public function insert();
    public function update();
    public function fetch();
    public function delete();

}