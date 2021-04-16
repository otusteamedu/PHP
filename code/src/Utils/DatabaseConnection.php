<?php


namespace App\Utils;


class DatabaseConnection implements DatabaseConnectionInterface
{
    private DatabaseConfiguration $configuration;

    /**
     * DatabaseConnection constructor.
     * @param DatabaseConfiguration $configuration
     */
    public function __construct(DatabaseConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getDsn(): string
    {
        return sprintf(
            '%s:host=%s;port=%d;dbname=%s;user=%s;password=%s',
            $this->configuration->getDriver(),
            $this->configuration->getHost(),
            $this->configuration->getPort(),
            $this->configuration->getDbName(),
            $this->configuration->getUsername(),
            $this->configuration->getPassword()
        );
    }


}
