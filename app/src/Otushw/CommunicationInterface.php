<?php


namespace Otushw;

/**
 * Interface CommunicationInterface
 *
 * @package Otushw
 */
interface CommunicationInterface
{
    public function prepareConnection(): void;

    public function connectToReadyConnection(): void;

    public function recieve(): string;

    public function send(string $raw): void;

    public function disconnectConnection(): void;
}