<?php

namespace TomCan\CombellApi\Structure\WindowsHostings;

class Binding
{
    private $name;
    private $protocol;
    private $ipAddress;
    private $port;
    private $sslEnabled;
    private $sslFingerprint;

    public function __construct(string $name, string $protocol, string $ipAddress, int $port, bool $sslEnabled, ?string $sslFingerprint)
    {
        $this->name = $name;
        $this->protocol = $protocol;
        $this->ipAddress = $ipAddress;
        $this->port = $port;
        $this->sslEnabled = $sslEnabled;
        $this->sslFingerprint = $sslFingerprint;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getProtocol() : string
    {
        return $this->protocol;
    }

    public function getIpAddress() : string
    {
        return $this->ipAddress;
    }

    public function getPort() : int
    {
        return $this->port;
    }

    public function getSslEnabled() : bool
    {
        return $this->sslEnabled;
    }

    public function getSslFingerprint() : ?string
    {
        return $this->sslFingerprint;
    }

}
