<?php

namespace Fsb\Alfred\CoreBundle\Entity;

use \Serializable;
use \DateTime;

use Doctrine\ORM\Mapping as ORM;

/**
 * InsuranceFee
 *
 * @ORM\Table(name="insurance_fees")
 * @ORM\Entity(repositoryClass="Fsb\Alfred\CoreBundle\Entity\InsuranceFeeRepository")
 */
class InsuranceFee
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
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="removed_at", type="datetime", nullable=true)
     */
    private $removedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_hidden", type="boolean")
     */
    private $isHidden;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="year", type="datetime")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=9, scale=5)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Driver")
     * @ORM\JoinColumn(name="driver_id", referencedColumnName="id")
     */
    private $driver;

    /**
     * Public constructor
     *
     * @return InsuranceFee
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->isHidden = false;
        $this->salt = sha1(uniqid(null, true));

        return $this;
    }

   /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }


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
     * Set createdAt
     *
     * @param DateTime $createdAt
     * @return InsuranceFee
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     * @return InsuranceFee
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set removedAt
     *
     * @param DateTime $removedAt
     * @return InsuranceFee
     */
    public function setRemovedAt($removedAt)
    {
        $this->removedAt = $removedAt;

        return $this;
    }

    /**
     * Get removedAt
     *
     * @return DateTime
     */
    public function getRemovedAt()
    {
        return $this->removedAt;
    }

    /**
     * Set isHidden
     *
     * @param boolean $isHidden
     * @return InsuranceFee
     */
    public function setIsHidden($isHidden)
    {
        $this->isHidden = $isHidden;

        return $this;
    }

    /**
     * Get isHidden
     *
     * @return boolean
     */
    public function getIsHidden()
    {
        return $this->isHidden;
    }

    /**
     * Set year
     *
     * @param DateTime $year
     * @return InsuranceFee
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return DateTime
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return InsuranceFee
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set driver
     *
     * @return InsuranceFee
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get driver
     *
     * @return Driver
     */
    public function getDriver()
    {
        return $this->driver;
    }
}
