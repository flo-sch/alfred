<?php

namespace Fsb\Alfred\CoreBundle\Entity;

use \Serializable;
use \DateTime;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;

/**
 * Driver
 *
 * @ORM\Table(name="drivers")
 * @ORM\Entity(repositoryClass="Fsb\Alfred\CoreBundle\Entity\DriverRepository")
 */
class Driver implements AdvancedUserInterface, Serializable
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Constraints\NotBlank()
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, unique=true)
     * @Constraints\NotBlank()
     * @Constraints\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $carName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $color;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="would_manage_gasoil", type="boolean")
     */
    private $wouldManageGasoil;

    /**
     * @var boolean
     *
     * @ORM\Column(name="would_manage_highway", type="boolean")
     */
    private $wouldManageHighway;

    /**
     * @var boolean
     *
     * @ORM\Column(name="would_manage_insurance_fee", type="boolean")
     */
    private $wouldManageInsuranceFee;

    /**
     * @var boolean
     *
     * @ORM\Column(name="would_manage_reparations", type="boolean")
     */
    private $wouldManageReparations;

    /**
     * @var integer
     *
     * @ORM\Column(name="initial_kilometers", type="integer")
     */
    private $initialKilometers;

    /**
     * @var integer
     *
     * @ORM\Column(name="current_kilometers", type="integer")
     */
    private $currentKilometers;

    /**
     * @var string
     *
     * @ORM\Column(name="lost_password_token", type="string", nullable=true)
     */
    private $lostPasswordToken;

    /**
     * @var string
     */
    private $currentPassword;

    /**
     * @var string
     */
    private $newPassword;

    /**
     * Public constructor
     *
     * @return User
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->isActive = true;
        $this->salt = sha1(uniqid(null, true));
        $this->wouldManageGasoil = true;
        $this->wouldManageHighway = true;
        $this->wouldManageInsuranceFee = true;
        $this->wouldManageReparations = true;
        $this->initialKilometers = 0;
        $this->currentKilometers = 0;

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
     * @return User
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
     * @return User
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
     * @return User
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
     * Set username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set carName
     *
     * @param string $carName
     * @return User
     */
    public function setCarName($carName)
    {
        $this->carName = $carName;

        return $this;
    }

    /**
     * Get carName
     *
     * @return string
     */
    public function getCarName()
    {
        return $this->carName;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return User
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set wouldManageGasoil
     *
     * @param boolean $wouldManageGasoil
     * @return Driver
     */
    public function setWouldManageGasoil($wouldManageGasoil)
    {
        $this->wouldManageGasoil = $wouldManageGasoil;

        return $this;
    }

    /**
     * Get wouldManageGasoil
     *
     * @return boolean
     */
    public function getWouldManageGasoil()
    {
        return $this->wouldManageGasoil;
    }

    /**
     * getWouldManageGasoil
     *
     * @return boolean
     */
    public function wouldManageGasoil()
    {
        return $this->wouldManageGasoil;
    }

    /**
     * Set wouldManageHighway
     *
     * @param boolean $wouldManageHighway
     * @return Driver
     */
    public function setWouldManageHighway($wouldManageHighway)
    {
        $this->wouldManageHighway = $wouldManageHighway;

        return $this;
    }

    /**
     * Get wouldManageHighway
     *
     * @return boolean
     */
    public function getWouldManageHighway()
    {
        return $this->wouldManageHighway;
    }

    /**
     * getWouldManageHighway alias
     *
     * @return boolean
     */
    public function wouldManageHighway()
    {
        return $this->wouldManageHighway;
    }

    /**
     * Set wouldManageInsuranceFee
     *
     * @param boolean $wouldManageInsuranceFee
     * @return Driver
     */
    public function setWouldManageInsuranceFee($wouldManageInsuranceFee)
    {
        $this->wouldManageInsuranceFee = $wouldManageInsuranceFee;

        return $this;
    }

    /**
     * Get wouldManageInsuranceFee
     *
     * @return boolean
     */
    public function getWouldManageInsuranceFee()
    {
        return $this->wouldManageInsuranceFee;
    }

    /**
     * getWouldManageInsuranceFee alias
     *
     * @return boolean
     */
    public function wouldManageInsuranceFee()
    {
        return $this->wouldManageInsuranceFee;
    }

    /**
     * Set wouldManageReparations
     *
     * @param boolean $wouldManageReparations
     * @return Driver
     */
    public function setWouldManageReparations($wouldManageReparations)
    {
        $this->wouldManageReparations = $wouldManageReparations;

        return $this;
    }

    /**
     * Get wouldManageReparations
     *
     * @return boolean
     */
    public function getWouldManageReparations()
    {
        return $this->wouldManageReparations;
    }

    /**
     * getWouldManageReparations alias
     *
     * @return boolean
     */
    public function wouldManageReparations()
    {
        return $this->wouldManageReparations;
    }

    /**
     * Set initialKilometers
     *
     * @param integer $initialKilometers
     * @return Driver
     */
    public function setInitialKilometers($initialKilometers)
    {
        $this->initialKilometers = $initialKilometers;

        return $this;
    }

    /**
     * Get initialKilometers
     *
     * @return integer
     */
    public function getInitialKilometers()
    {
        return $this->initialKilometers;
    }

    /**
     * Set currentKilometers
     *
     * @param integer $currentKilometers
     * @return Driver
     */
    public function setCurrentKilometers($currentKilometers)
    {
        $this->currentKilometers = $currentKilometers;

        return $this;
    }

    /**
     * Get currentKilometers
     *
     * @return integer
     */
    public function getCurrentKilometers()
    {
        return $this->currentKilometers;
    }

    /**
     * Set lostPasswordToken
     *
     * @param string $lostPasswordToken
     * @return Driver
     */
    public function setLostPasswordToken($lostPasswordToken)
    {
        $this->lostPasswordToken = $lostPasswordToken;

        return $this;
    }

    /**
     * Get lostPasswordToken
     *
     * @return string
     */
    public function getLostPasswordToken()
    {
        return $this->lostPasswordToken;
    }

    /**
     * Get currentPassword
     *
     * @return string
     */
    public function getCurrentPassword()
    {
        return $this->currentPassword;
    }

    /**
     * Set currentPassword
     *
     * @param string $currentPassword
     * @return Driver
     */
    public function setCurrentPassword($currentPassword)
    {
        $this->currentPassword = $currentPassword;

        return $this;
    }

    /**
     * Get newPassword
     *
     * @return string
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * Set newPassword
     *
     * @param string $newPassword
     * @return Driver
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    /**
     * GetAccountNonExpired alias
     *
     * @return boolean
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * GetAccountNonLocked alias
     *
     * @return boolean
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * GetCredentialsNonExpired alias
     *
     * @return boolean
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * GetIsActive alias
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_DRIVER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
}
