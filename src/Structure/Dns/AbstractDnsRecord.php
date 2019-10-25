<?php

namespace TomCan\CombellApi\Structure\Dns;

class AbstractDnsRecord
{
    protected $id;
    protected $type;
    protected $hostname;
    protected $ttl;

    public function __construct(string $id, string $type, string $hostname, int $ttl)
    {
        $this->id = $id;
        $this->type = $type;
        $this->setHostname($hostname);
        $this->setTtl($ttl);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function setHostname(string $hostname): void
    {
        try {
            $this->hostname = $this->validateHostname($hostname);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException('Invalid value for hostname: "'.$hostname.'"');
        }
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function setTtl(int $ttl): void
    {
        try {
            $this->ttl = $this->validateUInt32($ttl);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException('Invalid value for TTL: "'.$ttl.'"');
        }
    }

    public function getObject(): \stdClass
    {
        $obj = new \stdClass();
        $obj->id = $this->getId();
        $obj->record_name = $this->getHostname();
        $obj->type = $this->getType();
        $obj->ttl = $this->getTtl();

        return $obj;
    }

    protected function validateHostname(string $hostname, bool $allowOrigin = true): string
    {
        if ($allowOrigin && in_array($hostname, ['', '@'])) {
            return $hostname;
        } else {
            // remove leading underscores from labels, as we considder them valid, then send through filter_var
            $filtered = preg_replace('(^_|\._)', '', $hostname);
            $filtered = filter_var($filtered, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);

            // did the check pass and did we removed leading underscores? if so, use original value;
            if (false !== $filtered && $filtered !== $hostname) {
                $filtered = $hostname;
            }

            if (false !== $filtered) {
                return $filtered;
            } else {
                throw new \InvalidArgumentException();
            }
        }
    }

    private function validateInt(int $value, int $min, int $max): int
    {
        if ($value < $min || $value > $max) {
            throw new \InvalidArgumentException('Invalid value for range '.$min.' - '.$max.': "'.$value.'"');
        }

        return $value;
    }

    protected function validateUInt16(int $value): int
    {
        return $this->validateInt($value, 0, 65535);
    }

    protected function validateUInt32(int $value): int
    {
        return $this->validateInt($value, 0, 2147483647);
    }
}
