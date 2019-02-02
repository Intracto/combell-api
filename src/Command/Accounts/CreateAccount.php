<?php

namespace TomCan\CombellApi\Command\Accounts;

use TomCan\CombellApi\Command\AbstractCommand;
use TomCan\CombellApi\Structure\ProvisioningJobs\ProvisioningJob;

class CreateAccount extends AbstractCommand
{
    private $identifier;
    private $servicePack;
    private $password;
    private $provisionJob;

    public function __construct(string $identifier, int $servicePack, ?string $password = null)
    {
        parent::__construct('post', '/v2/accounts');

        $this->setIdentifier($identifier);
        $this->setServicePack($servicePack);
        if ($password !== null) {
            $this->setPassword($password);
        }
    }

    public function prepare(): void
    {
        $obj = new \stdClass();
        $obj->identifier = $this->identifier;

        if (\is_object($this->servicePack) && isset($this->servicePack->id)) {
            $obj->servicepack_id = $this->servicePack->id;
        } else {
            $obj->servicepack_id = $this->servicePack;
        }

        if ($this->password !== '') {
            $obj->ftp_password = $this->password;
        }

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
        if (isset($response['headers']['Location'])) {
            $h = $response['headers']['Location'][0];
            $link = substr($h, strrpos($h, '/') + 1);
            $this->provisionJob = $link;
            $job = new ProvisioningJob($link, 'unknown');
            $response['response'] = $job;
        }

        return $response;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getServicePack(): int
    {
        return $this->servicePack;
    }

    public function setServicePack(int $servicePack): void
    {
        $this->servicePack = $servicePack;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $uppers = \strlen((string) preg_replace('/[^A-Z]/', '', $password));
        $lowers = \strlen((string) preg_replace('/[^a-z]/', '', $password));
        $numbers = \strlen((string) preg_replace('/\D/', '', $password));
        $others = \strlen((string) preg_replace('/[a-zA-Z0-9]/', '', $password));

        if ($others > 0) {
            throw new \InvalidArgumentException("Password can't contain special characters");
        }

        if (\strlen($password) < 8 || \strlen($password) > 20) {
            throw  new \InvalidArgumentException('Password must be between 8-20 characters long');
        }

        if (($uppers + $lowers) === 0 || $numbers === 0) {
            throw new \InvalidArgumentException('Password must be a mix of letters and digits');
        }

        $this->password = $password;
    }

    public function getProvisionJob()
    {
        return $this->provisionJob;
    }
}
