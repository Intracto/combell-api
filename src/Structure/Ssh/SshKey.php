<?php

namespace TomCan\CombellApi\Structure\Ssh;

class SshKey
{
    private $publicKey;
    private $fingerprint;
    private $linuxHostings = [];

    public function __construct($publicKey, $fingerprint, array $linuxHostings)
    {
        $this->publicKey = $publicKey;
        $this->fingerprint = $fingerprint;
        $this->linuxHostings = $linuxHostings;
    }

    public function getPublicKey() : string
    {
        return $this->publicKey;
    }

    public function getFingerprint() : string
    {
        return $this->fingerprint;
    }

    public function getLinuxHostings(): array
    {
        return $this->linuxHostings;
    }

}
