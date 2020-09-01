<?php


class ConnectionConfig
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string|null
     */
    private $authKey = null;

    public function __construct(string $address, int $port = 880, string $authKey = null)
    {
        $this->address = $address;
        $this->port = $port;
        $this->authKey = $authKey;
    }

    public function inAuthNeeded(): bool
    {
        return $this->authKey !== null;
    }

    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }

    public function getConnectionAddress(): string
    {
        return "$this->address:$this->port";
    }


}
