<?php

namespace TomCan\CombellApi\Structure\Dns;

class DnsSOARecord extends AbstractDnsRecord
{
    private $content;

    private $master;
    private $responsible;
    private $serial;
    private $refresh;
    private $retry;
    private $expire;
    private $minimum;

    public function __construct(string $id = '', string $hostname = '', int $ttl = 3600, string $content = '')
    {
        parent::__construct($id, 'SOA', $hostname, $ttl);
        $this->setContent($content);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->parseContent($content);
        $this->content = $content;
    }

    public function getMaster(): string
    {
        return $this->master;
    }

    public function setMaster(string $master, bool $buildContent = true): void
    {
        $this->master = $this->validateHostname($master, false);
        if ($buildContent) {
            $this->buildContent();
        }
    }

    public function getResponsible(): string
    {
        return $this->responsible;
    }

    public function setResponsible(string $responsible, bool $buildContent = true): void
    {
        $this->responsible = $this->validateHostname($responsible, false);
        if ($buildContent) {
            $this->buildContent();
        }
    }

    public function getSerial()
    {
        return $this->serial;
    }

    public function setSerial($serial, bool $buildContent = true): void
    {
        $this->serial = $this->validateUInt32($serial);
        if ($buildContent) {
            $this->buildContent();
        }
    }

    public function getRefresh()
    {
        return $this->refresh;
    }

    public function setRefresh($refresh, bool $buildContent = true): void
    {
        $this->refresh = $this->validateUInt32($refresh);
        if ($buildContent) {
            $this->buildContent();
        }
    }

    public function getRetry()
    {
        return $this->retry;
    }

    public function setRetry($retry, bool $buildContent = true): void
    {
        $this->retry = $this->validateUInt32($retry);
        if ($buildContent) {
            $this->buildContent();
        }
    }

    public function getExpire()
    {
        return $this->expire;
    }

    public function setExpire($expire, bool $buildContent = true): void
    {
        $this->expire = $this->validateUInt32($expire);
        if ($buildContent) {
            $this->buildContent();
        }
    }

    public function getMinimum()
    {
        return $this->minimum;
    }

    public function setMinimum($minimum, bool $buildContent = true): void
    {
        $this->minimum = $this->validateUInt32($minimum);
        if ($buildContent) {
            $this->buildContent();
        }
    }

    private function buildContent(): void
    {
        $this->content = $this->master.' '.$this->responsible.' '.$this->serial.' '.$this->refresh.' '.$this->retry.' '.$this->expire.' '.$this->minimum;
    }

    private function parseContent($content)
    {
        $arr = explode(' ', $content);

        if (7 !== count($arr)) {
            throw new \InvalidArgumentException('Invalid content. Content should have exactly 7 fields. '.print_r($arr, true));
        } else {
            // store original values for rollback
            $org = [$this->master, $this->responsible, $this->serial, $this->refresh, $this->retry, $this->expire, $this->minimum];
            try {
                $this->setMaster($arr[0], false);
                $this->setResponsible($arr[1], false);
                $this->setSerial($arr[2], false);
                $this->setRefresh($arr[3], false);
                $this->setRetry($arr[4], false);
                $this->setExpire($arr[5], false);
                $this->setMinimum($arr[6], false);
            } catch (\Exception $exception) {
                // restore original values
                $this->master = $org[0];
                $this->responsible = $org[1];
                $this->serial = $org[2];
                $this->refresh = $org[3];
                $this->retry = $org[4];
                $this->expire = $org[5];
                $this->minimum = $org[6];
                // bubble up exception
                throw $exception;
            }
        }
    }

    public function getObject(): \stdClass
    {
        $obj = parent::getObject();
        $obj->content = $this->getContent();

        return $obj;
    }
}
