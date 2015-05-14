<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhealDoctrineCache
 *
 * @ORM\Table(indexes={@ORM\Index(name="search_cache", columns={"userId", "scope", "name", "args"})})
 * @ORM\Entity(repositoryClass = "\AppBundle\Entity\PhealCacheRepository")
 */
class PhealDoctrineCache
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="scope", type="string", length=50)
     */
    private $scope;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="args", type="string", length=255)
     */
    private $args;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cachedUntil", type="datetimetz")
     */
    private $cachedUntil;

    /**
     * @var string
     *
     * @ORM\Column(name="xml", type="text")
     */
    private $xml;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return PhealDoctrineCache
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set scope
     *
     * @param string $scope
     * @return PhealDoctrineCache
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return string 
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return PhealDoctrineCache
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set args
     *
     * @param string $args
     * @return PhealDoctrineCache
     */
    public function setArgs($args)
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Get args
     *
     * @return string 
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Set cachedUntil
     *
     * @param \DateTime $cachedUntil
     * @return PhealDoctrineCache
     */
    public function setCachedUntil($cachedUntil)
    {
        $this->cachedUntil = $cachedUntil;

        return $this;
    }

    /**
     * Get cachedUntil
     *
     * @return \DateTime 
     */
    public function getCachedUntil()
    {
        return $this->cachedUntil;
    }

    /**
     * Set xml
     *
     * @param string $xml
     * @return PhealDoctrineCache
     */
    public function setXml($xml)
    {
        $this->xml = $xml;

        return $this;
    }

    /**
     * Get xml
     *
     * @return string 
     */
    public function getXml()
    {
        return $this->xml;
    }
}
