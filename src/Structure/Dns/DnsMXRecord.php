<?php

namespace TomCan\CombellApi\Structure\Dns;

class DnsMXRecord extends AbstractDnsRecord
{
    private $content;
    private $priority;

    public function __construct(string $id = '', string $hostname = '', int $ttl = 3600, string $content = '', int $priority = 10)
    {
        parent::__construct($id, 'MX', $hostname, $ttl);
        $this->setContent($content);
        $this->setPriority($priority);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {

        try {
            $filtered = $this->validateHostname($content);
            $this->content = $filtered;
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException('Invalid value for content: "'.$content.'"');
        }

    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getObject(): \stdClass
    {
        $obj = parent::getObject();
        $obj->content = $this->getContent();
        $obj->priority = $this->getPriority();

        return $obj;
    }
}
