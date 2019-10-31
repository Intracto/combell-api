<?php

namespace TomCan\CombellApi\Structure\LinuxHostings;

class Site
{
    private $name;
    private $path;
    private $hostHeaders;
    private $sslEnabled;
    private $httpsRedirectEnabled;
    private $http2Enabled;

    public function __construct(
        string $name,
        string $path,
        array $hostHeaders,
        bool $sslEnabled,
        bool $httpsRedirectEnabled,
        bool $http2Enabled
    ) {
        $this->name = $name;
        $this->path = $path;
        $this->hostHeaders = $hostHeaders;
        $this->sslEnabled = $sslEnabled;
        $this->httpsRedirectEnabled = $httpsRedirectEnabled;
        $this->http2Enabled = $http2Enabled;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return HostHeader[]
     */
    public function getHostHeaders(): array
    {
        return $this->hostHeaders;
    }

    public function isSslEnabled(): bool
    {
        return $this->sslEnabled;
    }

    public function isHttpsRedirectEnabled(): bool
    {
        return $this->httpsRedirectEnabled;
    }

    public function isHttp2Enabled(): bool
    {
        return $this->http2Enabled;
    }
}
