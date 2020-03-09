<?php

namespace App\Core;

class DbConnector
{
    private string $link;
    private string $dsn;
    private ?string $user;
    private ?string $pass;
    private ?array $parameters;

    /**
     * DbConnector constructor.
     * @param string $link
     */
    public function __construct(string $link)
    {
        $this->link = $link;
        $this->build();
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }

    /**
     * @return string|null
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function getPass(): ?string
    {
        return $this->pass;
    }

    /**
     * @return array|null
     */
    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    private function build()
    {
        $url = parse_url($this->link);
        parse_str($url['query'], $query);

        $this->user = $url['user'] ?? null;
        $this->pass = $url['pass'] ?? null;
        $this->dsn = "{$url['scheme']}:" . http_build_query(
                [
                    'host'    => $url['host'],
                    'port'    => $url['port'],
                    'dbname'  => trim($url['path'], '\\\/'),
                    'charset' => $query['charset'] ?? null,
                ],
                null,
                ';'
            );
        unset($query['charset']);
        $this->parameters = $query;
    }
}