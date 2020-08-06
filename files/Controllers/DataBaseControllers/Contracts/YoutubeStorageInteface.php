<?php
namespace Contracts;

use Models\Task;

interface YoutubeStorageInteface
{
    public function store(Task $task);
    public function all();
    public function get($id);
    public function update(Task $task);
}