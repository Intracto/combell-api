<?php

namespace TomCan\CombellApi\Command\Accounts;

use TomCan\CombellApi\Command\AbstractCommand;

class CreateAccount extends AbstractCommand
{
    private $identifier;
    private $servicePack;
    private $password;

    public function __construct(string $identifier, int $servicePack, ?string $password = null)
    {
        parent::__construct('post', '/v2/accounts');

        $this->identifier = $identifier;
        $this->servicePack = $servicePack;
        if (null !== $password) {
            $this->setPassword($password);
        }
    }

    private function setPassword(string $password): void
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

        if (0 === ($uppers + $lowers) || 0 === $numbers) {
            throw new \InvalidArgumentException('Password must be a mix of letters and digits');
        }

        $this->password = $password;
    }

    public function prepare(): void
    {
        $obj = new \stdClass();
        $obj->identifier = $this->identifier;
        $obj->servicepack_id = $this->servicePack;

        if (!empty($this->password)) {
            $obj->ftp_password = $this->password;
        }

        $this->setBody((string) json_encode($obj));
    }

    public function processResponse(array $response)
    {
        $link = $response['headers']['Location'][0];
        $id = substr($link, strrpos($link, '/') + 1);

        return $id;
    }
}
