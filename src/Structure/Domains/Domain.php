<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 20/03/2018
 * Time: 0:17
 */

namespace TomCan\CombellApi\Structure\Domains;


class Domain
{

    private $domainname;
    private $expirationDate;
    private $willRenew;
    private $nameservers;

    /**
     * Domain constructor.
     * @param $domainname
     * @param $expirationDate
     * @param $willRenew
     * @param $nameservers
     */
    public function __construct($domainname, $expirationDate = null, $willRenew = null, $nameservers = null)
    {
        $this->domainname = $domainname;
        $this->expirationDate = $expirationDate;
        $this->willRenew = $willRenew;
        $this->nameservers = $nameservers;
    }

    /**
     * @return mixed
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param mixed $domainname
     */
    public function setDomainname($domainname)
    {
        $this->domainname = $domainname;
    }

    /**
     * @return null
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param null $expirationDate
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * @return null
     */
    public function getWillRenew()
    {
        return $this->willRenew;
    }

    /**
     * @param null $willRenew
     */
    public function setWillRenew($willRenew)
    {
        $this->willRenew = $willRenew;
    }

    /**
     * @return array
     */
    public function getNameservers()
    {
        return $this->nameservers;
    }

    /**
     * @param array $nameservers
     */
    public function setNameservers(array $nameservers)
    {
        $this->nameservers = $nameservers;
    }

}