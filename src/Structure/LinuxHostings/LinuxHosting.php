<?php

namespace TomCan\CombellApi\Structure\LinuxHostings;


class LinuxHosting
{

    private $domainName;
    private $servicepackId;
    private $maxWebspaceSize;
    private $maxSize;
    private $webspaceUsage;
    private $actualSize;
    private $ip;
    private $ipType;
    private $sshHost;
    private $ftpUserName;
    private $sshUserName;

    /**
     * LinuxHosting constructor.
     * @param $domain_name
     * @param $servicepackId
     * @param $maxWebspaceSize
     * @param $maxSize
     * @param $webspaceUsage
     * @param $actualSize
     * @param $ip
     * @param $ipType
     * @param $sshHost
     * @param $ftpUserName
     * @param $sshUserName
     */
    public function __construct(
        $domainName,
        $servicepackId,
        $maxWebspaceSize = null,
        $maxSize = null,
        $webspaceUsage = null,
        $actualSize = null,
        $ip = null,
        $ipType = null,
        $sshHost = null,
        $ftpUserName = null,
        $sshUserName = null
    ) {
        $this->domainName = $domainName;
        $this->servicepackId = $servicepackId;
        $this->maxWebspaceSize = $maxWebspaceSize;
        $this->maxSize = $maxSize;
        $this->webspaceUsage = $webspaceUsage;
        $this->actualSize = $actualSize;
        $this->ip = $ip;
        $this->ipType = $ipType;
        $this->sshHost = $sshHost;
        $this->ftpUserName = $ftpUserName;
        $this->sshUserName = $sshUserName;
    }

    /**
     * @return mixed
     */
    public function getDomainName()
    {
        return $this->domainName;
    }

    /**
     * @param mixed $domain_name
     */
    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;
    }

    /**
     * @return mixed
     */
    public function getServicepackId()
    {
        return $this->servicepackId;
    }

    /**
     * @param mixed $servicepackId
     */
    public function setServicepackId($servicepackId)
    {
        $this->servicepackId = $servicepackId;
    }

    /**
     * @return null
     */
    public function getMaxWebspaceSize()
    {
        return $this->maxWebspaceSize;
    }

    /**
     * @param null $maxWebspaceSize
     */
    public function setMaxWebspaceSize($maxWebspaceSize)
    {
        $this->maxWebspaceSize = $maxWebspaceSize;
    }

    /**
     * @return null
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @param null $maxSize
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    /**
     * @return null
     */
    public function getWebspaceUsage()
    {
        return $this->webspaceUsage;
    }

    /**
     * @param null $webspaceUsage
     */
    public function setWebspaceUsage($webspaceUsage)
    {
        $this->webspaceUsage = $webspaceUsage;
    }

    /**
     * @return null
     */
    public function getActualSize()
    {
        return $this->actualSize;
    }

    /**
     * @param null $actualSize
     */
    public function setActualSize($actualSize)
    {
        $this->actualSize = $actualSize;
    }

    /**
     * @return null
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param null $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return null
     */
    public function getIpType()
    {
        return $this->ipType;
    }

    /**
     * @param null $ipType
     */
    public function setIpType($ipType)
    {
        $this->ipType = $ipType;
    }

    /**
     * @return null
     */
    public function getSshHost()
    {
        return $this->sshHost;
    }

    /**
     * @param null $sshHost
     */
    public function setSshHost($sshHost)
    {
        $this->sshHost = $sshHost;
    }

    /**
     * @return null
     */
    public function getFtpHost()
    {
        return $this->sshUserName . '.webhosting.be';
    }

    /**
     * @return string|null
     */
    public function getFtpUserName()
    {
        return $this->ftpUserName;
    }

    /**
     * @param string|null $ftpUserName
     */
    public function setFtpUserName($ftpUserName)
    {
        $this->ftpUserName = $ftpUserName;
    }

    /**
     * @return string|null
     */
    public function getSshUserName()
    {
        return $this->sshUserName;
    }

    /**
     * @param string|null $sshUserName
     */
    public function setSshUserName($sshUserName)
    {
        $this->sshUserName = $sshUserName;
    }

}
