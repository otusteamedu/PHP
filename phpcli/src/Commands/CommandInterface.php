<?php


namespace App\Commands;

use App\Services\Socket\Socket;
use App\Commands\Entity\ResultInterface;

interface CommandInterface
{
    public function __construct(Socket $socket);
    public function getShortOptions(): string;
    public function getLongOptions(): array;
    public function run(array $options): ResultInterface;
}